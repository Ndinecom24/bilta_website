<?php

namespace App\Http\Livewire\Admin\DocumentsPage;

use App\Models\Bilta\Document;
use App\Models\Bilta\DocumentFolder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowDocuments extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Navigation
    public $currentFolderId = null;
    public $currentFolder = null;
    public $breadcrumbs = [];

    // Folder form
    public $showFolderForm = false;
    public $editingFolderId = null;
    public $folderName = '';
    public $folderDescription = '';

    // File upload
    public $uploadFiles = [];
    public $fileDescription = '';
    public $showUploadForm = false;

    // Rename
    public $renamingDocumentId = null;
    public $newDocumentName = '';

    // Search
    public $search = '';

    // Sort
    public $sortBy = 'name';
    public $sortDir = 'asc';

    protected $listeners = [
        'deleteFolder' => 'destroyFolder',
        'deleteDocument' => 'destroyDocument',
    ];

    public function mount($folderId = null)
    {
        if ($folderId) {
            $this->navigateToFolder($folderId);
        }
    }

    public function render()
    {
        $folders = DocumentFolder::where('parent_id', $this->currentFolderId)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $documentsQuery = Document::query();

        if ($this->currentFolderId) {
            $documentsQuery->where('folder_id', $this->currentFolderId);
        } else {
            // Show nothing at root, only folders
            $documentsQuery->whereRaw('1 = 0');
        }

        if ($this->search) {
            // Global search across all folders and documents
            $folders = DocumentFolder::where('name', 'like', '%' . $this->search . '%')->get();
            $documentsQuery = Document::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('original_name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        $documents = $documentsQuery
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(25);

        $folderTree = DocumentFolder::roots()
            ->with('allChildren')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('livewire.admin.documents-page.index', compact('folders', 'documents', 'folderTree'));
    }

    // ─── Folder Navigation ───────────────────────────────────────

    public function navigateToFolder($folderId)
    {
        $this->currentFolderId = $folderId;
        $this->currentFolder = $folderId ? DocumentFolder::find($folderId) : null;
        $this->breadcrumbs = $this->currentFolder ? $this->currentFolder->breadcrumb->toArray() : [];
        $this->search = '';
        $this->resetPage();
    }

    public function goToRoot()
    {
        $this->currentFolderId = null;
        $this->currentFolder = null;
        $this->breadcrumbs = [];
        $this->search = '';
        $this->resetPage();
    }

    // ─── Folder CRUD ─────────────────────────────────────────────

    public function toggleFolderForm()
    {
        $this->showFolderForm = !$this->showFolderForm;
        if (!$this->showFolderForm) {
            $this->resetFolderForm();
        }
    }

    public function createFolder()
    {
        $this->validate([
            'folderName' => 'required|string|max:255',
            'folderDescription' => 'nullable|string|max:500',
        ]);

        DocumentFolder::create([
            'name' => $this->folderName,
            'slug' => Str::slug($this->folderName),
            'parent_id' => $this->currentFolderId,
            'description' => $this->folderDescription,
            'created_by' => auth()->id(),
        ]);

        session()->flash('success', 'Folder created successfully.');
        $this->resetFolderForm();
        $this->showFolderForm = false;
    }

    public function editFolder($id)
    {
        $folder = DocumentFolder::findOrFail($id);
        $this->editingFolderId = $folder->id;
        $this->folderName = $folder->name;
        $this->folderDescription = $folder->description;
        $this->showFolderForm = true;
    }

    public function updateFolder()
    {
        $this->validate([
            'folderName' => 'required|string|max:255',
            'folderDescription' => 'nullable|string|max:500',
        ]);

        $folder = DocumentFolder::findOrFail($this->editingFolderId);
        $folder->update([
            'name' => $this->folderName,
            'slug' => Str::slug($this->folderName),
            'description' => $this->folderDescription,
        ]);

        session()->flash('success', 'Folder updated.');
        $this->resetFolderForm();
        $this->showFolderForm = false;
    }

    public function destroyFolder($id)
    {
        try {
            $folder = DocumentFolder::findOrFail($id);

            // Delete all documents inside
            foreach ($folder->documents as $doc) {
                Storage::disk('public')->delete($doc->file_path);
                $doc->delete();
            }

            $folder->delete();
            session()->flash('success', 'Folder deleted.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting folder: ' . $e->getMessage());
        }
    }

    // ─── File Upload ─────────────────────────────────────────────

    public function toggleUploadForm()
    {
        $this->showUploadForm = !$this->showUploadForm;
        if (!$this->showUploadForm) {
            $this->uploadFiles = [];
            $this->fileDescription = '';
        }
    }

    public function uploadDocuments()
    {
        $this->validate([
            'uploadFiles' => 'required|array|min:1',
            'uploadFiles.*' => 'file|max:51200', // 50MB max per file
            'fileDescription' => 'nullable|string|max:500',
        ]);

        if (!$this->currentFolderId) {
            session()->flash('error', 'Please navigate to a folder before uploading.');
            return;
        }

        try {
            foreach ($this->uploadFiles as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $storedPath = $file->store('documents', 'public');

                Document::create([
                    'name' => pathinfo($originalName, PATHINFO_FILENAME),
                    'original_name' => $originalName,
                    'file_path' => $storedPath,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'extension' => strtolower($extension),
                    'description' => $this->fileDescription,
                    'folder_id' => $this->currentFolderId,
                    'uploaded_by' => auth()->id(),
                ]);
            }

            session()->flash('success', count($this->uploadFiles) . ' file(s) uploaded successfully.');
            $this->uploadFiles = [];
            $this->fileDescription = '';
            $this->showUploadForm = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Upload error: ' . $e->getMessage());
        }
    }

    // ─── File Management ─────────────────────────────────────────

    public function startRename($docId)
    {
        $doc = Document::findOrFail($docId);
        $this->renamingDocumentId = $docId;
        $this->newDocumentName = $doc->name;
    }

    public function saveRename()
    {
        $this->validate(['newDocumentName' => 'required|string|max:255']);

        $doc = Document::findOrFail($this->renamingDocumentId);
        $doc->update(['name' => $this->newDocumentName]);

        $this->renamingDocumentId = null;
        $this->newDocumentName = '';
        session()->flash('success', 'File renamed.');
    }

    public function cancelRename()
    {
        $this->renamingDocumentId = null;
        $this->newDocumentName = '';
    }

    public function destroyDocument($id)
    {
        try {
            $doc = Document::findOrFail($id);
            Storage::disk('public')->delete($doc->file_path);
            $doc->delete();
            session()->flash('success', 'File deleted.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting file.');
        }
    }

    public function downloadDocument($id)
    {
        $doc = Document::findOrFail($id);
        return Storage::disk('public')->download($doc->file_path, $doc->original_name);
    }

    // ─── Sorting ─────────────────────────────────────────────────

    public function sortByColumn($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }

    // ─── Helpers ─────────────────────────────────────────────────

    private function resetFolderForm()
    {
        $this->editingFolderId = null;
        $this->folderName = '';
        $this->folderDescription = '';
    }
}

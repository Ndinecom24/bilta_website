<?php

namespace App\Http\Livewire\Admin\DocumentsPage;

use App\Models\Bilta\Department;
use App\Models\Bilta\Document;
use App\Models\Bilta\DocumentFolder;
use App\Models\Bilta\DocumentFolderAccess;
use App\Models\User;
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
    public $folderVisibility = 'everyone';
    public $folderDepartmentIds = [];
    public $folderUserIds = [];

    // File upload
    public $uploadFiles = [];
    public $fileDescription = '';
    public $showUploadForm = false;

    // Rename
    public $renamingDocumentId = null;
    public $newDocumentName = '';

    // Sharing modal
    public $showShareModal = false;
    public $sharingFolderId = null;
    public $sharingFolder = null;
    public $shareTargetType = 'department';
    public $shareTargetId = '';
    public $sharePermission = 'view';

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

        $documentsQuery = Document::with('uploader');

        if ($this->currentFolderId) {
            $documentsQuery->where('folder_id', $this->currentFolderId);
        } else {
            $documentsQuery->whereRaw('1 = 0');
        }

        if ($this->search) {
            $folders = DocumentFolder::where('name', 'like', '%' . $this->search . '%')->get();
            $documentsQuery = Document::with('uploader')
                ->where('name', 'like', '%' . $this->search . '%')
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

        $departments = Department::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('livewire.admin.documents-page.index', compact(
            'folders', 'documents', 'folderTree', 'departments', 'users'
        ));
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
            'folderVisibility' => 'required|in:everyone,department,specific,private',
        ]);

        $this->validateFolderVisibilityTargets();

        $folder = DocumentFolder::create([
            'name' => $this->folderName,
            'slug' => Str::slug($this->folderName),
            'parent_id' => $this->currentFolderId,
            'description' => $this->folderDescription,
            'visibility' => $this->folderVisibility,
            'created_by' => auth()->id(),
        ]);

        $this->syncFolderVisibilityTargets($folder);

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
        $this->folderVisibility = $folder->visibility;
        $this->folderDepartmentIds = $folder->accessEntries()
            ->where('target_type', 'department')
            ->pluck('target_id')
            ->map(fn ($id) => (string) $id)
            ->toArray();
        $this->folderUserIds = $folder->accessEntries()
            ->where('target_type', 'user')
            ->pluck('target_id')
            ->map(fn ($id) => (string) $id)
            ->toArray();
        $this->showFolderForm = true;
    }

    public function updateFolder()
    {
        $this->validate([
            'folderName' => 'required|string|max:255',
            'folderDescription' => 'nullable|string|max:500',
            'folderVisibility' => 'required|in:everyone,department,specific,private',
        ]);

        $this->validateFolderVisibilityTargets();

        $folder = DocumentFolder::findOrFail($this->editingFolderId);
        $folder->update([
            'name' => $this->folderName,
            'slug' => Str::slug($this->folderName),
            'description' => $this->folderDescription,
            'visibility' => $this->folderVisibility,
        ]);

        $this->syncFolderVisibilityTargets($folder);

        session()->flash('success', 'Folder updated.');
        $this->resetFolderForm();
        $this->showFolderForm = false;
    }

    public function destroyFolder($id)
    {
        try {
            $folder = DocumentFolder::findOrFail($id);

            foreach ($folder->documents as $doc) {
                Storage::disk('public')->delete($doc->file_path);
                $doc->delete();
            }

            $folder->accessEntries()->delete();
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
            'uploadFiles.*' => 'file|max:51200',
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
            $doc->shares()->delete();
            $doc->delete();
            session()->flash('success', 'File deleted.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting file.');
        }
    }

    public function downloadDocument($id)
    {
        $doc = Document::findOrFail($id);
        return response()->download(storage_path('app/public/' . $doc->file_path), $doc->original_name);
    }

    // ─── Sharing ─────────────────────────────────────────────────

    public function openShareModal($folderId)
    {
        $this->sharingFolderId = $folderId;
        $this->sharingFolder = DocumentFolder::with('accessEntries')->findOrFail($folderId);
        $this->shareTargetType = 'department';
        $this->shareTargetId = '';
        $this->sharePermission = 'view';
        $this->showShareModal = true;
    }

    public function closeShareModal()
    {
        $this->showShareModal = false;
        $this->sharingFolderId = null;
        $this->sharingFolder = null;
    }

    public function addShareEntry()
    {
        $this->validate([
            'shareTargetType' => 'required|in:department,user',
            'shareTargetId' => 'required|integer',
            'sharePermission' => 'required|in:view,edit,manage',
        ]);

        $folder = DocumentFolder::findOrFail($this->sharingFolderId);

        DocumentFolderAccess::where('folder_id', $folder->id)
            ->where('target_type', $this->shareTargetType)
            ->where('target_id', $this->shareTargetId)
            ->delete();

        DocumentFolderAccess::create([
            'folder_id' => $folder->id,
            'target_type' => $this->shareTargetType,
            'target_id' => $this->shareTargetId,
            'permission' => $this->sharePermission,
            'granted_by' => auth()->id(),
        ]);

        $this->sharingFolder = $folder->fresh()->load('accessEntries');
        $this->shareTargetId = '';

        session()->flash('shareSuccess', 'Access granted successfully.');
    }

    public function removeShareEntry($entryId)
    {
        DocumentFolderAccess::findOrFail($entryId)->delete();
        $this->sharingFolder = DocumentFolder::with('accessEntries')->find($this->sharingFolderId);
        session()->flash('shareSuccess', 'Access removed.');
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
        $this->folderVisibility = 'everyone';
        $this->folderDepartmentIds = [];
        $this->folderUserIds = [];
    }

    private function validateFolderVisibilityTargets()
    {
        if ($this->folderVisibility === 'department') {
            $this->validate([
                'folderDepartmentIds' => 'required|array|min:1',
                'folderDepartmentIds.*' => 'exists:departments,id',
            ]);
        }

        if ($this->folderVisibility === 'specific') {
            $this->validate([
                'folderUserIds' => 'required|array|min:1',
                'folderUserIds.*' => 'exists:users,id',
            ]);
        }
    }

    private function syncFolderVisibilityTargets(DocumentFolder $folder)
    {
        $folder->accessEntries()
            ->where('permission', 'view')
            ->whereIn('target_type', ['department', 'user'])
            ->delete();

        if ($this->folderVisibility === 'department') {
            foreach ($this->folderDepartmentIds as $departmentId) {
                DocumentFolderAccess::create([
                    'folder_id' => $folder->id,
                    'target_type' => 'department',
                    'target_id' => (int) $departmentId,
                    'permission' => 'view',
                    'granted_by' => auth()->id(),
                ]);
            }
        }

        if ($this->folderVisibility === 'specific') {
            foreach ($this->folderUserIds as $userId) {
                DocumentFolderAccess::create([
                    'folder_id' => $folder->id,
                    'target_type' => 'user',
                    'target_id' => (int) $userId,
                    'permission' => 'view',
                    'granted_by' => auth()->id(),
                ]);
            }
        }
    }
}

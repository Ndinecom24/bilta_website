<?php

namespace App\Http\Livewire\Admin\DocumentsPage;

use App\Models\Bilta\Document;
use App\Models\Bilta\DocumentFolder;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeDocuments extends Component
{
    use WithPagination;

    public $currentFolderId = null;
    public $currentFolder = null;
    public $breadcrumbs = [];
    public $search = '';
    public $sortBy = 'name';
    public $sortDir = 'asc';

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
            $documentsQuery->whereRaw('1 = 0');
        }

        if ($this->search) {
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

        return view('livewire.admin.documents-page.employee-browse', compact('folders', 'documents', 'folderTree'));
    }

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

    public function downloadDocument($id)
    {
        $doc = Document::findOrFail($id);
        return Storage::disk('public')->download($doc->file_path, $doc->original_name);
    }

    public function sortByColumn($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }
}

<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">Statuses</h1>
            <p class="text-muted mb-0">Manage reusable system statuses used across modules.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 p-2">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
        </div>

        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateStatus ? 'Edit Status' : 'Add Status' }}</h5>
                    @if ($updateStatus)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateStatus ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="statusName">Name</label>
                                <input id="statusName" type="text" class="form-control" wire:model.defer="name" placeholder="Enter name">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="statusSlug">Description / Slug</label>
                                <input id="statusSlug" type="text" class="form-control" wire:model.defer="slug" placeholder="Enter description">
                                @error('slug') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateStatus ? 'Update Status' : 'Save Status' }}</button>
                            @if ($updateStatus)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">System Statuses</h5>
                    <span class="badge badge-light">{{ $statuses->total() }} Items</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th style="width: 170px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($statuses as $key => $status)
                                    <tr>
                                        <td>{{ $statuses->firstItem() + $key }}</td>
                                        <td>{{ $status->name }}</td>
                                        <td>{{ $status->slug }}</td>
                                        <td>
                                            <button wire:click="edit({{ $status->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteStatus({{ $status->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No Statuses Found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $statuses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteStatus(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteStatus', id);
        }
    </script>
</div>

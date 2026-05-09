<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Item Category</h1>
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
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
        </div>

        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateItemCategory ? 'Edit Item Category' : 'Add Item Category' }}</h5>
                    @if ($updateItemCategory)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateItemCategory ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="categoryName">Name</label>
                                <input id="categoryName" type="text" class="form-control" wire:model.defer="name" placeholder="Category name">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="categoryType">Type</label>
                                <select id="categoryType" class="form-control" wire:model.defer="type">
                                    <option value="">-- Select Type --</option>
                                    <option value="Projects">Projects</option>
                                    <option value="News">News</option>
                                </select>
                                @error('type') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="categoryStatus">Status</label>
                                <select id="categoryStatus" class="form-control" wire:model.defer="status_id">
                                    <option value="">-- Select Status --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="categoryDescription">Description</label>
                                <textarea id="categoryDescription" rows="4" class="form-control" wire:model.defer="description" placeholder="Describe this category"></textarea>
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateItemCategory ? 'Update Category' : 'Save Category' }}</button>
                            @if ($updateItemCategory)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Item Categories</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width:220px;">Name</th>
                                    <th>Description</th>
                                    <th style="width:140px;">Type</th>
                                    <th style="width:130px;">Status</th>
                                    <th style="width:160px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($item_categories as $item_category)
                                    <tr>
                                        <td>{{ $item_category->name }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($item_category->description, 180) }}</td>
                                        <td>{{ $item_category->type }}</td>
                                        <td>{{ $item_category->status->name ?? '-' }}</td>
                                        <td>
                                            <button wire:click="edit({{ $item_category->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteItemCategory({{ $item_category->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No item categories found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $item_categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteItemCategory(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteItemCategory', id);
        }
    </script>

</div>

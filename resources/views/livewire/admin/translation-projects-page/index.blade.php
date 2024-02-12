<div>


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Translation Projects</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12 p-2">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('error') }}
                </div>
            @endif

            @include('livewire.admin.translation-projects-page.update')
            @include('livewire.admin.translation-projects-page.create')

        </div>
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal"
                                data-target="#createModal">
                                <i class="fa fa-plus">Add</i>
                            </button>
                        </div>

                        <div class="col-lg-10 col-md-10 col-sm-6">
                            <h5>Translation Projects</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Short Description</th>
                                    <th>Post_date</th>
                                    <th>Author</th>
                                    <th>Details</th>
                                    <th>Status</th>
                                    <th>Location</th>
                                    <th>Location Map</th>
                                    <th>Category</th>
                                    <th>Images</th>
                                    <th>Files</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($translation_projects) > 0)
                                    @foreach ($translation_projects as $key => $translation_project)
                                        <tr>
                                            <td>
                                                @if ($translation_project->getFirstMedia('project_title_images') != null)
                                                    <img src="{{ $translation_project->getFirstMedia('project_title_images')->getUrl() }}"
                                                        style="width:100%; height: 60px "
                                                        title="{{ $translation_project->getFirstMedia('project_title_images')->short_description }}">
                                                @endif
                                            </td>
                                            <td>
                                                {{ $translation_project->title }}
                                            </td>
                                            <td>
                                                {{ Str::limit($translation_project->short_description, '200', '...') }}
                                            </td>
                                            <td>
                                                {{ $translation_project->post_date }}
                                            </td>
                                            <td>
                                                {{ $translation_project->author }}
                                            </td>
                                            <td>
                                                {{ Str::limit($translation_project->details, '200', '...') }}
                                            </td>
                                            <td>
                                                {{ $translation_project->status->name ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $translation_project->location ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $translation_project->location_map ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $translation_project->myCategory->name ?? '-' }}
                                            </td>

                                            <td>

                                                <div class="row">
                                                   
                                                        @foreach ($translation_project->getMedia('project_images') as $item)
                                                         <div class="col-12 m-1">
                                                            @if ($item != null)
                                                                <img src="{{ $item->getUrl() }}"
                                                                    style="width:100%; height: 60px "
                                                                    title="{{ $item->name }}">
                                                            @endif
                                                             </div>
                                                        @endforeach

                                                   
                                                </div>

                                            </td>

                                            <td>

                                                <div class="row">
                                                   
                                                        @foreach ($translation_project->getMedia('project_files') as $item)
                                                         <div class="col-12 m-1">
                                                            @if ($item != null)
                                                                <img src="{{ $item->getUrl() }}"
                                                                    style="width:100%; height: 60px "
                                                                    title="{{ $item->name }}">
                                                            @endif
                                                             </div>
                                                        @endforeach

                                                   
                                                </div>

                                            </td>

                                            <td>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button wire:click="edit({{ $translation_project->id }})"
                                                            data-toggle="modal" data-target="#updateModal"
                                                            class="btn btn-primary btn-sm m-2">Edit
                                                        </button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button
                                                            onclick="deleteOurProjectsItem({{ $translation_project->id }})"
                                                            class="btn btn-danger btn-sm  m-2">Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" aligne="center">
                                            No Projects Item Found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteOurProjectsItem(id) {
            if (confirm("Are you sure status_id delete this record?"))
                window.livewire.emit('deleteProjects', id);
        }
    </script>

</div>

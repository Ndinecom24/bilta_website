<div>


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Audio Item</h1>
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
            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('error') }}
                </div>
            @endif

            @include('livewire.admin.audios-page.update')
            @include('livewire.admin.audios-page.create')

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
                            <h5>Audio Item</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Audio Item</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Project</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($audio_items) > 0)
                                @foreach ($audio_items as $key=>$audio)
                                    <tr>
                                        <td>
                                        @if ($audio->getFirstMediaUrl('audio_files'))
                                        <audio controls>
                                            <source src="{{ $audio->getFirstMediaUrl('audio_files') }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    @else
                                        <p>No audio file available.</p>
                                    @endif
                                    
                                </td>

                                        <td>
                                            {{$audio->title}}
                                        </td>
                                        <td>
                                            {{$audio->description}}
                                        </td>
                                        <td>
                                            {{$audio->project->title ?? "-"}}
                                        </td>
                                        <td>
                                            {{$audio->status->name ??""}}
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button wire:click="edit({{$audio->id}})"
                                                            data-toggle="modal" data-target="#updateModal"
                                                            class="btn btn-primary btn-sm">Edit
                                                    </button>
                                                    <button onclick="deleteAudioItem({{$audio->id}})"
                                                            class="btn btn-danger btn-sm">Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" align="center">
                                        No Audio Item Found.
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
        function deleteAudioItem(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteAudioItem', id);
        }
    </script>

</div>

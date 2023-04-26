<div>


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">About Us</h1>
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

                        @include('livewire.admin.company.about-us.update')
                        @include('livewire.admin.company.about-us.create')

        </div>
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#aboutUsModal">
                                <i class="fa fa-plus">Add</i>
                            </button>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-6">
                            <h5>Company About Us</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Vision</th>
                                <th>Mission</th>
                                <th>Objective</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($about_uses) > 0)
                                @foreach ($about_uses as $key=>$about_us)
                                    <tr>
                                        <td>
                                            {{$about_us->vision}}
                                        </td>
                                        <td>
                                            {{$about_us->mission}}
                                        </td>
                                        <td>
                                            {{$about_us->objective}}
                                        </td>
                                        <td>
                                            {{$about_us->description}}
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                            <button wire:click="edit({{$about_us->id}})"
                                                     data-toggle="modal" data-target="#updateModal"
                                                    class="btn btn-primary btn-sm">Edit
                                            </button>
                                            <button onclick="deleteAboutUs({{$about_us->id}})"
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
                                        No About Us Found.
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
        function deleteAboutUs(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteAboutUs', id);
        }
    </script>

</div>

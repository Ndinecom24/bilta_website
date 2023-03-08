<div>


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Details</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12 p-2">
            <div class="card">
                <div class="card-body">
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

                        @include('livewire.system.role.attach')
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                        <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#roleModal"
                                wire:click="roleAttachButton()">
                            <i class="fa fa-plus">Attach</i>
                        </button>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-6">
                        <h5>System Roles</h5>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name  </th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($user->roles) > 0)
                                @foreach ($user->roles as $key=>$role)
                                    <tr>
                                        <td>
                                            {{++$key}}
                                        </td>
                                        <td>
                                            {{$role->name}}
                                        </td>
                                        <td>
                                            {{$role->slug}}
                                        </td>
                                        <td>
                                            <button onclick="detachRole({{$role->id}})"
                                                    class="btn btn-sm btn-outline-danger btn-sm">Remove
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" align="center">
                                        No Roles Found.
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
        function detachRole(id) {
            if (confirm("Are you sure to detach this record?"))
                window.livewire.emit('detachRole', id);
        }


    </script>

</div>

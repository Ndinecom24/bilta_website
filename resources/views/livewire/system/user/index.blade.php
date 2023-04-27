<div>


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users</h1>
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
                        <div class="alert alert-success" user="alert">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger" user="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    @include('livewire.system.user.create')

        </div>
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#userModal">
                                <i class="fa fa-plus">Add</i>
                            </button>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-6">
                            <h5>System Users</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th>Logins</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($users) > 0)
                                @foreach ($users as $key=>$user)
                                    <tr>
                                        <td>
                                            {{++$key}}
                                        </td>
                                        <td>
                                            {{$user->name}}
                                        </td>
                                        <td>
                                            {{$user->email}}
                                        </td>
                                        <td>
                                            {{$user->phone}}
                                        </td>
                                        <td>
                                            {{$user->status->name ?? "--"}}
                                        </td>
                                        <td>
                                            {{$user->roles->count()}}
                                        </td>
                                        <td>
                                            {{$user->logins ?? 0 }}
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <a href="{{route('system.users.show', $user)}}"
                                                       onclick="event.preventDefault();  document.getElementById('user-profile-form{{$user->uuid ?? "0"}}').submit();"
                                                       class="btn btn-success btn-sm">View
                                                    </a>
                                                    <form id="user-profile-form{{$user->uuid ?? "0"}}" action="{{ route('system.users.show',$user->uuid ?? "0") }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" align="center">
                                        No Users Found.
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


</div>

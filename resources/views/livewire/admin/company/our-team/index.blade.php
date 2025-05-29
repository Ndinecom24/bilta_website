<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Our Team</h1>
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

            @include('livewire.admin.company.our-team.update')
            @include('livewire.admin.company.our-team.create')

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
                            <h5>Our Team</h5>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Position</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Facebook</th>
                                <th>LinkedIn</th>
                                <th>Twitter</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($our_teams) > 0)
                                @foreach ($our_teams as $our_team)
                                    <tr>
                                        <td>
                                            @php
                                                $media = $our_team->getFirstMedia('team_images');
                                                $imageUrl = $media
                                                    ? $media->getUrl()
                                                    : asset('storage/defaults/default-team.png');
                                            @endphp

                                            <img src="{{ $imageUrl }}"
                                                 style="width:100%; height: 60px"
                                                 title="{{ $media ? $media->name : 'Default Image' }}">
                                        </td>
                                        <td>{{ $our_team->position }}</td>
                                        <td>{{ $our_team->name }}</td>
                                        <td>{{ $our_team->email }}</td>
                                        <td>{{ $our_team->phone }}</td>
                                        <td>{{ $our_team->from }}</td>
                                        <td>{{ $our_team->to }}</td>
                                        <td>{{ $our_team->facebook_url }}</td>
                                        <td>{{ $our_team->linkedin_url }}</td>
                                        <td>{{ $our_team->twitter_url }}</td>
                                        <td>{{ $our_team->details }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <button wire:click="edit({{ $our_team->id }})"
                                                            data-toggle="modal" data-target="#updateModal"
                                                            class="btn btn-primary btn-sm m-2">Edit
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <button onclick="deleteOurTeam({{ $our_team->id }})"
                                                            class="btn btn-danger btn-sm m-2">Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12" align="center">No Our Team Found.</td>
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
        function deleteOurTeam(id) {
            if (confirm("Are you sure to delete this record?")) {
                window.livewire.emit('deleteOurTeam', id);
            }
        }
    </script>
</div>

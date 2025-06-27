<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Our Sponsor</h1>
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

            <!-- Optionally include modals for updating and creating description -->
            @include('livewire.admin.sponsor.update')
            @include('livewire.admin.sponsor.create')

        </div>
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal"
                                data-target="#createOurSponsorModal">
                                <i class="fa fa-plus">Add</i>
                            </button>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-6">
                            <h5>Our's Sponsor</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Description</th>
                                    <th>Received At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($oursponsors) > 0)
                                    @foreach ($oursponsors as $oursponser)
                                        <tr>
                                            
                                            <td>{{ $oursponser->name }}</td>
                                            <td>{{ $oursponser->website_url }}</td>
                                            <td>{{ $oursponser->description }}</td>
                                            <td>{{ $oursponser->created_at }}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button wire:click="edit({{ $oursponser->id }})"
                                                            data-toggle="modal" data-target="#updateOurSponsorModal"
                                                            class="btn btn-primary btn-sm">View
                                                        </button>
                                                        <button onclick="deleteOurSponsor({{ $oursponser->id }})"
                                                            class="btn btn-danger btn-sm">Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" align="center">
                                            No Sponsor Found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{-- Pagination --}}
                        <div class="mt-2">
                            {{ $oursponsors->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteOurSponsor(id) {
            if (confirm("Are you sure to delete this our sponsor?"))
                window.livewire.emit('deleteOurSponsor', id);
        }
    </script>
</div>

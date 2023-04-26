<div>


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contact Us</h1>
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

                        @include('livewire.admin.company.contact-us.update')
                        @include('livewire.admin.company.contact-us.create')

        </div>
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#createModal">
                                <i class="fa fa-plus">Add</i>
                            </button>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-6">
                            <h5>Company Contact Details</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Maps</th>
                                <th>Whatsapp Link</th>
                                <th>Youtube</th>
                                <th>Twitter</th>
                                <th>Linked In</th>
                                <th>Facebook</th>
                                @if( isset($contact_details))
                                <th>Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>
                                            {{$contact_details->phone ?? "-"}}
                                        </td>
                                        <td>
                                            {{$contact_details->email ?? "-"}}
                                        </td>
                                        <td>
                                            {{$contact_details->address ?? "-"}}
                                        </td>
                                        <td>
                                            {{$contact_details->google_maps ?? "-"}}
                                        </td>
                                        <td>
                                            {{$contact_details->whatsapp_link ?? "-"}}
                                        </td>
                                        <td>
                                            {{$contact_details->youtube ?? "-"}}
                                        </td>
                                        <td>
                                            {{$contact_details->twitter_url ?? "-"}}
                                        </td>
                                        <td>
                                            {{$contact_details->linkedin_url ?? "-"}}
                                        </td>
                                        <td>
                                            {{$contact_details->facebook_url ?? "-"}}
                                        </td>
                                        @if( isset($contact_details))
                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                            <button wire:click="edit({{$contact_details->id ?? 0}})"
                                                     data-toggle="modal" data-target="#updateModal"
                                                    class="btn btn-primary btn-sm">Edit
                                            </button>
                                            <button onclick="deleteContactUs({{$contact_details->id ?? 0}})"
                                                    class="btn btn-danger btn-sm">Delete
                                            </button>
                                                </div>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteContactUs(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteContactUs', id);
        }
    </script>

</div>

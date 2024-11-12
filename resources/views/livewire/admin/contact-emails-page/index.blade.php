<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contact Emails</h1>
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

            <!-- Optionally include modals for updating and creating emails -->
            @include('livewire.admin.contact-emails-page.update')
            @include('livewire.admin.contact-emails-page.create')

        </div>
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal"
                                    data-target="#createEmailModal">
                                <i class="fa fa-plus">Add</i>
                            </button>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-6">
                            <h5>Contact Emails</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Received At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($emails) > 0)
                                @foreach ($emails as $email)
                                    <tr>
                                        <td>{{ $email->name }}</td>
                                        <td>{{ $email->email }}</td>
                                        <td>{{ $email->subject }}</td>
                                        <td>{{ $email->message }}</td>
                                        <td>{{ $email->created_at }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button wire:click="edit({{ $email->id }})"
                                                            data-toggle="modal" data-target="#updateEmailModal"
                                                            class="btn btn-primary btn-sm">View
                                                    </button>
                                                    <button onclick="deleteEmail({{ $email->id }})"
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
                                        No Emails Found.
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
        function deleteEmail(id) {
            if (confirm("Are you sure to delete this email?"))
                window.livewire.emit('deleteEmail', id);
        }
    </script>
</div>

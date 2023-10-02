<div>


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Home Intro</h1>
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

            @include('livewire.admin.home-page.intro.update')
            @include('livewire.admin.home-page.intro.create')

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
                            <h5>Site Home Intro Page</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Short Description</th>
                                <th>Long Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ( isset($home_intro->id) )

                                    <tr>
                                        <td>
                                            @if( $home_intro->getFirstMedia('home_intro_images') ?? '00' != '00')
                                            <img  src="{{ $home_intro->getFirstMedia('home_intro_images')->getUrl()  }}"
                                                  style="width:100%; height: 60px "
                                                  title="{{ $home_intro->getFirstMedia('home_intro_images')->name }}">
                                                @endif
                                        </td>

                                        <td>
                                            {{$home_intro->name ?? ""}}
                                        </td>
                                        <td>
                                            {{$home_intro->short_description ?? ""}}
                                        </td>
                                        <td>
                                            {{$home_intro->long_description ?? ""}}
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <button wire:click="edit({{$home_intro->id ?? 0}})"
                                                            data-toggle="modal" data-target="#updateModal"
                                                            class="btn btn-primary btn-sm m-2">Edit
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <button onclick="deleteHomeIntro({{$home_intro->id ?? 0}})"
                                                            class="btn btn-danger btn-sm  m-2">Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            @else
                                <tr>
                                    <td colspan="3" align="center">
                                        No  Found.
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
        function deleteHomeIntro(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteHomeIntro', id);
        }
    </script>

</div>

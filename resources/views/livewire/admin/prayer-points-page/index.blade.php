<div>


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Weekly Prayer Points</h1>
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

            @include('livewire.admin.prayer-points-page.update')
            @include('livewire.admin.prayer-points-page.create')

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
                            <h5>Frequently Asked Questions</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Details</th>
                                <th>Scriptures</th>
                                <th>Post Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($weekly_prayer_points) > 0)
                                @foreach ($weekly_prayer_points as $key=>$weekly_prayer_point)
                                    <tr>
                                        <td>
                                            {{$weekly_prayer_point->title}}
                                        </td>
                                        <td>
                                            {{$weekly_prayer_point->details}}
                                        </td>
                                        <td>
                                            {{$weekly_prayer_point->scriptures}}
                                        </td>
                                        <td>
                                            {{$weekly_prayer_point->post_date}}
                                        </td>
                                        <td>
                                            {{$weekly_prayer_point->status->name ?? "-"}}
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button wire:click="edit({{$weekly_prayer_point->id}})"
                                                            data-toggle="modal" data-target="#updateModal"
                                                            class="btn btn-primary btn-sm">Edit
                                                    </button>
                                                    <button onclick="deleteWeeklyPrayerPoint({{$weekly_prayer_point->id}})"
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
                                        No Weekly Prayer Points Found.
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
        function deleteWeeklyPrayerPoint(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteWeeklyPrayerPoint', id);
        }
    </script>

</div>

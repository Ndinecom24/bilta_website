<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">Weekly Prayer Points</h1>
            <p class="text-muted mb-0">Manage weekly prayer focus content shown on the public site.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
        </div>

        <div class="col-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateWeeklyPrayerPoint ? 'Edit Weekly Prayer Point' : 'Add Weekly Prayer Point' }}</h5>
                    @if ($updateWeeklyPrayerPoint)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateWeeklyPrayerPoint ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="prayerTitle">Title</label>
                                <input id="prayerTitle" type="text" class="form-control" wire:model.defer="title" placeholder="Enter title">
                                @error('title') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="prayerDetails">Details</label>
                                <textarea id="prayerDetails" rows="3" class="form-control" wire:model.defer="details" placeholder="Enter details"></textarea>
                                @error('details') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="prayerScriptures">Scriptures</label>
                                <textarea id="prayerScriptures" rows="3" class="form-control" wire:model.defer="scriptures" placeholder="Enter scriptures"></textarea>
                                @error('scriptures') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="prayerDate">Post Date</label>
                                <input id="prayerDate" type="date" class="form-control" wire:model.defer="post_date">
                                @error('post_date') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="prayerStatus">Status</label>
                                <select id="prayerStatus" class="form-control" wire:model.defer="status_id">
                                    <option value="">-- Choose --</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateWeeklyPrayerPoint ? 'Update Prayer Point' : 'Save Prayer Point' }}</button>
                            @if ($updateWeeklyPrayerPoint)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Prayer Point Records</h5>
                    <span class="badge badge-light">{{ count($weekly_prayer_points) }} Items</span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Details</th>
                                    <th>Scriptures</th>
                                    <th>Post Date</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($weekly_prayer_points) > 0)
                                    @foreach ($weekly_prayer_points as $weekly_prayer_point)
                                        <tr>
                                            <td>{{ $weekly_prayer_point->title }}</td>
                                            <td class="text-muted">{{ $weekly_prayer_point->details }}</td>
                                            <td>{{ $weekly_prayer_point->scriptures }}</td>
                                            <td>{{ $weekly_prayer_point->post_date }}</td>
                                            <td>{{ $weekly_prayer_point->status->name ?? '-' }}</td>
                                            <td class="text-right">
                                                <button wire:click="edit({{ $weekly_prayer_point->id }})" class="btn btn-outline-primary btn-sm">Edit</button>
                                                <button onclick="deleteWeeklyPrayerPoint({{ $weekly_prayer_point->id }})" class="btn btn-outline-danger btn-sm">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No Weekly Prayer Points Found.</td>
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

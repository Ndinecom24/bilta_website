<div>
    <style>
        .team-reorder-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .team-reorder-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .8rem;
            padding: .65rem .8rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #fff;
            margin-bottom: .45rem;
            cursor: move;
        }

        .team-reorder-handle {
            color: #64748b;
            font-size: .95rem;
            margin-right: .55rem;
        }

        .team-reorder-meta {
            color: #64748b;
            font-size: .82rem;
        }

        .team-order-badge {
            min-width: 38px;
            text-align: center;
        }
    </style>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Our Team</h1>
    </div>

    <div class="row">
        <div class="col-md-12 p-2">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
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

        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateLeadershipMember ? 'Edit Team Member' : 'Add Team Member' }}</h5>

                    @if ($updateLeadershipMember)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateLeadershipMember ? 'update' : 'store' }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="teamName">Name</label>
                                <input id="teamName" type="text" class="form-control" wire:model.defer="name" placeholder="Member name">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="teamPosition">Position</label>
                                <input id="teamPosition" type="text" class="form-control" wire:model.defer="position" placeholder="Position">
                                @error('position') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="teamOrder">Order</label>
                                <input id="teamOrder" type="number" min="0" class="form-control" wire:model.defer="display_order" placeholder="0">
                                @error('display_order') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="teamEmail">Email</label>
                                <input id="teamEmail" type="email" class="form-control" wire:model.defer="email" placeholder="email@example.com">
                                @error('email') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="teamPhone">Phone</label>
                                <input id="teamPhone" type="text" class="form-control" wire:model.defer="phone" placeholder="Phone number">
                                @error('phone') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="teamDetails">Details</label>
                                <textarea id="teamDetails" rows="4" class="form-control" wire:model.defer="details" placeholder="Profile summary"></textarea>
                                @error('details') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="teamFrom">From</label>
                                <input id="teamFrom" type="date" class="form-control" wire:model.defer="from">
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="teamTo">To</label>
                                <input id="teamTo" type="date" class="form-control" wire:model.defer="to">
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="teamFacebook">Facebook URL</label>
                                <input id="teamFacebook" type="text" class="form-control" wire:model.defer="facebook_url" placeholder="Facebook link">
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="teamLinkedin">LinkedIn URL</label>
                                <input id="teamLinkedin" type="text" class="form-control" wire:model.defer="linkedin_url" placeholder="LinkedIn link">
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="teamTwitter">Twitter/X URL</label>
                                <input id="teamTwitter" type="text" class="form-control" wire:model.defer="twitter_url" placeholder="Twitter link">
                            </div>

                            @if ($updateLeadershipMember && $team && $team->getFirstMedia('team_images'))
                                <div class="col-lg-12 col-md-12 mb-3">
                                    <p class="font-weight-bold mb-1">Current Photo</p>
                                    <img src="{{ $team->getFirstMedia('team_images')->getUrl() }}" style="max-height: 90px;" alt="Team member">
                                </div>
                            @endif

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="teamImage">{{ $updateLeadershipMember ? 'Replace Photo (optional)' : 'Member Photo' }}</label>
                                <input id="teamImage" type="file" class="form-control" wire:model="user_image">
                                @error('user_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateLeadershipMember ? 'Update Member' : 'Save Member' }}</button>
                            @if ($updateLeadershipMember)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card shadow-sm mb-3">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Quick Reorder (Drag & Drop)</h5>
                    <small class="text-muted">Drag rows to change public display order</small>
                </div>
                <div class="card-body">
                    <ul id="teamReorderList" class="team-reorder-list">
                        @foreach ($our_teams as $our_team)
                            <li class="team-reorder-item" data-id="{{ $our_team->id }}">
                                <div class="d-flex align-items-center">
                                    <span class="team-reorder-handle"><i class="fas fa-grip-vertical"></i></span>
                                    <div>
                                        <div class="font-weight-bold">{{ $our_team->name }}</div>
                                        <div class="team-reorder-meta">{{ $our_team->position }}</div>
                                    </div>
                                </div>
                                <span class="badge badge-light team-order-badge">{{ $our_team->display_order ?? 0 }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Our Team Records</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Order</th>
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
                                                    alt="{{ $our_team->name }}"
                                                 title="{{ $media ? $media->name : 'Default Image' }}">
                                        </td>
                                        <td>{{ $our_team->display_order ?? 0 }}</td>
                                        <td>{{ $our_team->position }}</td>
                                        <td>{{ $our_team->name }}</td>
                                        <td>{{ $our_team->email }}</td>
                                        <td>{{ $our_team->phone }}</td>
                                        <td>{{ $our_team->from }}</td>
                                        <td>{{ $our_team->to }}</td>
                                        <td>{{ $our_team->facebook_url }}</td>
                                        <td>{{ $our_team->linkedin_url }}</td>
                                        <td>{{ $our_team->twitter_url }}</td>
                                        <td>{{ Str::limit($our_team->details, 20) }}</td>
                                        <td>
                                            <button wire:click="edit({{ $our_team->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteOurTeam({{ $our_team->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="13" class="text-center">No team members found.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $our_teams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

    <script>
        (function () {
            const initializeTeamReorder = () => {
                if (typeof Sortable === 'undefined') {
                    return;
                }

                const reorderList = document.getElementById('teamReorderList');
                if (!reorderList || reorderList.dataset.sortableInit === '1') {
                    return;
                }

                reorderList.dataset.sortableInit = '1';

                Sortable.create(reorderList, {
                    animation: 150,
                    onEnd: function () {
                        const orderedIds = Array.from(reorderList.querySelectorAll('.team-reorder-item'))
                            .map((item) => item.getAttribute('data-id'));

                        if (window.livewire) {
                            window.livewire.emit('reorderTeam', orderedIds);
                        }
                    }
                });
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeTeamReorder);
            } else {
                initializeTeamReorder();
            }

            document.addEventListener('livewire:load', initializeTeamReorder);
        })();

        function deleteOurTeam(id) {
            if (confirm("Are you sure to delete this record?")) {
                window.livewire.emit('deleteOurTeam', id);
            }
        }
    </script>
</div>

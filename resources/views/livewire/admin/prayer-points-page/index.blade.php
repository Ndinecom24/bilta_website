<div>

    {{-- ============================================================
        PAGE HEADER
    ============================================================ --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                <i class="fas fa-praying-hands text-primary mr-2"></i>Weekly Prayer Points
            </h1>
            <p class="mb-0 text-muted small">Manage prayer points with banner images and file attachments.</p>
        </div>
    </div>

    {{-- ============================================================
        ALERTS
    ============================================================ --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-3" role="alert">
            <div class="d-flex align-items-start">
                <i class="fas fa-exclamation-triangle mr-2 mt-1"></i>
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3 d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session()->get('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-3 d-flex align-items-center" role="alert">
            <i class="fas fa-times-circle mr-2"></i>
            {{ session()->get('error') }}
        </div>
    @endif

    {{-- ============================================================
        FORM CARD
    ============================================================ --}}
    <div class="card shadow mb-4 border-0" style="border-radius: 16px; overflow: hidden;">

        {{-- Card Header --}}
        <div class="card-header py-3 d-flex align-items-center justify-content-between"
             style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border: none;">
            <h5 class="mb-0 text-white font-weight-bold">
                <i class="fas {{ $updateWeeklyPrayerPoint ? 'fa-edit' : 'fa-plus-circle' }} mr-2"></i>
                {{ $updateWeeklyPrayerPoint ? 'Edit Prayer Point' : 'Create Prayer Point' }}
            </h5>
            @if ($updateWeeklyPrayerPoint)
                <button wire:click="cancel" type="button" class="btn btn-sm btn-light rounded-pill px-3 font-weight-bold shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Create New
                </button>
            @endif
        </div>

        {{-- Card Body --}}
        <div class="card-body p-4">
            <form wire:submit.prevent="{{ $updateWeeklyPrayerPoint ? 'update' : 'store' }}" enctype="multipart/form-data">

                {{-- Section: Basic Info --}}
                <div class="mb-4">
                    <h6 class="text-uppercase text-primary font-weight-bold mb-3" style="font-size: .75rem; letter-spacing: .08em;">
                        <i class="fas fa-info-circle mr-1"></i> Basic Information
                    </h6>
                    <div class="row">
                        <div class="col-lg-8 col-md-12 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="prayerTitle">
                                Title <span class="text-danger">*</span>
                            </label>
                            <input id="prayerTitle" type="text"
                                   class="form-control form-control-lg border-left-primary @error('title') is-invalid @enderror"
                                   wire:model.defer="title"
                                   placeholder="Enter prayer point title"
                                   style="border-radius: 10px;">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-lg-4 col-md-12 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="prayerDate">
                                Post Date <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                    </span>
                                </div>
                                <input id="prayerDate" type="date"
                                       class="form-control @error('post_date') is-invalid @enderror"
                                       wire:model.defer="post_date"
                                       style="border-radius: 0 10px 10px 0;">
                            </div>
                            @error('post_date') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Section: Content --}}
                <div class="mb-4">
                    <h6 class="text-uppercase text-primary font-weight-bold mb-3" style="font-size: .75rem; letter-spacing: .08em;">
                        <i class="fas fa-align-left mr-1"></i> Content (Optional)
                    </h6>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="prayerDetails">
                                Details
                            </label>
                            <textarea id="prayerDetails" rows="3"
                                      class="form-control @error('details') is-invalid @enderror"
                                      wire:model.defer="details"
                                      placeholder="Brief description or prayer focus details"
                                      style="border-radius: 10px;"></textarea>
                            @error('details') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="prayerScriptures">
                                Scriptures
                            </label>
                            <textarea id="prayerScriptures" rows="2"
                                      class="form-control @error('scriptures') is-invalid @enderror"
                                      wire:model.defer="scriptures"
                                      placeholder="Supporting scripture references"
                                      style="border-radius: 10px;"></textarea>
                            @error('scriptures') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Section: Settings --}}
                <div class="mb-4">
                    <h6 class="text-uppercase text-primary font-weight-bold mb-3" style="font-size: .75rem; letter-spacing: .08em;">
                        <i class="fas fa-cog mr-1"></i> Settings
                    </h6>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="prayerStatus">
                                Status <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-toggle-on text-primary"></i>
                                    </span>
                                </div>
                                <select id="prayerStatus"
                                        class="form-control @error('status_id') is-invalid @enderror"
                                        wire:model.defer="status_id"
                                        style="border-radius: 0 10px 10px 0;">
                                    <option value="">-- Select Status --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('status_id') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Section: Files & Media --}}
                <div class="mb-4">
                    <h6 class="text-uppercase text-primary font-weight-bold mb-3" style="font-size: .75rem; letter-spacing: .08em;">
                        <i class="fas fa-paperclip mr-1"></i> Files & Media
                    </h6>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="bannerImage">
                                <i class="fas fa-image text-info mr-1"></i>
                                Banner Image
                                <span class="text-muted font-weight-normal">(optional)</span>
                            </label>
                            <div class="custom-file-upload position-relative border rounded-lg p-3 text-center bg-light" style="border-radius: 10px !important; border-style: dashed !important; cursor: pointer;">
                                <input id="bannerImage" type="file" class="position-absolute w-100 h-100" style="top:0;left:0;opacity:0;cursor:pointer;" wire:model="banner_image" accept="image/*">
                                <div>
                                    <i class="fas fa-cloud-upload-alt text-primary mb-2" style="font-size: 1.5rem;"></i>
                                    <p class="mb-0 small text-muted">Click or drag to upload banner image</p>
                                    <small class="text-muted">Max 5 MB &bull; Recommended: 1200&times;600px</small>
                                </div>
                                <div wire:loading wire:target="banner_image" class="mt-2">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                    <small class="text-primary ml-1">Uploading...</small>
                                </div>
                            </div>
                            @error('banner_image') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-lg-6 col-md-12 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="prayerAttachments">
                                <i class="fas fa-file-alt text-warning mr-1"></i>
                                Attachments (PDF or Images)
                                <span class="text-muted font-weight-normal">(optional)</span>
                            </label>
                            <div class="custom-file-upload position-relative border rounded-lg p-3 text-center bg-light" style="border-radius: 10px !important; border-style: dashed !important; cursor: pointer;">
                                <input id="prayerAttachments" type="file" class="position-absolute w-100 h-100" style="top:0;left:0;opacity:0;cursor:pointer;" wire:model="attachments" multiple accept=".pdf,image/*">
                                <div>
                                    <i class="fas fa-file-upload text-warning mb-2" style="font-size: 1.5rem;"></i>
                                    <p class="mb-0 small text-muted">Click or drag to upload PDFs or images</p>
                                    <small class="text-muted">Max 10 MB per file &bull; Multiple allowed</small>
                                </div>
                                <div wire:loading wire:target="attachments" class="mt-2">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                    <small class="text-primary ml-1">Uploading...</small>
                                </div>
                            </div>
                            @error('attachments') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                            @error('attachments.*') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Existing files when editing --}}
                    @if ($updateWeeklyPrayerPoint && $prayerPoint)
                        <div class="row mt-2">
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold small text-gray-700">
                                    <i class="fas fa-image text-info mr-1"></i> Current Banner Image
                                </label>
                                @if ($prayerPoint->getFirstMedia('prayer_banner_images'))
                                    <div class="d-flex align-items-center justify-content-between bg-white border rounded-lg p-2" style="border-radius: 10px !important;">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $prayerPoint->getFirstMedia('prayer_banner_images')->getUrl() }}"
                                                 alt="Banner"
                                                 class="rounded mr-3"
                                                 style="height: 55px; width: 100px; object-fit: cover; border-radius: 8px !important;">
                                            <div>
                                                <small class="d-block font-weight-bold text-gray-700">Banner Image</small>
                                                <small class="text-muted">{{ round($prayerPoint->getFirstMedia('prayer_banner_images')->size / 1024) }} KB</small>
                                            </div>
                                        </div>
                                        <button wire:click.prevent="removeFile({{ $prayerPoint->getFirstMedia('prayer_banner_images')->id }})"
                                                type="button"
                                                class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="fas fa-trash-alt mr-1"></i> Remove
                                        </button>
                                    </div>
                                @else
                                    <div class="bg-light border rounded-lg p-3 text-center" style="border-radius: 10px !important;">
                                        <i class="fas fa-image text-muted" style="font-size: 1.3rem;"></i>
                                        <p class="mb-0 small text-muted mt-1">No banner image uploaded</p>
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold small text-gray-700">
                                    <i class="fas fa-file-alt text-warning mr-1"></i> Existing Attachments
                                </label>
                                @forelse ($prayerPoint->getMedia('prayer_attachments') as $media)
                                    @php
                                        $isPdf = str_contains($media->mime_type, 'pdf');
                                    @endphp
                                    <div class="d-flex align-items-center justify-content-between bg-white border rounded-lg p-2 mb-2" style="border-radius: 10px !important;">
                                        <div class="d-flex align-items-center">
                                            @if ($isPdf)
                                                <div class="d-flex align-items-center justify-content-center bg-danger text-white rounded mr-3"
                                                     style="width: 40px; height: 40px; border-radius: 10px !important; flex-shrink: 0;">
                                                    <i class="fas fa-file-pdf"></i>
                                                </div>
                                            @else
                                                <img src="{{ $media->getUrl() }}"
                                                     alt="{{ $media->name }}"
                                                     class="rounded mr-3"
                                                     style="height: 40px; width: 40px; object-fit: cover; border-radius: 10px !important;">
                                            @endif
                                            <div>
                                                <a href="{{ $media->getUrl() }}" target="_blank" class="small font-weight-bold text-gray-700 d-block">
                                                    {{ $media->name }}
                                                </a>
                                                <small class="text-muted">
                                                    {{ round($media->size / 1024) > 1024 ? round($media->size / 1048576, 1) . ' MB' : round($media->size / 1024) . ' KB' }}
                                                    &bull; {{ $isPdf ? 'PDF' : strtoupper(pathinfo($media->file_name, PATHINFO_EXTENSION)) }}
                                                </small>
                                            </div>
                                        </div>
                                        <button wire:click.prevent="removeFile({{ $media->id }})"
                                                type="button"
                                                class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="fas fa-trash-alt mr-1"></i> Remove
                                        </button>
                                    </div>
                                @empty
                                    <div class="bg-light border rounded-lg p-3 text-center" style="border-radius: 10px !important;">
                                        <i class="fas fa-file-alt text-muted" style="font-size: 1.3rem;"></i>
                                        <p class="mb-0 small text-muted mt-1">No attachments uploaded</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Submit Actions --}}
                <div class="border-top pt-3">
                    <div class="d-flex flex-wrap align-items-center" style="gap: 10px;">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold shadow-sm">
                            <i class="fas {{ $updateWeeklyPrayerPoint ? 'fa-save' : 'fa-paper-plane' }} mr-2"></i>
                            {{ $updateWeeklyPrayerPoint ? 'Update Prayer Point' : 'Save Prayer Point' }}
                        </button>
                        @if ($updateWeeklyPrayerPoint)
                            <button wire:click.prevent="cancel" type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                <i class="fas fa-times mr-1"></i> Cancel
                            </button>
                        @endif
                        <div wire:loading class="ml-2">
                            <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                            <span class="text-primary small ml-1">Processing...</span>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- ============================================================
        RECORDS TABLE
    ============================================================ --}}
    <div class="card shadow mb-4 border-0" style="border-radius: 16px; overflow: hidden;">

        <div class="card-header py-3 d-flex align-items-center justify-content-between"
             style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); border: none;">
            <h5 class="mb-0 text-white font-weight-bold">
                <i class="fas fa-list-alt mr-2"></i> Prayer Point Records
            </h5>
            <span class="badge badge-light px-3 py-2 font-weight-bold" style="border-radius: 50px;">
                {{ $weekly_prayer_points->total() }} total
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fc;">
                        <tr>
                            <th class="border-0 pl-4" style="width: 80px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Banner</small>
                            </th>
                            <th class="border-0" style="width: 240px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Title</small>
                            </th>
                            <th class="border-0">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Details</small>
                            </th>
                            <th class="border-0" style="width: 110px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Date</small>
                            </th>
                            <th class="border-0" style="width: 90px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Status</small>
                            </th>
                            <th class="border-0 text-center" style="width: 70px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Files</small>
                            </th>
                            <th class="border-0 text-right pr-4" style="width: 160px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Actions</small>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($weekly_prayer_points as $item)
                            <tr class="align-middle" style="vertical-align: middle;">
                                {{-- Banner --}}
                                <td class="pl-4">
                                    @if ($item->getFirstMedia('prayer_banner_images'))
                                        <img src="{{ $item->getFirstMedia('prayer_banner_images')->getUrl() }}"
                                             alt="{{ $item->title }}"
                                             class="rounded shadow-sm"
                                             style="height: 42px; width: 64px; object-fit: cover; border-radius: 8px !important;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded"
                                             style="height: 42px; width: 64px; border-radius: 8px !important;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- Title --}}
                                <td>
                                    <span class="font-weight-bold text-gray-800 d-block">{{ $item->title }}</span>
                                    @if ($item->scriptures)
                                        <small class="text-muted"><i class="fas fa-book mr-1"></i>{{ Str::limit($item->scriptures, 40) }}</small>
                                    @endif
                                </td>

                                {{-- Details --}}
                                <td>
                                    <span class="text-gray-600 small">
                                        {{ Str::limit(strip_tags($item->details), 80) ?: '—' }}
                                    </span>
                                </td>

                                {{-- Date --}}
                                <td>
                                    <small class="font-weight-bold text-gray-700">
                                        {{ \Carbon\Carbon::parse($item->post_date)->format('d M Y') }}
                                    </small>
                                </td>

                                {{-- Status --}}
                                <td>
                                    @php
                                        $statusColors = [
                                            'active' => 'success',
                                            'pending' => 'warning',
                                            'inactive' => 'secondary',
                                        ];
                                        $color = $statusColors[$item->status->slug ?? ''] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-{{ $color }} px-2 py-1" style="border-radius: 6px; font-size: .75rem;">
                                        {{ $item->status->name ?? '-' }}
                                    </span>
                                </td>

                                {{-- Files Count --}}
                                <td class="text-center">
                                    @php $fileCount = $item->getMedia('prayer_attachments')->count(); @endphp
                                    @if ($fileCount > 0)
                                        <span class="badge badge-info px-2 py-1" style="border-radius: 6px; font-size: .75rem;">
                                            <i class="fas fa-paperclip mr-1"></i>{{ $fileCount }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="text-right pr-4">
                                    <div class="d-flex justify-content-end" style="gap: 6px;">
                                        <button wire:click="edit({{ $item->id }})"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteWeeklyPrayerPoint({{ $item->id }})"
                                                class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div>
                                        <i class="fas fa-praying-hands text-muted mb-3" style="font-size: 2.5rem; opacity: .3;"></i>
                                        <p class="text-muted mb-0 font-weight-bold">No prayer points found</p>
                                        <small class="text-muted">Create your first prayer point using the form above.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($weekly_prayer_points->hasPages())
                <div class="p-3 border-top">
                    {{ $weekly_prayer_points->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ============================================================
        SCRIPTS
    ============================================================ --}}
    <script>
        function deleteWeeklyPrayerPoint(id) {
            if (confirm("Are you sure you want to delete this prayer point?")) {
                window.livewire.emit('deleteWeeklyPrayerPoint', id);
            }
        }
    </script>
</div>

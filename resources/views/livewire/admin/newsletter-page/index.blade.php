<div>

    {{-- ============================================================
        PAGE HEADER
    ============================================================ --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                <i class="fas fa-newspaper text-primary mr-2"></i>Newsletters
            </h1>
            <p class="mb-0 text-muted small">Create, manage, and send newsletters to your subscribers.</p>
        </div>
        <div class="d-flex align-items-center" style="gap: 10px;">
            <span class="px-3 py-2 rounded-pill text-white font-weight-bold" style="background: linear-gradient(135deg, #4e73df, #224abe); font-size: .85rem;">
                <i class="fas fa-users mr-1"></i> {{ $subscriberCount }} subscriber{{ $subscriberCount !== 1 ? 's' : '' }}
            </span>
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
                <i class="fas {{ $updateItem ? 'fa-edit' : 'fa-plus-circle' }} mr-2"></i>
                {{ $updateItem ? 'Edit Newsletter' : 'Create Newsletter' }}
            </h5>
            @if ($updateItem)
                <button wire:click="cancel" type="button" class="btn btn-sm btn-light rounded-pill px-3 font-weight-bold shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Create New
                </button>
            @endif
        </div>

        {{-- Card Body --}}
        <div class="card-body p-4">
            <form wire:submit.prevent="{{ $updateItem ? 'update' : 'store' }}" enctype="multipart/form-data">

                {{-- Section: Basic Info --}}
                <div class="mb-4">
                    <h6 class="text-uppercase text-primary font-weight-bold mb-3" style="font-size: .75rem; letter-spacing: .08em;">
                        <i class="fas fa-info-circle mr-1"></i> Basic Information
                    </h6>
                    <div class="row">
                        <div class="col-lg-8 col-md-12 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="newsletterTitle">
                                Title <span class="text-danger">*</span>
                            </label>
                            <input id="newsletterTitle" type="text"
                                   class="form-control form-control-lg border-left-primary @error('title') is-invalid @enderror"
                                   wire:model.defer="title"
                                   placeholder="Enter newsletter title"
                                   style="border-radius: 10px;">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-lg-4 col-md-12 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="newsletterDate">
                                Publish Date <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                    </span>
                                </div>
                                <input id="newsletterDate" type="date"
                                       class="form-control @error('publish_date') is-invalid @enderror"
                                       wire:model.defer="publish_date"
                                       style="border-radius: 0 10px 10px 0;">
                            </div>
                            @error('publish_date') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="newsletterShortDescription">
                                Short Description
                            </label>
                            <textarea id="newsletterShortDescription" rows="2"
                                      class="form-control @error('short_description') is-invalid @enderror"
                                      wire:model.defer="short_description"
                                      placeholder="Brief summary shown on listing pages"
                                      style="border-radius: 10px;"></textarea>
                            @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Section: Content --}}
                <div class="mb-4">
                    <h6 class="text-uppercase text-primary font-weight-bold mb-3" style="font-size: .75rem; letter-spacing: .08em;">
                        <i class="fas fa-align-left mr-1"></i> Content
                    </h6>

                    <label class="font-weight-bold small text-gray-700" for="newsletterContent">
                        Newsletter Body
                    </label>
                    <input id="newsletterContent" type="hidden" wire:model.defer="content">
                    <div class="border rounded-lg overflow-hidden" style="border-radius: 10px !important;">
                        <trix-editor input="newsletterContent" class="bg-white" style="min-height: 300px;"></trix-editor>
                    </div>
                    <small class="text-muted d-block mt-1">
                        <i class="fas fa-info-circle mr-1"></i>
                        Use the toolbar to format text, add links, and create lists.
                    </small>
                    @error('content') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Section: Settings --}}
                <div class="mb-4">
                    <h6 class="text-uppercase text-primary font-weight-bold mb-3" style="font-size: .75rem; letter-spacing: .08em;">
                        <i class="fas fa-cog mr-1"></i> Settings
                    </h6>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="newsletterStatus">
                                Status <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-toggle-on text-primary"></i>
                                    </span>
                                </div>
                                <select id="newsletterStatus"
                                        class="form-control @error('status_id') is-invalid @enderror"
                                        wire:model.defer="status_id"
                                        style="border-radius: 0 10px 10px 0;">
                                    <option value="">-- Select Status --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="text-muted d-block mt-1">
                                <i class="fas fa-bolt text-warning mr-1"></i>
                                Setting to <strong>Active</strong> auto-sends emails.
                            </small>
                            @error('status_id') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="newsletterOrder">
                                Display Order
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-sort-numeric-down text-primary"></i>
                                    </span>
                                </div>
                                <input id="newsletterOrder" type="number" min="0"
                                       class="form-control @error('display_order') is-invalid @enderror"
                                       wire:model.defer="display_order"
                                       placeholder="0"
                                       style="border-radius: 0 10px 10px 0;">
                            </div>
                            @error('display_order') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Section: Files --}}
                <div class="mb-4">
                    <h6 class="text-uppercase text-primary font-weight-bold mb-3" style="font-size: .75rem; letter-spacing: .08em;">
                        <i class="fas fa-paperclip mr-1"></i> Files & Media
                    </h6>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="headerImage">
                                <i class="fas fa-image text-info mr-1"></i>
                                Header / Banner Image
                                <span class="text-muted font-weight-normal">(optional)</span>
                            </label>
                            <div class="custom-file-upload position-relative border rounded-lg p-3 text-center bg-light" style="border-radius: 10px !important; border-style: dashed !important; cursor: pointer;">
                                <input id="headerImage" type="file" class="position-absolute w-100 h-100" style="top:0;left:0;opacity:0;cursor:pointer;" wire:model="header_image" accept="image/*">
                                <div>
                                    <i class="fas fa-cloud-upload-alt text-primary mb-2" style="font-size: 1.5rem;"></i>
                                    <p class="mb-0 small text-muted">Click or drag to upload banner image</p>
                                    <small class="text-muted">Max 5 MB &bull; Recommended: 1200&times;400px</small>
                                </div>
                                <div wire:loading wire:target="header_image" class="mt-2">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                    <small class="text-primary ml-1">Uploading...</small>
                                </div>
                            </div>
                            @error('header_image') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-lg-6 col-md-12 mb-3">
                            <label class="font-weight-bold small text-gray-700" for="newsletterPdf">
                                <i class="fas fa-file-pdf text-danger mr-1"></i>
                                PDF Attachments
                                <span class="text-muted font-weight-normal">(optional)</span>
                            </label>
                            <div class="custom-file-upload position-relative border rounded-lg p-3 text-center bg-light" style="border-radius: 10px !important; border-style: dashed !important; cursor: pointer;">
                                <input id="newsletterPdf" type="file" class="position-absolute w-100 h-100" style="top:0;left:0;opacity:0;cursor:pointer;" wire:model="newsletter_pdf" multiple accept=".pdf">
                                <div>
                                    <i class="fas fa-file-upload text-danger mb-2" style="font-size: 1.5rem;"></i>
                                    <p class="mb-0 small text-muted">Click or drag to upload PDF files</p>
                                    <small class="text-muted">Max 10 MB per file &bull; Multiple allowed</small>
                                </div>
                                <div wire:loading wire:target="newsletter_pdf" class="mt-2">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                    <small class="text-primary ml-1">Uploading...</small>
                                </div>
                            </div>
                            @error('newsletter_pdf') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                            @error('newsletter_pdf.*') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Existing files when editing --}}
                    @if ($updateItem && $newsletter)
                        <div class="row mt-2">
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold small text-gray-700">
                                    <i class="fas fa-image text-info mr-1"></i> Current Header Image
                                </label>
                                @if ($newsletter->getFirstMedia('newsletter_header_images'))
                                    <div class="d-flex align-items-center justify-content-between bg-white border rounded-lg p-2" style="border-radius: 10px !important;">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $newsletter->getFirstMedia('newsletter_header_images')->getUrl() }}"
                                                 alt="Header"
                                                 class="rounded mr-3"
                                                 style="height: 55px; width: 100px; object-fit: cover; border-radius: 8px !important;">
                                            <div>
                                                <small class="d-block font-weight-bold text-gray-700">Banner Image</small>
                                                <small class="text-muted">{{ round($newsletter->getFirstMedia('newsletter_header_images')->size / 1024) }} KB</small>
                                            </div>
                                        </div>
                                        <button wire:click.prevent="removeFile({{ $newsletter->getFirstMedia('newsletter_header_images')->id }})"
                                                type="button"
                                                class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="fas fa-trash-alt mr-1"></i> Remove
                                        </button>
                                    </div>
                                @else
                                    <div class="bg-light border rounded-lg p-3 text-center" style="border-radius: 10px !important;">
                                        <i class="fas fa-image text-muted" style="font-size: 1.3rem;"></i>
                                        <p class="mb-0 small text-muted mt-1">No header image uploaded</p>
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold small text-gray-700">
                                    <i class="fas fa-file-pdf text-danger mr-1"></i> Existing PDF Files
                                </label>
                                @forelse ($newsletter->getMedia('newsletter_pdfs') as $item)
                                    <div class="d-flex align-items-center justify-content-between bg-white border rounded-lg p-2 mb-2" style="border-radius: 10px !important;">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center justify-content-center bg-danger text-white rounded mr-3"
                                                 style="width: 40px; height: 40px; border-radius: 10px !important; flex-shrink: 0;">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div>
                                                <a href="{{ $item->getUrl() }}" target="_blank" class="small font-weight-bold text-gray-700 d-block">
                                                    {{ $item->name }}
                                                </a>
                                                <small class="text-muted">{{ round($item->size / 1024) }} KB</small>
                                            </div>
                                        </div>
                                        <button wire:click.prevent="removeFile({{ $item->id }})"
                                                type="button"
                                                class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="fas fa-trash-alt mr-1"></i> Remove
                                        </button>
                                    </div>
                                @empty
                                    <div class="bg-light border rounded-lg p-3 text-center" style="border-radius: 10px !important;">
                                        <i class="fas fa-file-pdf text-muted" style="font-size: 1.3rem;"></i>
                                        <p class="mb-0 small text-muted mt-1">No PDF files attached</p>
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
                            <i class="fas {{ $updateItem ? 'fa-save' : 'fa-paper-plane' }} mr-2"></i>
                            {{ $updateItem ? 'Update Newsletter' : 'Save Newsletter' }}
                        </button>
                        @if ($updateItem)
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
                <i class="fas fa-list-alt mr-2"></i> Newsletter Records
            </h5>
            <span class="badge badge-light px-3 py-2 font-weight-bold" style="border-radius: 50px;">
                {{ $newsletters->total() }} total
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fc;">
                        <tr>
                            <th class="border-0 pl-4" style="width: 70px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Image</small>
                            </th>
                            <th class="border-0" style="width: 240px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Title</small>
                            </th>
                            <th class="border-0">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Description</small>
                            </th>
                            <th class="border-0" style="width: 110px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Date</small>
                            </th>
                            <th class="border-0" style="width: 90px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Status</small>
                            </th>
                            <th class="border-0 text-center" style="width: 60px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">PDFs</small>
                            </th>
                            <th class="border-0" style="width: 120px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Emails</small>
                            </th>
                            <th class="border-0 text-right pr-4" style="width: 220px;">
                                <small class="text-uppercase font-weight-bold text-muted" style="letter-spacing: .05em;">Actions</small>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($newsletters as $item)
                            <tr class="align-middle" style="vertical-align: middle;">
                                {{-- Image --}}
                                <td class="pl-4">
                                    @if ($item->getFirstMedia('newsletter_header_images'))
                                        <img src="{{ $item->getFirstMedia('newsletter_header_images')->getUrl() }}"
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
                                    <small class="text-muted">Order: {{ $item->display_order ?? 0 }}</small>
                                </td>

                                {{-- Description --}}
                                <td>
                                    <span class="text-gray-600 small">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($item->short_description), 80) }}
                                    </span>
                                </td>

                                {{-- Date --}}
                                <td>
                                    <small class="font-weight-bold text-gray-700">
                                        {{ \Carbon\Carbon::parse($item->publish_date)->format('d M Y') }}
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
                                        $color = $statusColors[$item->status->slug] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-{{ $color }} px-2 py-1" style="border-radius: 6px; font-size: .75rem;">
                                        {{ $item->status->name ?? '-' }}
                                    </span>
                                </td>

                                {{-- PDF Count --}}
                                <td class="text-center">
                                    @php $pdfCount = $item->getMedia('newsletter_pdfs')->count(); @endphp
                                    @if ($pdfCount > 0)
                                        <span class="badge badge-danger px-2 py-1" style="border-radius: 6px; font-size: .75rem;">
                                            <i class="fas fa-file-pdf mr-1"></i>{{ $pdfCount }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                {{-- Email Status --}}
                                <td>
                                    @if ($item->emails_sent)
                                        <span class="badge badge-success px-2 py-1" style="border-radius: 6px; font-size: .75rem;">
                                            <i class="fas fa-check-circle mr-1"></i> Sent
                                        </span>
                                        @if ($item->emails_sent_at)
                                            <br><small class="text-muted">{{ $item->emails_sent_at->format('d M Y') }}</small>
                                        @endif
                                    @else
                                        <span class="badge badge-light text-muted border px-2 py-1" style="border-radius: 6px; font-size: .75rem;">
                                            Not sent
                                        </span>
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

                                        @if (!$item->emails_sent && $item->status_id == config('constants.status.active'))
                                            <button wire:click="sendEmails({{ $item->id }})"
                                                    class="btn btn-sm btn-outline-success rounded-pill px-3"
                                                    onclick="return confirm('Send this newsletter to all {{ $subscriberCount }} subscriber(s)?')"
                                                    title="Send to subscribers">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        @endif

                                        <button onclick="deleteNewsletter({{ $item->id }})"
                                                class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div>
                                        <i class="fas fa-newspaper text-muted mb-3" style="font-size: 2.5rem; opacity: .3;"></i>
                                        <p class="text-muted mb-0 font-weight-bold">No newsletters found</p>
                                        <small class="text-muted">Create your first newsletter using the form above.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($newsletters->hasPages())
                <div class="p-3 border-top">
                    {{ $newsletters->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ============================================================
        SCRIPTS
    ============================================================ --}}
    <script>
        document.addEventListener('trix-file-accept', function (event) {
            event.preventDefault();
        });

        // Sync Trix editor content to Livewire (deferred — no re-render)
        document.addEventListener('trix-change', function (event) {
            var input = event.target.inputElement;
            if (input && input.id === 'newsletterContent') {
                @this.set('content', input.value, true);
            }
        });

        // Populate Trix editor when editing an existing newsletter
        window.addEventListener('load-trix-content', function (event) {
            function loadContent() {
                var editor = document.querySelector('trix-editor[input="newsletterContent"]');
                if (editor && editor.editor) {
                    editor.editor.loadHTML(event.detail.content || '');
                } else {
                    // Trix not ready yet — retry after a short delay
                    setTimeout(loadContent, 100);
                }
            }
            // Small delay to let Livewire finish DOM updates
            setTimeout(loadContent, 50);
        });

        function deleteNewsletter(id) {
            if (confirm("Are you sure you want to delete this newsletter?")) {
                window.livewire.emit('deleteNewsletter', id);
            }
        }
    </script>
</div>

<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">News Item Details</h1>
    </div>

    <!-- Error and Success Messages -->
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
        </div>
    </div>

    <!-- News Content Row -->
    <div class="row">
        <!-- Title Image Card -->
        <div class="col-md-4 mb-3">
            @if ($our_news_item->getFirstMedia('news_title_images') != null)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Title Image</h5>
                    </div>
                    <div class="card-body">
                        <img src="{{ $our_news_item->getFirstMedia('news_title_images')->getUrl() }}"
                            style="width:100%; max-height:300px; object-fit:cover;" alt="{{ $our_news_item->title }}"
                            class="img-fluid">
                    </div>
                </div>
            @endif
            <!-- Additional Images Card -->
            @if ($our_news_item->getMedia('news_images')->count() > 0)

                <div class="card">
                    <div class="card-header">
                        <h5>Additional Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($our_news_item->getMedia('news_images') as $item)
                                <div class="col-md-6 mb-2">
                                    <img src="{{ $item->getUrl() }}" style="width:100%; height:120px; object-fit:cover;"
                                        alt="{{ $item->name }}" class="img-thumbnail">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


        </div>
        @endif

        <!-- News Details Card -->
        <div class="col-md-8 mb-3">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $our_news_item->title }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>Author:</strong> {{ $our_news_item->author }}</p>
                    <p><strong>Post Date:</strong> {{ $our_news_item->post_date }}</p>
                    <p><strong>Category:</strong> {{ $our_news_item->category->name ?? '-' }}</p>
                    <p><strong>Status:</strong> {{ $our_news_item->status->name ?? '-' }}</p>
                    <p><strong>Short Description:</strong></p>
                    <p>{{ $our_news_item->short_description }}</p>
                    <p><strong>Details:</strong></p>
                    <p>{!! $our_news_item->details !!}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.page.item.news') }}" class="btn btn-secondary">Back to News List</a>
                    <button wire:click="edit({{ $our_news_item->id }})" data-toggle="modal" data-target="#updateModal"
                        class="btn btn-primary">Edit</button>
                    <button onclick="deleteOurNewsItem({{ $our_news_item->id }})"
                        class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Delete Confirmation Script -->
    <script>
        function deleteOurNewsItem(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.livewire.emit('deleteNews', id);
            }
        }
    </script>

    
@include('livewire.admin.news-page.update')

</div>

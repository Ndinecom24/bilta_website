<div>


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Our News Items</h1>
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

            @include('livewire.admin.news-page.create')

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
                            <h5>Our News Items</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Short Description</th>
                                <th>Post_date</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>Images</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($our_news_items) > 0)
                                @foreach ($our_news_items as $key=>$our_news_item)
                                    <tr>
                                        <td >
                                        @if ( $our_news_item->getFirstMedia('news_title_images') != null )
                                               <img  src="{{ $our_news_item->getFirstMedia('news_title_images')->getUrl()  }}"
                                                  style="width:100%; height: 60px "
                                                  title="{{ $our_news_item->getFirstMedia('news_title_images')->short_description }}">
                                        @endif
                                        </td>
                                        <td>
                                            {{$our_news_item->title}}
                                        </td>
                                        <td>
                                         {{ Str::limit(   $our_news_item->short_description , '200' , '...') }}
                                        </td>
                                        <td>
                                            {{$our_news_item->post_date}}
                                        </td>
                                        <td>
                                            {{$our_news_item->author}}
                                        </td>
                                        <td>
                                            {{$our_news_item->status->name ?? "-"}}
                                        </td>
                                        <td>
                                            {{$our_news_item->category->name  ?? "-"   }}
                                        </td>

                                         <td>

                                                <div class="row">
                                                   
                                                        {{ sizeOf($our_news_item->getMedia('news_images')) }} More Images

                                                   
                                                </div>

                                            </td>
                                      
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <a href="{{  route('admin.page.item.news.details',$our_news_item->id  )  }}" 
                                                            class="btn btn-primary btn-sm m-2">Show
                                                    </a>
                                                </div>
                                                {{-- <div class="col-6">
                                                    <button wire:click="edit({{$our_news_item->id}})"
                                                            data-toggle="modal" data-target="#updateModal"
                                                            class="btn btn-primary btn-sm m-2">Edit
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <button onclick="deleteOurNewsItem({{$our_news_item->id}})"
                                                            class="btn btn-danger btn-sm  m-2">Delete
                                                    </button>
                                                </div> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" aligne="center">
                                        No News Item Found.
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
        function deleteOurNewsItem(id) {
            if (confirm("Are you sure status_id delete this record?"))
                window.livewire.emit('deleteNews', id);
        }
    </script>

</div>

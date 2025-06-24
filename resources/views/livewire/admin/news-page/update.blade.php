<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="faqModalLabel">Update News Item</h5>
            </div>

            <div class="modal-body">
                <!-- Display Errors and Session Messages -->
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

                <!-- Form Start -->
                <form>
                    <div class="row">
                        <!-- Title -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="faqFormControlInput1">Title</label>
                                <input type="text" class="form-control" id="faqFormControlInput1"
                                    placeholder="Enter Title" wire:model="title">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Author -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="faqFormControlInput4">Author</label>
                                <input type="text" class="form-control" id="faqFormControlInput4"
                                    placeholder="Enter Author" wire:model="author">
                                @error('author')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Short Description -->
                        <div class="col-12">
                            <div class="form-group">
                                <div wire:ignore>
                                    <label for="trix-short_description">Short Description</label>
                                    <input id="trix-short_description-update" type="hidden" name="short_description">
                                    <trix-editor input="trix-short_description-update"></trix-editor>
                                </div>
                                @error('short_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Details -->
                        <div class="col-12">
                            <div class="form-group">
                                <div wire:ignore>
                                    <label for="trix-content">Details</label>
                                    <input id="trix-content-update" type="hidden" name="details">
                                    <trix-editor input="trix-content-update"></trix-editor>
                                </div>
                                @error('details')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <!-- Post Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="faqFormControlInput5">Post Date</label>
                                <input type="date" class="form-control" id="faqFormControlInput5"
                                    wire:model="post_date">
                                @error('post_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="faqFormControlInput6">Status</label>
                                <select class="form-control" id="faqFormControlInput6" wire:model="status_id">
                                    <option>--Choose--</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="faqFormControlInput7">Category</label>
                                <select class="form-control" id="faqFormControlInput7" wire:model="category_id">
                                    <option>--Choose--</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Current Image -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Current Image</label>
                                @if (isset($news) && $news->getFirstMedia('news_title_images'))
                                    <img src="{{ $news->getFirstMedia('news_title_images')->getUrl() }}"
                                        style="width:100%; height: 150px;"
                                        title="{{ $news->getFirstMedia('news_title_images')->name }}">
                                @endif
                            </div>
                        </div>

                        <!-- Upload New Image -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contactUsFormControlInputnewsImage">News Image</label>
                                <input type="file" class="form-control" id="contactUsFormControlInputnewsImage"
                                    wire:model="news_title_image">
                                @error('news_title_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>



                    <label for="ew">Remove News Images</label>
                    <div class="row">
                        @if (isset($news))
                            @foreach ($news->getMedia('news_images') as $item)
                                <div class="col-md-8 m-1">
                                    <img src="{{ $item->getUrl() }}" style="width:100%; " title="{{ $item->name }}">
                                </div>
                                <div class="col-md-3 m-1">
                                    <button wire:click.prevent="removeImage({{ $item->id }})"
                                        class="btn btn-sm btn-outline-danger">Remove</button>
                                </div>
                            @endforeach
                        @endif
                    </div>


                    <!-- Add More Images -->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput121">Add More News Images</label>
                                <input type="file" class="form-control" id="contactUsFormControlInput121" multiple
                                    wire:model="news_image">
                                @error('news_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button wire:click.prevent="update()" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>


        </div>
    </div>
</div>

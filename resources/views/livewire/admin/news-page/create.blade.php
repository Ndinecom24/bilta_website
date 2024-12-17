<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="faqModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="faqModalLabel">Create News Item</h5>
                    </div>
                    <div class="col-12">
                        <!-- Error and success messages here -->
                    </div>
                </div>
            </div>
            <form enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" id="faqFormControlInput1" placeholder="Enter Title" wire:model="title">
                                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
    
                            <!-- Author -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="faqFormControlInput4">Author</label>
                                    <input type="text" class="form-control" id="faqFormControlInput4" placeholder="Enter Author" wire:model="author">
                                    @error('author') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <!-- Short Description -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="faqFormControlInput2">Short Description</label>
                                    <textarea rows="3" class="form-control" id="faqFormControlInput2" placeholder="Enter Short Description" wire:model="short_description"></textarea>
                                    @error('short_description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <!-- Details -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="faqFormControlInput3">Details</label>
                                    <textarea rows="4" class="form-control" id="faqFormControlInput3" placeholder="Enter Details" wire:model="details"></textarea>
                                    @error('details') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <!-- Post Date -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="faqFormControlInput5">Post Date</label>
                                    <input type="date" class="form-control" id="faqFormControlInput5" wire:model="post_date">
                                    @error('post_date') <span class="text-danger">{{ $message }}</span> @enderror
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
                                    @error('status_id') <span class="text-danger">{{ $message }}</span> @enderror
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
                                    @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                        
                            <!-- Upload New Image -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="contactUsFormControlInputnewsImage">News Image</label>
                                    <input type="file" class="form-control" id="contactUsFormControlInputnewsImage" wire:model="news_title_image">
                                    @error('news_title_image') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
  
    
                        <!-- Add More Images -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="contactUsFormControlInput121">Add More News Images</label>
                                    <input type="file" class="form-control" id="contactUsFormControlInput121" multiple wire:model="news_image">
                                    @error('news_image') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button wire:click.prevent="store()" class="btn btn-primary close-modal">Save changes</button>
                </div>
            </form>
        </div>
    </div>
 
   
</div>



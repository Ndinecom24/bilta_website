<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="faqModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="faqModalLabel">Create Gallery Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput10">Video Link</label>
                                <input type="url" class="form-control" id="contactUsFormControlInput10"
                                       placeholder="Enter Url" wire:model.defer="video_link">
                                @error('video_link') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput1">Name</label>
                                <input type="text" class="form-control" id="faqFormControlInput1"
                                          placeholder="Enter Name" wire:model.defer="name">
                                @error('name') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput2">Description</label>
                                <textarea rows="3" class="form-control" id="faqFormControlInput2" wire:model.defer="description"
                                          placeholder="Enter Description"></textarea>
                                @error('description') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput2">Type</label>

                                <select  required class="form-control" id="faqFormControlInput3" wire:model.defer="type" >
                                    <option>--Choose--</option>
                                   <option value="Videos">Videos</option>
                                </select>
                                @error('type') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="item_category_id">Category</label>
                                <select  class="form-control" id="item_category_id" wire:model.defer="item_category_id" >
                                    <option>--Choose--</option>
                                    @foreach($item_categories as $item_category )
                                        <option value="{{$item_category->id}}">{{$item_category->name}}</option>
                                    @endforeach
                                </select>
                                @error('item_category_id') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                                <label for="status_id">Status</label>
                                <select  class="form-control" id="status_id" wire:model.defer="status_id" >
                                    <option>--Choose--</option>
                                    @foreach($statuses as $status )
                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button wire:click.prevent="store()" class="btn btn-primary close-modal">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


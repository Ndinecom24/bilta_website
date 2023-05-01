<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="faqModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-question" id="faqModalLabel">Create Home Intro </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <form enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput1">Name</label>
                                <input type="text" class="form-control" id="faqFormControlInput1"
                                          placeholder="Enter Name" wire:model="name">
                                @error('name') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="faqFormControlInput2">Short Description</label>
                        <textarea rows="3" class="form-control" id="faqFormControlInput2" wire:model="short_description"
                                  placeholder="Enter short_description"></textarea>
                        @error('short_description') <span
                            class="form-check-label text-danger ">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="faqFormControlInput2">Long Description</label>
                        <textarea rows="3" class="form-control" id="faqFormControlInput2" wire:model="long_description"
                                  placeholder="Enter long_description"></textarea>
                        @error('long_description') <span
                            class="form-check-label text-danger ">{{ $message }}</span>@enderror
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput10">User Image</label>
                                <input type="file" class="form-control" id="contactUsFormControlInput10"
                                       placeholder="Enter Image" wire:model="intro_image">
                                @error('intro_image') <span class="text-danger ">{{ $message }}</span>@enderror
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


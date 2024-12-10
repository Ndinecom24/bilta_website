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
                    <!-- Title and Description Inputs -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput2">Short_description</label>
                                <textarea rows="3" class="form-control" id="faqFormControlInput2" placeholder="Enter Short_description"
                                          wire:model="short_description"></textarea>
                                @error('short_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput3">Details</label>
                                <textarea rows="4" class="form-control" id="faqFormControlInput3" placeholder="Enter Details"
                                          wire:model="details"></textarea>
                                @error('details')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Other Form Fields -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button wire:click.prevent="store()" class="btn btn-primary close-modal">Save changes</button>
                </div>
            </form>
        </div>
    </div>
 
   
</div>



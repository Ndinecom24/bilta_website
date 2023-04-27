<!-- Modal -->
<div wire:ignore.self class="modal fade" id="aboutUsModal" tabindex="-1" role="dialog" aria-labelledby="aboutUsModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutUsModalLabel">Create About Us</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="aboutUsFormControlInput1">Mission</label>
                                <textarea rows="3" class="form-control" id="aboutUsFormControlInput1"
                                          placeholder="Enter Mission" wire:model="mission"></textarea>
                                @error('mission') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="aboutUsFormControlInput2">Vision</label>
                                <textarea rows="3" class="form-control" id="aboutUsFormControlInput2" wire:model="vision"
                                          placeholder="Enter Vision"></textarea>
                                @error('vision') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="aboutUsFormControlInput3">Objective</label>
                                <textarea rows="3" class="form-control" id="aboutUsFormControlInput3" wire:model="objective"
                                          placeholder="Enter Objective"></textarea>
                                @error('objective') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="aboutUsFormControlInput4">Description</label>
                                <textarea rows="3"  class="form-control" id="aboutUsFormControlInput4" wire:model="description"
                                          placeholder="Enter Description"></textarea>
                                @error('description') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="aboutUsFormControlInput5">What is Bilta</label>
                                <textarea rows="3"  class="form-control" id="aboutUsFormControlInput5" wire:model="what_is"
                                          placeholder="Enter What Bilta is"></textarea>
                                @error('what_is') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="aboutUsFormControlInput6">Who we are</label>
                                <textarea rows="3"  class="form-control" id="aboutUsFormControlInput6" wire:model="who_we_are"
                                          placeholder="Enter Who we are details"></textarea>
                                @error('who_we_are') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button wire:click.prevent="store()" class="btn btn-primary close-modal"  data-dismiss="modal">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


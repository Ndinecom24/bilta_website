<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update About Us</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <input hidden type="text" class="form-control" id="about_usFormControlInput3"
                                   wire:model="about_us_id">
                            <div class="form-group">
                                <label for="about_usFormControlInput1">Mission</label>
                                <textarea rows="3"  class="form-control" id="about_usFormControlInput1"
                                          placeholder="Enter Mission" wire:model="mission"></textarea>
                                @error('mission') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label for="about_usFormControlInput2">Vision</label>
                                <textarea rows="3"  class="form-control" id="about_usFormControlInput2" wire:model="vision"
                                          placeholder="Enter Vision"></textarea>
                                @error('vision') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="aboutUsFormControlInput3">Objective</label>
                                <textarea rows="3"  class="form-control" id="aboutUsFormControlInput3" wire:model="objective"
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
                    <button wire:click.prevent="update()"  data-dismiss="modal" class="btn btn-success ">Save</button>
                    <button wire:click.prevent="cancel()"  data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>



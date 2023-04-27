<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="contactUsModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactUsModalLabel">Create Our Values</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput1">Phone</label>
                                <input type="text" class="form-control" id="contactUsFormControlInput1"
                                       placeholder="Enter Phone" wire:model="phone">
                                @error('phone') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput4">Email</label>
                                <input type="text" class="form-control" id="contactUsFormControlInput4"
                                       placeholder="Enter Email" wire:model="email">
                                @error('email') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput3">Address</label>
                                <textarea rows="3" class="form-control" id="contactUsFormControlInput3" wire:model="address"
                                          placeholder="Enter Address"></textarea>
                                @error('address') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput19">Message</label>
                                <textarea rows="3" class="form-control" id="contactUsFormControlInput19" wire:model="message"
                                          placeholder="Enter Address"></textarea>
                                @error('message') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput2">Google Maps</label>
                                <textarea rows="3" class="form-control" id="contactUsFormControlInput2" wire:model="google_maps"
                                          placeholder="Enter Google Maps"></textarea>
                                @error('google_maps') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput5">Youtube Link</label>
                                <input type="text" class="form-control" id="contactUsFormControlInput5"
                                       placeholder="Enter Youtube Link" wire:model="youtube">
                                @error('youtube') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput6">WhatsApp Link</label>
                                <input type="text" class="form-control" id="contactUsFormControlInput6"
                                       placeholder="Enter WhatsApp Link" wire:model="whatsapp_link">
                                @error('whatsapp_link') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput7">Twitter Link</label>
                                <input type="text" class="form-control" id="contactUsFormControlInput7"
                                       placeholder="Enter Twitter Link" wire:model="twitter_url">
                                @error('twitter_url') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput8">LinkedIn Link</label>
                                <input type="text" class="form-control" id="contactUsFormControlInput8"
                                       placeholder="Enter LinkedIn Link" wire:model="linkedin_url">
                                @error('linkedin_url') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput9">Facebook Link</label>
                                <input type="text" class="form-control" id="contactUsFormControlInput9"
                                       placeholder="Enter Facebook Link" wire:model="facebook_url">
                                @error('facebook_url') <span class="text-danger ">{{ $message }}</span>@enderror
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


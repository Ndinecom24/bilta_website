<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="faqModalLabel">Update Our Values</h5>
                    </div>
                    <div class="col-12">
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
                    </div>
                </div>
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
                    <button wire:click.prevent="update()" class="btn btn-success ">Save</button>
                    <button wire:click.prevent="cancel()" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>



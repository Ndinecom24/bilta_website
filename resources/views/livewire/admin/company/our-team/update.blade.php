<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="faqModalLabel">Update Our Team</h5>
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
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput2">Email</label>
                                <input type="email" class="form-control" id="faqFormControlInput2"
                                       placeholder="Enter Email" wire:model="email">
                                @error('email') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput3">Phone</label>
                                <input type="text" class="form-control" id="faqFormControlInput3"
                                       placeholder="Enter Phone" wire:model="phone">
                                @error('phone') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput4">Position</label>
                                <input type="text" class="form-control" id="faqFormControlInput4"
                                       placeholder="Enter Position" wire:model="position">
                                @error('position') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput5">Position From</label>
                                <input type="text" class="form-control" id="faqFormControlInput5"
                                       placeholder="Enter Name" wire:model="from">
                                @error('from') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput11">Position To</label>
                                <input type="text" class="form-control" id="faqFormControlInput11"
                                       placeholder="Enter Date" wire:model="to">
                                @error('to') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput6">Details</label>
                                <textarea rows="3" class="form-control" id="faqFormControlInput6" wire:model="details"
                                          placeholder="Enter Details"></textarea>
                                @error('details') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
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
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput10">Current Image</label>
                                @if(isset($team))
                                    <img  src="{{ $team->getFirstMedia('team_images')->getUrl()  }}"
                                            style="width:100%; height: 150px "
                                            title="{{ $team->getFirstMedia('team_images')->name }}">

                                @endif
                                @error('user_image') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput10">User Image</label>
                                <input type="file" class="form-control" id="contactUsFormControlInput10"
                                       placeholder="Enter Image" wire:model="user_image">
                                @error('user_image') <span class="text-danger ">{{ $message }}</span>@enderror
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



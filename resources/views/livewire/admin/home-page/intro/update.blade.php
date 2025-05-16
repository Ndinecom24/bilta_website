<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Home Intro </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>×</span>
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
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput10">Current Image</label>
                                @if(isset($home_intro))
                                    @if( $home_intro->getFirstMedia('home_intro_images') ?? '00' != '00')
                                    <img  src="{{ $home_intro->getFirstMedia('home_intro_images')->getUrl()  }}"
                                            style="width:100%; height: 150px "
                                            title="{{ $home_intro->getFirstMedia('home_intro_images')->name }}">
                                    @endif

                                @endif
                                @error('intro_image') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput10">
                                    Intro Image <small class="text-muted">(Max size: 1 MB)</small>
                                </label>
                                <input type="file" class="form-control" id="contactUsFormControlInput10"
                                       placeholder="Enter Image" wire:model="intro_image" onchange="validateFileSize(this)">
                                @error('intro_image') <span class="text-danger ">{{ $message }}</span>@enderror
                                <small id="fileSizeError" class="text-danger" style="display:none;">File size must be 1 MB or less.</small>
                            </div>
                        </div>
                        
                        <script>
                            function validateFileSize(input) {
                                const file = input.files[0];
                                const maxSize = 1 * 1024 * 1024; // 1 MB in bytes
                                const errorMsg = document.getElementById('fileSizeError');
                        
                                if (file && file.size > maxSize) {
                                    errorMsg.style.display = 'block';
                                    input.value = '';  // Clear the input so user can try again
                                    alert('File size must be 1 MB or less.');
                                } else {
                                    errorMsg.style.display = 'none';
                                }
                            }
                        </script>
                        
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




<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updatePasswordModal" tabindex="-1" user="dialog" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg " user="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">Password Change</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span >×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('One Time Password') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text"
                                   class="form-control @error('password') is-invalid @enderror" name="password"
                                   wire:model="password" required autocomplete="password" autofocus>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button wire:click.prevent="updatePassword()" data-dismiss="modal" class="btn btn-warning close-modal">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>



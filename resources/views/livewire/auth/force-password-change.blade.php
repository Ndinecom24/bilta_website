<div>
    <div class="container">
        <div class="row justify-content-center" style="min-height: 70vh; align-items: center;">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-sm border-0" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-header text-center text-white py-4" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
                        <i class="fas fa-shield-alt fa-2x mb-2"></i>
                        <h4 class="mb-1 font-weight-bold">Password Change Required</h4>
                        <p class="mb-0" style="font-size: .88rem; opacity: .9;">
                            Your password was reset by an administrator. Please set a new password to continue.
                        </p>
                    </div>

                    <div class="card-body p-4">
                        @if (session()->has('error'))
                            <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
                        @endif

                        <form wire:submit.prevent="changePassword">
                            <div class="mb-3">
                                <label class="font-weight-bold text-dark" for="forceNewPassword">
                                    <i class="fas fa-lock mr-1 text-muted"></i> New Password
                                </label>
                                <input id="forceNewPassword" type="password" class="form-control form-control-lg"
                                    wire:model.defer="password" autocomplete="new-password" required
                                    placeholder="Minimum 8 characters"
                                    style="border-radius: 10px;">
                                @error('password')
                                    <span class="text-danger d-block mt-1" style="font-size: .85rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="font-weight-bold text-dark" for="forceConfirmPassword">
                                    <i class="fas fa-lock mr-1 text-muted"></i> Confirm New Password
                                </label>
                                <input id="forceConfirmPassword" type="password" class="form-control form-control-lg"
                                    wire:model.defer="password_confirmation" autocomplete="new-password" required
                                    placeholder="Re-enter your new password"
                                    style="border-radius: 10px;">
                            </div>

                            <button type="submit" class="btn btn-danger btn-lg btn-block font-weight-bold"
                                style="border-radius: 10px;">
                                <span wire:loading.remove wire:target="changePassword">
                                    <i class="fas fa-check-circle mr-1"></i> Set New Password
                                </span>
                                <span wire:loading wire:target="changePassword">
                                    <span class="spinner-border spinner-border-sm mr-1"></span> Processing...
                                </span>
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link text-muted" style="font-size: .85rem;">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Logout instead
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-footer text-center py-3" style="background: #f8fafc;">
                        <small class="text-muted">
                            <i class="fas fa-info-circle mr-1"></i>
                            Choose a strong password with at least 8 characters.
                        </small>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

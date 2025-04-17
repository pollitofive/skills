<div>
    <h1>Change your password</h1>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="p-2">
                        <form wire:submit="submitForm">
                            @include('message-confirmation')
                            <div class="mb-3">
                                <label class="form-label" for="password-input">Old Password</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" name="old_password" wire:model="old_password" class="form-control pe-5 password-input" onpaste="return false" placeholder="Enter old password" id="old_password" aria-describedby="passwordInput" required="" tabindex="1">
                                </div>
                                @error('old_password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password-input">New Password</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" name="new_password" wire:model="new_password" class="form-control pe-5 password-input" onpaste="return false" placeholder="Enter new password" id="new_password" aria-describedby="passwordInput" required="" tabindex="2">
                                </div>
                                @error('new_password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="confirm-password-input">Confirm Password</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" name="new_password_confirmation" wire:model="new_password_confirmation" class="form-control pe-5 password-input" onpaste="return false" placeholder="Confirm new password" id="new_password_confirmation" required="" tabindex="3">
                                </div>
                                @error('new_password_confirmation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="row mt-3 justify-content-end">
                                <div class="col-sm-2">
                                    <button wire:submit="submitForm" class="btn btn-outline-success" type="submit" id="button-addon2"  tabindex="4">Save</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
    </div>
</div>

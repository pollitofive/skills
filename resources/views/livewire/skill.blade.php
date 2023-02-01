<div>
    <h1>Skills</h1>
    <form wire:submit.prevent="submitForm">
        <div>
            @if ($message)
                <div class="alert alert-success align-items-center d-flex">
                    <span class="card-title mb-0 flex-grow-1">{{ $message }}</span>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a wire:click="$set('message',null)" class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted fs-18"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-xxl-3 col-md-6">
            <div>
                <div class="input-group">
                    <input wire:model.defer="name" type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button wire:submit.prevent="submitForm" class="btn btn-outline-success" type="submit" id="button-addon2">Save</button>
                </div>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
    </form>
</div>

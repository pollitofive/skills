<div>
    <h1>Skills</h1>
    <form wire:submit="submitForm">
        @include('message-confirmation')
        <div class="col-xxl-3 col-md-6">
            <div>
                <div class="input-group">
                    <input wire:model="name" type="text" placeholder="New skill" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button wire:submit="submitForm" class="btn btn-outline-success" type="submit" id="button-addon2">Save</button>
                </div>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
    </form>
</div>

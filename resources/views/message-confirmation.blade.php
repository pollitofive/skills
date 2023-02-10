<div>
    @if ($message)
        <div class="alert alert-success align-items-center d-flex" id="message-confirmation">
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
<script>
    window.addEventListener('hide-message', () => {
        setTimeout(() => {
            const element = document.getElementById('message-confirmation');
            element.classList.remove("d-flex");
            element.style.display = 'none';
        }, 5000);
    });
</script>

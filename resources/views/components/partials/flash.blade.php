@if (flash()->message)
    <div class="alert alert-{{ flash()->class ?? 'info' }} alert-dismissible fade show" role="alert">
        <div class="alert-message">
            {{ flash()->message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

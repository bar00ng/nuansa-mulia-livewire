<div>
    <x-page-header pageName="Client" />

    <x-partials.flash />

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h4 class="m-0 font-weight-bold text-primary">List Client</h4>
                    <a href={{ route('client.create') }} class="btn btn-primary" wire:navigate>
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Client</span>
                    </a>
                </div>
                <div class="card-body">
                    <livewire:tables.client-table />
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript" data-navigate-once>
    document.addEventListener('livewire:navigated', function () {

        @this.on('trigger-delete-client', client => {
            Swal.fire({
                title: 'Are You Sure?',
                text: 'Conatct record will be deleted!',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Delete!'
            }).then((result) => {
         //if user clicks on delete
                if (result.value) {
             // calling destroy method to delete
                    @this.call('destroy', client)
             // success response
                    Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
                } else {
                    Swal.fire({
                        title: 'Operation Cancelled!',
                        icon: 'success'
                    });
                }
            });
        });
    })
</script>
@endpush


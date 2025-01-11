<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title mb-5">{{ $title }} ?</h5>
                <div class="row">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#{{ $id }} .btn-cancel').on('click', function () {
        $('#{{ $id }}').modal('hide')
    })
</script>

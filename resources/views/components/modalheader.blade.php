<div class="modal fade" id="modalForm" wire:ignore.self tabindex="-1" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style="min-width:60%;">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0 px-4 pt-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); border-radius: .4rem .4rem 0 0;">
                <div>
                    <div class="text-uppercase small" style="color: rgba(255,255,255,.65); letter-spacing: .06em;">
                        {{ $Id > 0 ? 'Edicion de contacto' : 'Nuevo contacto' }}
                    </div>
                    <h4 class="modal-title mb-0 text-white">
                        {{ $Id > 0 ? 'ID: ' . $Id : 'Registrar contacto' }}
                    </h4>
                </div>
                <button type="button" class="close text-white" wire:click="clear" data-dismiss="modal"
                    aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-4 pb-3">

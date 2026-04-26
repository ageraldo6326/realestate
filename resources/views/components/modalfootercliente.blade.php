            </div>
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-outline-secondary" wire:click="clear" data-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-primary px-4"
                    @if ($Id == 0) wire:click.prevent="store" @else wire:click.prevent="update({{ $Id }})" @endif>
                    {{ $Id == 0 ? 'Guardar' : 'Actualizar' }}
                </button>
                <button type="button" class="btn btn-outline-secondary" wire:click="clear" data-dismiss="modal">
                    Salir
                </button>
            </div>
            </div>
            </div>
            </div>



            <script>
                document.addEventListener('close-modal', event => {
                    $('#modalForm').modal('hide');
                })
                document.addEventListener('close-modal-delete', event => {
                    $('#modalFormDelete').modal('hide');
                })
                document.addEventListener('propuesta', event => {

                    window.open('/admin/clientes/veropciones/' + event.detail.id, '_blank');

                })
            </script>

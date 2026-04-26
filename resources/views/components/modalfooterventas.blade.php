            </div>
            {{-- <div class="modal-footer">
                <form>
                    <button type="button" class="btn btn-secondary close-modal" wire:click='clear' data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary close-modal" @if($Id==0) wire:click.prevent='store' @else wire:click.prevent='update({{$Id}})' @endif> @if($Id==0) Grabar  @else Actualizar @endif </button>
                </form>
            </div> --}}
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
            window.open('/admin/clientes/veropciones/'+event.detail.id);
            window.open('/admin/clientes/veropciones/'+event.detail.id);
    })    
</script>
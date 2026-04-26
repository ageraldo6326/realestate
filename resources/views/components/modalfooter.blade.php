            </div>
            <div class="modal-footer">
                <form>
                    <button type="button" class="btn btn-secondary close-modal shadow" wire:click='clear'  data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary close-modal shadow" @if($Id==0) wire:click.prevent='store' @else wire:click.prevent='update({{$Id}})' @endif> @if($Id==0) Grabar  @else Actualizar @endif </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>   
    document.addEventListener('close-modal', event => {
        $('#modalForm').modal('hide');
    });  

</script> 
            </div>
            <div class="modal-footer">
                <form>
                    <button type="button" class="btn btn-secondary close-modal" wire:click='clear' data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger close-modal" data-dismiss="modal" wire:click='delete({{ $Id }})'>Borrar</button>
                </form>
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
</script>
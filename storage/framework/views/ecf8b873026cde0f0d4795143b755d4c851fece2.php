            </div>
            <div class="modal-footer">
                <form>
                    <button type="button" class="btn btn-secondary close-modal shadow" wire:click='clear'  data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary close-modal shadow" <?php if($Id==0): ?> wire:click.prevent='store' <?php else: ?> wire:click.prevent='update(<?php echo e($Id); ?>)' <?php endif; ?>> <?php if($Id==0): ?> Grabar  <?php else: ?> Actualizar <?php endif; ?> </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>   
    document.addEventListener('close-modal', event => {
        $('#modalForm').modal('hide');
    });  

</script> <?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\components\modalfooter.blade.php ENDPATH**/ ?>
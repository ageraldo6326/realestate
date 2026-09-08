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
            window.open('/admin/clientes/veropciones/'+event.detail.id);
            window.open('/admin/clientes/veropciones/'+event.detail.id);
    })    
</script><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\components\modalfooterventas.blade.php ENDPATH**/ ?>
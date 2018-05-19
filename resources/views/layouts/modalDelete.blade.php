@push('javascript')
    <script>
        $(document).ready(function(){
            $('.confirm_delete').click(function(event){
                var btndelete = $(this);
                $('#delete').off( "click").click(function(){
                        btndelete.closest('form').submit();
                }); 
            });
        });
	</script>
@endpush


<div id="confirm" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <h4>Tem certeza que quer deletar este registro?</h4>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" id="delete" class="btn btn-danger">Apagar Registro</button>
                    <button type="button" data-dismiss="modal" id="cancel" class="btn btn-default">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div> 
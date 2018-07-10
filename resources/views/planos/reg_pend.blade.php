@extends('layouts.adminlte')

@push('tituloAba')
    Planos
@endpush

@section('breadcrumb')
<h1>
    Aprovação
    <small>Pendências</small>
</h1>

{!! Breadcrumbs::render('aprv_pend', $plano) !!}

@endsection
     
@push('javascript')
	<!-- Tinymce -->
  	<script src="{{ asset ('/bower_components/tinymce/tinymce.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
		tinymce.init({
            selector: '.textareaTinymce',          
            menubar: false,
            plugins: "advlist lists autolink link autosave save charmap hr searchreplace table",
            
            toolbar1: 'undo redo | restoredraft | link unlink | table subscript superscript charmap blockquote hr searchreplace',
            toolbar2: 'styleselect | bold italic strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | fontselect fontsizeselect | removeformat',
            
            browser_spellcheck: true,
            contextmenu: false,
            toolbar_items_size: 'small',
            autosave_ask_before_unload: false,
            autosave_interval: "30s",
            content_style: "p{padding:0; margin:0;}",
        }); 
	</script>

 
    <script>
        $(document).ready(function(){
            $('.submit_modal').click(function(event){
                var btndelete = $(this);
                $('#confirm').show(); 
                $('#enviar').off( "click").click(function(){
                        btndelete.closest('form').submit();
                }); 
            });
        });
	</script>

    
@endpush

@section('content')
	<div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            @if(count($pendencias) > 0)
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Pendências Anteriores</h3>
                    <div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div><!-- end box-tools pull-right -->
                </div><!-- end box-header -->
                <div class="box-body">
                    @foreach($pendencias as $pend)
                    <div class="well">
                        <div class="pull-right">{{ Carbon\Carbon::parse($pend->created_at)->format('d-m-Y / H:i') }}</div><br><br>
                        {!!$pend->pendencia!!}
                    </div>
					@endforeach
                </div>
            </div>
            @endif
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Pendências</h3>
                </div><!-- end box-header -->
                <div class="box-body">
                    <form role="form" action="/planos/registrarPendencia" method="post"> 
                        {{ csrf_field() }}
                        <input type="text" name="plano_id" value="{{$plano->id}}" hidden>
                        <div class="form-group">
                            <textarea class="form-control textareaTinymce" name="pendencia"></textarea>
                        </div><!-- end form-group -->
                        <div class="row">
                            <div class="form-group col-md-2 col-md-offset-10">
                                <button type="button" class="btn btn-ufop btn-md btn-block submit_modal" data-toggle="modal" data-target="#enviar_modal">Enviar</button>
                            </div><!-- end form-group col-md-2 col-md-offset-10 -->
                        </div><!-- end row -->
                    </form>
                </div><!-- end box-body -->
            </div><!-- end box box-primary-ufop -->
        </div><!-- end col-md-8 col-md-offset-2 -->  
    </div><!-- end row -->
    

    <div id="enviar_modal" class="modal fade">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>Esta ação irá criar uma mensagem de pendências e devolver o acesso deste plano para o professor responsável em modo de Edição.
                    Deseja continuar?
                    </h4>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" id="enviar" class="btn btn-warning">Sim</button>
                        <button type="button" data-dismiss="modal" id="cancel" class="btn btn-default">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection
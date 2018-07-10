@extends('planos.edit_layout')

@push('tituloPlano')
	(Metodologia)
@endpush
     
@section('breadcrumb')
<h1>
    Planos
    <small>Metodologia</small>
</h1>

{!! Breadcrumbs::render('planoMetod', $plano) !!}

@endsection

@push('javascript')
	<!-- Tinymce -->
  	<script src="{{ asset ('/bower_components/tinymce/tinymce.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
		tinymce.init({
            selector: '.textareaTinymce',          
            menubar: false,
            plugins: "advlist lists autolink link autosave save charmap hr searchreplace table",

            toolbar1: 'undo redo | restoredraft save | link unlink | table subscript superscript charmap blockquote hr searchreplace',
            toolbar2: 'styleselect | bold italic strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | fontselect fontsizeselect | removeformat',
            
            browser_spellcheck: true,
            contextmenu: false,
            toolbar_items_size: 'small',
            autosave_ask_before_unload: false,
            autosave_interval: "30s",
            content_style: "p{padding:0; margin:0;}",
			height : "300",
        }); 
	</script>
@endpush

@section('edit-content')
<div class="tab-pane" id="metodologia">
	<h4>
		<span>Apresentar o conjunto das ações a serem desenvolvidas durante o semestre letivo para desenvolver o conteúdo programático e alcançar os objetivos propostos.</span>
	</h4>
	<br>
	<form role="form" action="/planos/metodologia" method="post"> 
		{{ csrf_field() }}
		<input type="text" name="plano_id" value="{{$plano->id}}" hidden>
		<div class="form-group">
			<textarea class="form-control textareaTinymce" name="metodologia">{{$plano->metodologia}}</textarea>
		</div><!-- end form-group -->
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-10">
				<button type="submit" name="submitbtn" class="btn btn-ufop btn-md btn-block">Salvar</button>
			</div><!-- end form-group col-md-2 col-md-offset-10 -->
		</div><!-- end row -->
	</form>
</div>
@endsection
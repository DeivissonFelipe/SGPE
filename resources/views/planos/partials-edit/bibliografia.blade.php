@extends('planos.edit_layout')

@push('tituloPlano')
	(Bibliografia)
@endpush

@section('breadcrumb')
<h1>
    Planos
    <small>Bibliografia</small>
</h1>

{!! Breadcrumbs::render('planoBib', $plano) !!}

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
        }); 
	</script>
@endpush

@section('edit-content')
<div class="tab-pane" id="bibliografia">
    
	<div class="alert alert-info alert-dismissible">
		<span>Indicar no mínimo três e no máximo cinco obras, de acordo com os livros que estão na biblioteca da unidade. 
			<strong><a href="http://200.239.128.190/pergamum/biblioteca/index.php" style="color:#0000FF">Link da biblioteca</a></strong></span>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	</div>

	<div class="box box-primary-ufop ">
        <div class="box-header with-border">
          <h3 class="box-title">Bibliografia Básica</h3>
		  <div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div><!-- end box-tools pull-right -->
        </div><!-- end box-header with-border -->

        <div class="box-body">
			<form role="form" action="/planos/bibliografiab" method="post"> 
				{{ csrf_field() }}
				<input type="text" name="plano_id" value="{{$plano->id}}" hidden>
				<div class="form-group">
					<textarea class="form-control textareaTinymce" name="bibliografiab">{{$plano->bibliografiab}}</textarea>
				</div><!-- end form-group -->
				<div class="row">
					<div class="form-group col-md-2 col-md-offset-10">
						<button type="submit" name="submitbtn" class="btn btn-ufop btn-md btn-block">Salvar</button>
					</div><!-- end form-group col-md-2 col-md-offset-10 -->
				</div><!-- end row -->
			</form>
        </div><!-- end box-body -->
    </div><!-- end box box-primary-ufop collapsed-box -->

	<div class="alert alert-info alert-dismissible">
		<span>Indicar no mínimo cinco e no máximo sete obras, de acordo com os livros que estão na biblioteca da unidade. 
			<strong><a href="http://200.239.128.190/pergamum/biblioteca/index.php" style="color:#0000FF">Link da biblioteca</a></strong></span>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	</div>

	<div class="box box-primary-ufop collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">Bibliografia Complementar</h3>
		  <div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
          </div><!-- end box-tools pull-right -->
        </div><!-- end box-header with-border -->

        <div class="box-body">
			<form role="form" action="/planos/bibliografiac" method="post"> 
				{{ csrf_field() }}
				<input type="text" name="plano_id" value="{{$plano->id}}" hidden>
				<div class="form-group">
					<textarea class="form-control textareaTinymce" name="bibliografiac">{{$plano->bibliografiac}}</textarea>
				</div><!-- end form-group -->
				<div class="row">
					<div class="form-group col-md-2 col-md-offset-10">
						<button type="submit" name="submitbtn" class="btn btn-ufop btn-md btn-block">Salvar</button>
					</div><!-- end form-group col-md-2 col-md-offset-10 -->
				</div><!-- end row -->
			</form>
        </div><!-- end box-body -->
    </div><!-- end box box-primary-ufop collapsed-box -->

</div>
@endsection


@extends('layouts.adminlte')

@push('tituloAba')
	Disciplinas
@endpush

@section('breadcrumb')

<h1>
	Disciplinas
	<small>+ Info</small>
</h1>

{!! Breadcrumbs::render('info', $disciplina) !!}

@endsection
     
@push('javascript')
	<script type="text/javascript">
		$(document).ready(function(){
		 
			var tabs = $('a[data-toggle="tab"]');
			if(window.location.hash === ''){
			window.location.hash = tabs[0].hash;
			}

			var hash = window.location.hash;
			hash && $('ul.nav a[href="' + hash + '"]').tab('show');

			$('.nav-tabs a').click(function (e) {
				$(this).tab('show');
				var scrollmem = $('body').scrollTop() || $('html').scrollTop();
				window.location.hash = this.hash;
				$('html,body').scrollTop(scrollmem);
			});

			// Change tab on hashchange
			window.addEventListener('hashchange', function() {
				var changedHash = window.location.hash;
				changedHash && $('ul.nav a[href="' + changedHash + '"]').tab('show');
			}, false);

		});

	</script>

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



@section('content')
	<div class="container-fluid">
		<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
			<div class="box box-primary-ufop">
			    <div class="box-header">
			    	<h2 class="page-header">Disciplina : {{$disciplina->nome}}</h2>
			    </div><!-- end box-header -->
			    <div class="box-body">
					<div class="nav-tabs-custom">
					    <ul class="nav nav-tabs">
					      <li class="active"><a href="#ementa" data-toggle="tab">Ementa</a></li>
					      <li><a href="#conteudo" data-toggle="tab">Conteúdo Programático</a></li>
					      <li><a href="#bibb" data-toggle="tab">Bibliografia Básica</a></li>
					      <li><a href="#bibc" data-toggle="tab">Bibliografia Complementar</a></li>
					    </ul>
					    <div class="tab-content">
							@include('disciplinas.partials-info.ementa')

							@include('disciplinas.partials-info.conteudo')

							@include('disciplinas.partials-info.bib-basica')
							
							@include('disciplinas.partials-info.bib-complementar') 
					    </div><!-- end tab-content -->
					</div><!-- end nav-tabs-custom -->
			    </div><!-- end box-body -->
			</div><!-- end box box-primary-ufop -->
		</div><!-- end col-lg-8 col-lg-offset-2  col-md-10 col-md-offset-1 --> 
	</div><!-- end container-fluid -->
@endsection
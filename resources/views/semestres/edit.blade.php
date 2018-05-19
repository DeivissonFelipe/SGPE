@extends('layouts.adminlte')

@push('tituloAba')
	Semestres
@endpush

@push('css')
	<!-- Datepicker v1.7.1 -->
	<link href="{{ asset('/jquery-ui-1.12.1.custom-ufop/jquery-ui.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('javascript')
	<!-- Datepicker v1.7.1 -->
	<script src="{{ asset ('/jquery-ui-1.12.1.custom-ufop/jquery-ui.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
		    $( '.datepicker-me').datepicker({
				autoclose: true,
				orientation: "bottom",
				dateFormat: 'dd-mm-yy',
		    });
		});
	</script>
@endpush

@section('breadcrumb')

<h1>
	Semestres
	<small>Edição</small>
</h1>

{!! Breadcrumbs::render('semestreId', $semestre) !!}

@endsection

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="box box-primary-ufop">
	            <div class="box-header with-border">
	              <h3 class="box-title">Editar Semestre</h3>
	            </div><!-- end box-header with-border -->

	            <form role="form" action="/semestres/{{ $semestre->id }}" method="post"> 
	            	{{ method_field('PATCH') }}
					{{ csrf_field() }}

					<div class="box-body">
						<div class="form-group">
							<label for="rotulo">Rotulo</label>
							<input type="text" class="form-control" name="rotulo" id="rotulo" placeholder="Rotulo do semestre" value="{{$semestre->rotulo}}" />
						</div><!-- end form-group -->

						<div class="form-group">
							<label>Inicio do Semestre:</label>
							<div class="input-group" data-provide="datepicker">
							  <div class="input-group-addon">
							    <i class="fa fa-calendar"></i>
							  </div><!-- end input-group-addon -->
							  <input type="text" class="form-control pull-right date datepicker-me" id="inicio" name="inicio" value="{{$semestre->fim}}">
							</div><!-- end input-group-->
						</div><!-- end form-group -->
						
						<div class="form-group">
							<label>Final do Semestre:</label>
							<div class="input-group" data-provide="datepicker">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div><!-- end input-group-addon -->
								<input type="text" class="form-control pull-right date datepicker-me" id="fim" name="fim" value="{{$semestre->fim}}">
							</div><!-- end input-group -->
						</div><!-- end form-group -->
					</div><!-- end box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-block btn-primary">Salvar</button>
					</div><!-- end box-footer -->
	            </form>
	        </div><!-- end box box-primary-ufop -->
		</div><!-- end col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 -->
	</div><!-- end row -->
@endsection

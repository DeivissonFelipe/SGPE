@extends('layouts.adminlte')

@push('tituloAba')
	Feriados
@endpush

@push('css')
	<!-- Datepicker v1.7.1 -->
	<link href="{{ asset('/jquery-ui-1.12.1.custom-ufop/jquery-ui.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/css/ajax.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('javascript')
	<!-- Datepicker v1.7.1 -->
	<script src="{{ asset ('/jquery-ui-1.12.1.custom-ufop/jquery-ui.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			var d_inicio = {{\Carbon\Carbon::parse($semestres->first()->inicio)->day}};
			var m_inicio = {{\Carbon\Carbon::parse($semestres->first()->inicio)->month}} - 1;
			var y_inicio = {{\Carbon\Carbon::parse($semestres->first()->inicio)->year}};
			var d_fim = {{\Carbon\Carbon::parse($semestres->first()->fim)->day}};
			var m_fim = {{\Carbon\Carbon::parse($semestres->first()->fim)->month}} - 1;
			var y_fim = {{\Carbon\Carbon::parse($semestres->first()->fim)->year}};
		    $( '.datepicker-me').datepicker({
				autoclose: true,
				orientation: "bottom",
				minDate: new Date(y_inicio,m_inicio,d_inicio),
				maxDate: new Date(y_fim,m_fim,d_fim),
				dateFormat: 'dd-mm-yy',
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ajaxStart(function(){ 
            $('#loading').show(); 
            $('#container-ajaxTransition').hide();
        });

        $(document).ajaxStop(function(){ 
            $('#loading').hide(); 
            $('#container-ajaxTransition').show();
        });
		$('#semestre').on('change', function(e){
            var id = e.target.value;
			$.get('/ajax-semestre?id=' + id, function(data){
				$( '.datepicker-me').datepicker("destroy");
				$( '.datepicker-me').datepicker({
					autoclose: true,
					orientation: "bottom",
					minDate: new Date(data.y_inicio, data.m_inicio - 1, data.d_inicio),
					maxDate: new Date(data.y_fim, data.m_fim - 1, data.d_fim),
					dateFormat: 'dd-mm-yy',
				});
			});
		});
	</script>
@endpush

@section('breadcrumb')

<h1>
	Feriados
	<small>Edição</small>
</h1>

{!! Breadcrumbs::render('feriadoId', $feriado) !!}

@endsection

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
			<div class="box box-primary-ufop">
		        <div class="box-header with-border">
		          <h3 class="box-title">Editar Feriado</h3>
		        </div><!-- end box-header with-border -->

		        <form role="form" action="/feriados/{{ $feriado->id }}" method="post"> 
		        	{{ method_field('PATCH') }}
					{{ csrf_field() }}

					<div class="box-body">
						<div class="form-group">
			                <label>Semestre</label>
			                <select class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" name="semestre_id" id="semestre">
			                  @foreach($semestres as $s)
			                  <option value="{{$s->id}}">{{$s->rotulo}}</option>
			                  @endforeach
			                </select>			               
			            </div><!-- end form-group -->
						<div class="col-sm-4 col-sm-offset-4" id="loading" style="display:none">
                            <div class="lds-dual-ring">
                                <div></div>
                            </div>
						</div>
						<div id="container-ajaxTransition">
							<div class="form-group">
								<label>Data:</label>
								<div class="input-group" data-provide="datepicker">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div><!-- end input-group-addon -->
									<input type="text" class="form-control pull-right date datepicker-me" id="data" name="data" value="{{$feriado->data}}">
								</div><!-- end input-group -->
							</div><!-- end form-group -->
						</div>
					</div><!-- end box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-block btn-primary">Salvar</button>
					</div><!-- end box-footer -->
		        </form>
		    </div><!-- end box box-primary-ufop -->
		</div><!-- end col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 -->
	</div><!-- end row -->
@endsection



@extends('planos.edit_layout')

@push('tituloPlano')
	(Horários de Aula)
@endpush

@section('breadcrumb')
<h1>
    Planos
    <small>Horário</small>
</h1>

{!! Breadcrumbs::render('planoHor', $plano) !!}

@endsection

@push('css')
	<!-- Datepicker v1.7.1 -->
	<link href="{{ asset('/jquery-ui-1.12.1.custom-ufop/jquery-ui.css')}}" rel="stylesheet" type="text/css" />
@endpush
     
@push('javascript')
	<!-- Inputmask v3.3.10 -->
  	<script src="{{ asset ('/bower_components/inputmask/dist/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>

	<!-- Tinymce -->
  	<script src="{{ asset ('/bower_components/tinymce/tinymce.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			Inputmask().mask(document.querySelectorAll("input"));
		});
	</script>
	
	<!-- Datepicker v1.7.1 -->
	<script src="{{ asset ('/jquery-ui-1.12.1.custom-ufop/jquery-ui.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			var d_inicio = {{\Carbon\Carbon::parse($semestre->inicio)->day}};
			var m_inicio = {{\Carbon\Carbon::parse($semestre->inicio)->month}} - 1;
			var y_inicio = {{\Carbon\Carbon::parse($semestre->inicio)->year}};
			var d_fim = {{\Carbon\Carbon::parse($semestre->fim)->day}};
			var m_fim = {{\Carbon\Carbon::parse($semestre->fim)->month}} - 1;
			var y_fim = {{\Carbon\Carbon::parse($semestre->fim)->year}};
			var diasNaoLetivos = {!!$diasNaoLetivos!!};
		
		    $( '#exame_data, #planejamento_data ').datepicker({
				autoclose: true,
				orientation: "bottom",
				minDate: new Date(y_inicio,m_inicio,d_inicio),
				maxDate: new Date(y_fim,m_fim,d_fim),
				dateFormat: 'dd-mm-yy',
				beforeShowDay: function(date) {
					var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
					var fimSemana = jQuery.datepicker.noWeekends(date);	
					return fimSemana[0] ? [$.inArray(string, diasNaoLetivos) == -1] : fimSemana[0];
        		}
			});
		});
	</script>
	<script src="{{ asset ('/bower_components/select2/dist/js/select2.min.js')}}" type="text/javascript"></script>
	<script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush

@section('edit-content')
<div class="tab-pane active" id="aula">
	@if(count($plano->horarios)>0)
    <table id="table" class="table table-hover table-striped table-bordered text-center">
        <thead>
            <tr>
                <th width =50%>Dia da Semana</th>
                <th width =50%>Horário</th>
            </tr>
        </thead>
        <tbody>
        	@foreach($plano->horarios as $h)
        	<tr>
				<td>{{$h->dia}}</td>
				<td>{{$h->inicio}} - {{$h->fim}} horas</td>
				<td><a class="btn btn-ufop"  role="button" data-toggle="modal" data-target="#horarioModal{{$h->id}}"><i class="fa fa-pencil"></i></a></td>

				<td>
					<form method="post" action="/horarios/{{ $h->id }}">
						{{ method_field('DELETE') }}
						{{ csrf_field() }}
						<input type="text" name="plano_id" value="{{$plano->id}}" hidden>
						<button class="confirm_delete btn btn-ufop " data-toggle="modal" data-target="#confirm" type="button"><i class="fa fa-trash"></i></buttom>
					</form>
				</td>
			</tr>

			<!-- ********************************************************************************************* -->
			<div class="modal fade" id="horarioModal{{$h->id}}" role="dialog">
			    <div class="modal-dialog">
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Edição - Horário de aula</h4>
			        </div><!-- end modal-header -->
			        <div class="modal-body">
				        <form role="form" action="/horarios/{{ $h->id }}" method="post"> 
							{{ method_field('PATCH') }}
							{{ csrf_field() }}
							<div class="row">
								<div class="col-lg-1 col-sm-auto">
									<input type="text" name="plano_id" value="{{$plano->id}}" hidden>
								</div><!-- end col-lg-1 col-sm-auto -->
								
								<div class="form-group col-lg-4 col-sm-auto">
					                <label>Dia da Semana</label>
					                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="dia">
					                  <option>Segunda-Feira</option>
					                  <option>Terça-Feira</option>
					                  <option>Quarta-Feira</option>
					                  <option>Quinta-Feira</option>
					                  <option>Sexta-Feira</option>
					                </select>
					            </div><!-- end form-group col-lg-4 col-sm-auto -->

								<div class="form-group col-lg-2 col-sm-auto">
									<label for="inicio">Inicio</label>
									<input type="text" class="form-control" data-inputmask="'mask':'99:99'" value="{{ $h->inicio }}" name="inicio" id="inicio" placeholder="Horário de Inicio"/>
								</div><!-- end form-group col-lg-2 col-sm-auto -->

								<div class="form-group col-lg-2 col-sm-auto">
									<label for="fim">Fim</label>
									<input type="text" class="form-control" data-inputmask="'mask':'99:99'" value="{{ $h->fim }}" name="fim" id="fim" placeholder="Horário de Término"/>
								</div><!-- end form-group col-lg-2 col-sm-auto -->

								<div class="form-group col-lg-2 col-sm-auto">
									<label>&nbsp;</label>
									<button type="submit" class="btn btn-ufop btn-md btn-block">Salvar</button>
								</div><!-- end form-group col-lg-2 col-sm-auto -->
							</div><!-- end row -->
					    </form>
			        </div><!-- end modal-body -->
			      </div><!-- end modal-content -->
			    </div><!-- end modal-dialog -->
			</div><!-- end modal fade -->
			<!-- ********************************************************************************************* -->
			@endforeach
        </tbody>
    </table><br>
	@endif
    <form role="form" action="/horarios" method="post"> 
		{{ csrf_field() }}
		<div class="row">
			<div class="col-sm-auto">
				<input type="text" name="plano_id" value="{{$plano->id}}" hidden>
			</div><!-- end col-sm-auto -->
			
			<div class="form-group col-sm-4 col-md-4">
                <label>Dia da Semana</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="dia">
                  <option>Segunda-Feira</option>
                  <option>Terça-Feira</option>
                  <option>Quarta-Feira</option>
                  <option>Quinta-Feira</option>
                  <option>Sexta-Feira</option>
                </select>
            </div><!-- end form-group col-sm-4 col-md-4 -->

			<div class="form-group col-sm-4 col-md-3">
				<label for="inicio">Inicio</label>
				<input type="text" class="form-control" data-inputmask="'mask':'99:99'" name="inicio" id="inicio" placeholder="Horário de Inicio"/>
			</div><!-- end form-group col-sm-4 col-md-3 -->

			<div class="form-group col-sm-4 col-md-3">
				<label for="fim">Fim</label>
				<input type="text" class="form-control" data-inputmask="'mask':'99:99'" name="fim" id="fim" placeholder="Horário de Término"/>
			</div><!-- end form-group col-sm-4 col-md-3 -->

			<div class="form-group col-sm-auto col-md-2">
				<label>&nbsp;</label>
				<button type="submit" class="btn btn-ufop btn-md btn-block">Adicionar</button>
			</div><!-- end form-group col-sm-auto col-md-2 -->
		</div><!-- end row -->
    </form>
</div><!-- end tab-pane active -->
@include('layouts.modalDelete')
@endsection
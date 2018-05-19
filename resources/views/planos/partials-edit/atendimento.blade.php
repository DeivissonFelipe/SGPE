@extends('planos.edit_layout')
     
@section('breadcrumb')
<h1>
    Planos
    <small>Atendimento</small>
</h1>

{!! Breadcrumbs::render('planoAtend', $plano) !!}

@endsection

@push('javascript')
	<!-- Inputmask v3.3.10 -->
  	<script src="{{ asset ('/bower_components/inputmask/dist/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			Inputmask().mask(document.querySelectorAll("input"));
		});
	</script>
@endpush

@section('edit-content')
	<div class="tab-pane" id="atendimento">
		<table id="table" class="table table-hover table-striped table-bordered text-center">
			<thead>
				<tr>
					<th width =33.3%>Dia</th>
					<th width =33.3%>Horário</th>
					<th width =33.3%>Sala</th>
				</tr>
			</thead>
			<tbody>
				@foreach($plano->atendimentos as $a)
				<tr>
					<td>{{$a->dia}}</td>
					<td>{{$a->inicio}} - {{$a->fim}} horas</td>
					<td>{{$a->sala}}</td>
					
					<td><a class="btn btn-ufop"  role="button" data-toggle="modal" data-target="#atendimentoModal{{$a->id}}"><i class="fa fa-pencil"></i></a></td>
					<td>
					<form method="post" action="/atendimentos/{{ $a->id }}">
						{{ method_field('DELETE') }}
						{{ csrf_field() }}
						<input type="text" name="plano_id" value="{{$plano->id}}" hidden>
						<button class="confirm_delete btn btn-ufop " data-toggle="modal" data-target="#confirm" type="button"><i class="fa fa-trash"></i></buttom>
					</form>
					</td>
				</tr>

				<!-- ********************************************************************************************* -->
				<div class="modal fade" id="atendimentoModal{{$a->id}}" role="dialog">
					<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Edição - Horário de atendimento</h4>
						</div><!-- end modal-header -->
						<div class="modal-body">
							<form role="form" action="/atendimentos/{{ $a->id }}" method="post"> 
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
									
									<div class="form-group col-lg-2">
										<label for="inicio">Inicio</label>
										<input type="text" class="form-control" data-inputmask="'mask':'99:99'" name="inicio" id="inicio" value="{{ $a->inicio }}" placeholder="Horário de Inicio"/>
									</div><!-- end form-group col-lg-2 -->

									<div class="form-group col-lg-2">
										<label for="fim">Fim</label>
										<input type="text" class="form-control" data-inputmask="'mask':'99:99'" name="fim" id="fim" value="{{ $a->fim }}" placeholder="Horário de Término"/>
									</div><!-- end form-group col-lg-2 -->

									<div class="form-group col-lg-2">
										<label for="sala">Sala</label>
										<input type="text" class="form-control" name="sala" id="sala" value="{{ $a->sala }}"/>
									</div><!-- end form-group col-lg-2 -->

									<div class="form-group col-lg-2 col-sm-auto">
										<label>&nbsp;</label>
										<button type="submit" class="btn btn-ufop btn-md btn-block">Salvar</button>
									</div><!-- end form-group col-lg-2 col-sm-auto -->
								</div><!-- end row -->
							</form>
						</div><!-- Modal body end -->
					</div><!-- Modal content end-->
					</div><!-- end modal-dialog -->
				</div><!-- end modal fade -->
				<!-- ********************************************************************************************* -->
				@endforeach
			</tbody>
		</table><br>

		<form role="form" action="/atendimentos" method="post"> 
			{{ csrf_field() }}
			<div class="row">
				<div class="col-sm-auto">
					<input type="text" name="plano_id" value="{{$plano->id}}" hidden>
				</div><!-- end col-sm-auto -->
				
				<div class="form-group col-sm-3 col-md-3">
					<label>Dia da Semana</label>
					<select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="dia">
					<option>Segunda-Feira</option>
					<option>Terça-Feira</option>
					<option>Quarta-Feira</option>
					<option>Quinta-Feira</option>
					<option>Sexta-Feira</option>
					</select>
				</div><!-- end col-sm-3 col-md-3 -->
				
				<div class="form-group col-sm-2 col-md-2">
					<label for="inicio">Inicio</label>
					<input type="text" class="form-control" data-inputmask="'mask':'99:99'" name="inicio" id="inicio" placeholder="00:00"/>
				</div><!-- end col-sm-2 col-md-2 -->

				<div class="form-group col-sm-2 col-md-2">
					<label for="fim">Fim</label>
					<input type="text" class="form-control" data-inputmask="'mask':'99:99'" name="fim" id="fim" placeholder="00:00"/>
				</div><!-- end col-sm-2 col-md-2 -->

				<div class="form-group col-sm-2 col-md-3">
					<label for="sala">Sala</label>
					<input type="text" class="form-control" name="sala" id="sala"/>
				</div><!-- end col-sm-2 col-md-3 -->

				<div class="form-group col-sm-3 col-md-2">
					<label>&nbsp;</label>
					<button type="submit" class="btn btn-ufop  btn-block">Adicionar</button>
				</div><!-- end col-sm-3 col-md-2 -->
			</div><!-- end row -->
		</form>
	</div><!-- end tab-pane -->
	@include('layouts.modalDelete')
@endsection
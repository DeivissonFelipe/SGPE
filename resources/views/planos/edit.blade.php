@extends('layouts.adminlte')

@push('tituloAba')
	Planos
@endpush

@push('css')
	<!-- iCheck v1.0.1-->
    <link href="{{ asset('/bower_components/admin-lte/plugins/iCheck/square/blue.css')}}" rel="stylesheet" type="text/css" />

	<!-- Select2 v4.0.5-->
	<!-- <link href="{{ asset('/bower_components/select2/dist/css/select2.css')}}" rel="stylesheet" type="text/css" /> -->
@endpush

@push('javascript')
	<!-- iCheck v1.0.1-->
    <script src="{{ asset ('/bower_components/admin-lte/plugins/iCheck/icheck.min.js')}}"></script>

    <!-- Select2 v4.0.5-->
    <script src="{{ asset ('/bower_components/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{ asset ('/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

	<script>
	  $(function () {
	    $('input').iCheck({
	      checkboxClass: 'icheckbox_square-blue',
	      radioClass: 'iradio_square-blue',
	      increaseArea: '20%' // optional
	    });
	  });
	</script>

	<script type="text/javascript">
		$(".selectMulti").select2().val({{json_encode($turma->users()->allRelatedIds())}}).trigger('change');
		$(".select2").select2();
	</script>
@endpush

@section('breadcrumb')

<h1>
	Planos
	<small>Configuração</small>
</h1>



@endsection

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
			<div class="box box-primary-ufop">
	            <div class="box-header with-border">
	              <h3 class="box-title">Configurar Plano</h3>
	            </div><!-- end box-header with-border -->

	            <form role="form" action="/planos/{{ $plano->id }}" method="post">
								{{ method_field('PATCH') }} 
								{{ csrf_field() }}
								<div class="box-body">
									<div class="form-group">
										<label>Professor</label>
										<select class="form-control select2 selectMulti" style="width: 100%;" tabindex="-1" aria-hidden="true" name="user_id[]" multiple="multiple">
											@foreach($users as $u)
												<option value="{{$u->id}}">{{$u->name}}</option>
											@endforeach
										</select>
									</div><!-- end form-group -->

									<div class="form-group">
			              <label>Disciplina</label>
			              <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="disciplina_id">
			                  @foreach($disciplinas as $d)
			                  	@if($d->id == $turma->disciplina_id)
														<option value="{{$d->id}}" selected>{{$d->nome}}</option>
													@else
														<option value="{{$d->id}}">{{$d->nome}}</option>
													@endif
			                  @endforeach
			              </select>
			            </div><!-- end form-group -->

			            <div class="form-group">
			              <label>Semestre</label>
			              <select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="semestre_id">
			                @foreach($semestres as $s)
			                  @if($s->id == $turma->semestre_id)
													<option value="{{$s->id}}" selected>{{$s->rotulo}}</option>
												@else
													<option value="{{$s->id}}">{{$s->rotulo}}</option>
												@endif
			                @endforeach
			              </select>
			            </div><!-- end form-group -->

			            <div class="form-group">
										<label>Curso</label>
										<select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="curso_id">
											@foreach($cursos as $c)
												@if($c->id == $turma->curso_id)
													<option value="{{$c->id}}" selected>{{$c->nome}}</option>
												@else
													<option value="{{$c->id}}">{{$c->nome}}</option>
												@endif
											@endforeach
										</select>
			            </div><!-- end form-group -->

			            <div class="form-group">
											<label><input type="checkbox" name="tipo_turma" {{ ($turma->tipo_turma == '1') ? ' checked' : '' }}> Turma Extra</label>
			            </div><!-- end form-group -->

									<hr>
									<div class="form-group">
											<label>Dias Lecionados</label><br><br>
											<label><input type="checkbox" name="horario[]" {{ in_array(1, $h_array) ? ' checked' : '' }} value="1"> Segunda-Feira</label><br>
											<label><input type="checkbox" name="horario[]" {{ in_array(2, $h_array) ? ' checked' : '' }} value="2"> Terça-Feira</label><br>
											<label><input type="checkbox" name="horario[]" {{ in_array(3, $h_array) ? ' checked' : '' }} value="3"> Quarta-Feira</label><br>
											<label><input type="checkbox" name="horario[]" {{ in_array(4, $h_array) ? ' checked' : '' }} value="4"> Quinta-Feira</label><br>
											<label><input type="checkbox" name="horario[]" {{ in_array(5, $h_array) ? ' checked' : '' }} value="5"> Sexta-Feira</label><br>
											<label><input type="checkbox" name="horario[]" {{ in_array(6, $h_array) ? ' checked' : '' }} value="6"> Sábado</label><br>
									</div><!-- end form-group -->
								</div><!-- end box-body -->

								<div class="box-footer">
									<button type="submit" class="btn btn-block btn-primary">Salvar</button>
								</div><!-- end box-footer -->
	            </form>
	        </div><!-- end box box-primary-ufop -->
		</div><!-- end col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 -->
	</div><!-- end row -->
@endsection	
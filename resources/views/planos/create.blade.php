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
	      increaseArea: '20%'
	    });
	  });
	</script>

	<script type="text/javascript">
		$(".select2").select2();
	</script>
@endpush

@section('breadcrumb')

<h1>
	Plano
	<small>Criar</small>
</h1>

{!! Breadcrumbs::render('nplano') !!}

@endsection

@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
		<div class="box box-primary-ufop">

			<div class="box-header with-border">
				<h3 class="box-title">Criar novo Plano</h3>
			</div><!-- end box-header with-border -->

			<form role="form" action="/planos" method="post"> 
			
				{{ csrf_field() }}
				<div class="box-body">
					<div class="form-group">
							<label>Professor</label>
							<select class="form-control  select2 selectMulti" style="width: 100%;" tabindex="-1" aria-hidden="true" name="user_id[]" multiple="multiple">
								@foreach($users as $u)
									@if($u->id == auth::user()->id)
										<option value="{{$u->id}}" selected>{{$u->name}}</option>
									@else
										<option value="{{$u->id}}">{{$u->name}}</option>
									@endif
								@endforeach
							</select>
					</div><!-- end form-group -->

					<div class="form-group">
						<label>Disciplina</label>
						<select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="disciplina_id">
							@foreach($disciplinas as $d)
							<option value="{{$d->id}}" {{ old('disciplina_id') == $d->id ? 'selected' : '' }}>{{$d->nome}}</option>
							@endforeach
						</select>
					</div><!-- end form-group -->

					<div class="form-group">
						<label>Semestre</label>
						<select class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" name="semestre_id">
							@foreach($semestres as $s)
							<option value="{{$s->id}}" {{ old('semestre_id') == $s->id ? 'selected' : '' }}>{{$s->rotulo}}</option>
							@endforeach
						</select>
					</div><!-- end form-group -->

					<div class="form-group">
						<label>Curso</label>
						<select class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" name="curso_id">
							@foreach($cursos as $c)
							<option value="{{$c->id}}" {{ old('curso_id') == $c->id ? 'selected' : '' }}>{{$c->nome}}</option>
							@endforeach
						</select>
					</div><!-- end form-group -->

					<div class="form-group">
							<label><input type="checkbox" name="tipo_turma" {{ old('tipo_turma') ? 'checked' : '' }} value="1"> Turma Extra</label>
					</div><!-- end form-group -->

					<hr>
					<div class="form-group">
						<label>Dias Lecionados</label><br><br>
						<label><input type="checkbox" name="horario[]" {{ (is_array(old('horario')) and in_array(1, old('horario'))) ? ' checked' : '' }} value="1"> Segunda-Feira</label><br>
						<label><input type="checkbox" name="horario[]" {{ (is_array(old('horario')) and in_array(2, old('horario'))) ? ' checked' : '' }} value="2"> Terça-Feira</label><br>
						<label><input type="checkbox" name="horario[]" {{ (is_array(old('horario')) and in_array(3, old('horario'))) ? ' checked' : '' }} value="3"> Quarta-Feira</label><br>
						<label><input type="checkbox" name="horario[]" {{ (is_array(old('horario')) and in_array(4, old('horario'))) ? ' checked' : '' }} value="4"> Quinta-Feira</label><br>
						<label><input type="checkbox" name="horario[]" {{ (is_array(old('horario')) and in_array(5, old('horario'))) ? ' checked' : '' }} value="5"> Sexta-Feira</label><br>
						<label><input type="checkbox" name="horario[]" {{ (is_array(old('horario')) and in_array(6, old('horario'))) ? ' checked' : '' }} value="6"> Sábado</label><br>
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
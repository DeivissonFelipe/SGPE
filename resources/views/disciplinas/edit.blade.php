@extends('layouts.adminlte')

@push('tituloAba')
	Disciplinas
@endpush

@section('breadcrumb')

<h1>
	Disciplinas
	<small>Edição</small>
</h1>

{!! Breadcrumbs::render('disciplinaId', $disciplina) !!}

@endsection

@push('css')
	<!-- iCheck v1.0.1-->
    <link href="{{ asset('/bower_components/admin-lte/plugins/iCheck/square/blue.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('javascript')
	<!-- iCheck v1.0.1-->
    <script src="{{ asset ('/bower_components/admin-lte/plugins/iCheck/icheck.min.js')}}"></script>

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
		var checks = document.getElementsByName("oferta[]");
		var array = {!! json_encode($disciplina->cursos()->allRelatedIds()) !!};
		var arrayLength = array.length;
		var aux;
		for(var i = 0; i < arrayLength; i++){
			aux = array[i];
			checks[aux-1].checked = 'true';
		}
	</script>
@endpush

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
			<div class="box box-primary-ufop">
	            <div class="box-header with-border">
	              <h3 class="box-title">Editar Disciplina</h3>
	            </div><!-- end box-header with-border -->

	            <form role="form" action="/disciplinas/{{ $disciplina->id }}" method="post"> 
	            	{{ method_field('PATCH') }}
					{{ csrf_field() }}

	              	<div class="box-body">
						<div class="form-group">
							<label for="codigo">Código</label>
							<input type="text" class="form-control" name="codigo" id="codigo" placeholder="Código da disciplina" value="{{$disciplina->codigo}}" />
						</div><!-- end form-group -->

						<div class="form-group">
							<label for="nome">Nome</label>
							<input type="text" class="form-control" name="nome" id="nome" placeholder="Nome da disciplina" value="{{$disciplina->nome}}" />
						</div><!-- end form-group -->

						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" name="name" id="name" placeholder="Nome da disciplina em Inglês" value="{{$disciplina->name}}"/>
						</div><!-- end form-group -->
						
						<div class="form-group col-sm-4">
							<label for="name">CHS</label>
							<input type="number" class="form-control" name="chsemestral" id="chsemestral" placeholder="Horas" data-toggle="tooltip" title="Carga Horária Semestral"/>
						</div><!-- end form-group -->

						<div class="form-group col-sm-4">
							<label for="name">CH semanal teórica</label>
							<input type="number" class="form-control" name="chsemanalp" id="chsemanalp" placeholder="Horas/Aula" data-toggle="tooltip" title="Carga Horária Semanal Teórica"/>
						</div><!-- end form-group -->

						<div class="form-group col-sm-4">
							<label for="name">CH semanal prática</label>
							<input type="number" class="form-control" name="chsemanalt" id="chsemanalt" placeholder="Horas/Aula"  data-toggle="tooltip" title="Carga Horária Semanal Prática"/>
						</div><!-- end form-group -->

						<div class="form-group">
							<label for="departamento_id">Departamento</label>
							<select name="departamento_id" class="form-control">
								@foreach($departamentos as $d)
									@if($d->id == $disciplina->departamento_id)
										<option value="{{$d->id}}" selected>{{$d->sigla}}</option>
									@else
										<option value="{{$d->id}}">{{$d->sigla}}</option>
									@endif
								@endforeach
							</select>
						</div><!-- end form-group -->

						<hr>
						<div class="form-group">
							<label style="margin-bottom: 15px;">Selecione os cursos para os quais a disciplina será ofertada</label>
							<br>
							<label><input id="check01" type="checkbox" name="oferta[]" value="1"> Engenharia de Produção</label><br>
							<label><input id="check02" type="checkbox" name="oferta[]" value="2"> Sistemas de Informação</label><br>
							<label><input id="check03" type="checkbox" name="oferta[]" value="3"> Engenharia de Computação</label><br>
							<label><input id="check04" type="checkbox" name="oferta[]" value="4"> Engenharia Elétrica</label><br>
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
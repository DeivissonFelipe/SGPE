@extends('layouts.adminlte')

@push('tituloAba')
	Cursos
@endpush

@section('breadcrumb')

<h1>
	Cursos
	<small>Edição</small>
</h1>

{!! Breadcrumbs::render('cursoId', $curso) !!}

@endsection


@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
			<div class="box box-primary-ufop">
	            <div class="box-header with-border">
	              <h3 class="box-title">Editar Curso</h3>
	            </div><!-- end box-header with-border -->

	            <form role="form" action="/cursos/{{ $curso->id }}" method="post"> 
	            	{{ method_field('PATCH') }}
					{{ csrf_field() }}
	              	<div class="box-body">
						<div class="form-group">
							<label for="nome">Nome</label>
							<input type="text" class="form-control" name="nome" id="nome" value="{{ $curso->nome }}" />
						</div><!-- end form-group -->
						<div class="form-group">
							<label for="sigla">Sigla</label>
							<input type="text" class="form-control" name="sigla" id="sigla" value="{{ $curso->sigla }}" />
						</div><!-- end form-group -->	
					</div><!-- end box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-block btn-primary">Salvar</button>
					</div><!-- end box-footer -->
	            </form>
	        </div><!-- end box box-primary-ufop -->
		</div><!-- end col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 -->
		</div><!-- end row -->
@endsection
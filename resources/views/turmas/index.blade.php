@extends('layouts.adminlte')

@push('tituloAba')
	Turmas
@endpush

@section('breadcrumb')

<h1>
	Turmas
	<small>Index</small>
</h1>

{!! Breadcrumbs::render('turma') !!}

@endsection

@push('javascript')
<script>
	$(function () {
		$('[data-tt="tooltip"]').tooltip()
	});
</script>
@endpush

@section('content')
	<div class='row'>
        <div class='col-xs-12 col-sm-12 col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Turmas Cadastrados</h3>
                    <div class="pull-right">
                    	<a class="btn btn-ufop" href="/turmas/create"><i class="fa fa-plus-square"></i> Novo</a>
                    </div><!-- end pull-right -->
                </div>
                <div class="box-body">
					<div class="table-responsive">
						<table id="table" class="table table-hover table-striped table-bordered text-center">
							<thead>
								<tr>
									<th>Disciplina</th>
									<th>Professor</th>
									<th>Curso</th>
									<th>Semestre</th>
									<th>Turma</th>
								</tr>
							</thead>
							<tbody>
								@foreach($turmas as $t)
								<tr>
									<td>{{ $t->disciplina->nome}}</td>
									<td>
									@foreach($t->users as $usuario)
										{{ $usuario->name}} <br>
									@endforeach
									</td>
									<td>{{ $t->curso->nome}}</td>
									<td>{{ $t->semestre->rotulo}}</td>
									<td>
										@if($t->tipo_turma == '0')
											Padrão
										@else
											Extra
										@endif
									</td>

									@can('owner', $t)
										<td><a href="/turmas/{{$t->id}}/edit" class="btn btn-ufop" data-tt="tooltip" title="Editar"><i class="fa fa-edit"></i></a></td>
										<td>
											<form method="post" action="/turmas/{{$t->id}}">
												{{ method_field('DELETE') }}
												{{ csrf_field() }}
												<button class="confirm_delete btn btn-ufop " data-toggle="modal" data-target="#confirm" type="button" data-tt="tooltip" title="Excluir"><i class="fa fa-trash"></i></buttom>
											</form>
										</td>

									@endcan
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
                </div><!-- end box-body -->
            </div><!-- end box box-primary-ufop -->
			{{ $turmas->links() }}
        </div><!-- end col-xs-12 col-sm-12 col-md-8 col-md-offset-2 -->
		@include('layouts.modalDelete')
    </div><!-- end row -->
@endsection
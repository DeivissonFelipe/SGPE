@extends('layouts.adminlte')

@push('tituloAba')
   Semestres
@endpush

@section('breadcrumb')

<h1>
	Semestre
	<small>Index</small>
</h1>

{!! Breadcrumbs::render('semestre') !!}

@endsection

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Semestres Cadastrados</h3>
					<div class="pull-right">
                    	<a class="btn btn-ufop" href="/semestres/create"><i class="fa fa-plus-square"></i> Novo</a>
                    </div><!-- end pull-right -->
                </div><!-- end box-header -->
                <div class="box-body">
                    <table id="table" class="table table-hover table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Semestre</th>
                                <th>Inicio</th>
                                <th>Fim</th>
                            </tr>
                        </thead>
                        <tbody>
							@foreach($semestres as $s)
							<tr>
								<td>{{ $s->rotulo}}</td>
								<td>{{ $s->inicio}}</td>
								<td>{{ $s->fim}}</td>
								<td><a class="btn btn-ufop" href="/semestres/{{$s->id}}/edit"><i class="fa fa-pencil"></i> Editar</a></td>
								<td>
                                    <form method="post" action="/semestres/{{ $s->id }}">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button class="confirm_delete btn btn-ufop " data-toggle="modal" data-target="#confirm" type="button"><i class="fa fa-trash"></i> Apagar</buttom>
                                    </form>
								</td>
							</tr>
							@endforeach
                        </tbody>
                    </table>
                </div><!-- end box-body -->
            </div><!-- end box box-primary-ufop -->
            {{ $semestres->links() }}
        </div><!-- end col-md-8 col-md-offset-2 -->
        @include('layouts.modalDelete')
    </div><!-- end row -->
@endsection
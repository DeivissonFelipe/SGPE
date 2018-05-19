@extends('layouts.adminlte')

@push('tituloAba')
    Departamentos
@endpush

@section('breadcrumb')

<h1>
	Departamentos
	<small>Index</small>
</h1>

{!! Breadcrumbs::render('departamento') !!}

@endsection

@section('content')
    <div class='row'>
        <div class='col-xs-12 col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Departamentos Cadastrados</h3>
					<div class="pull-right">
                    	<a class="btn btn-ufop" href="/departamentos/create"><i class="fa fa-plus-square"></i> Novo</a>
                    </div><!-- end pull-right -->
                </div><!-- end box-header -->
                <div class="box-body">
                    <table id="table" class="table table-hover table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Sigla</th>
                            </tr>
                        </thead>
                        <tbody>
							@foreach($departamentos as $d)
							<tr>
								<td>{{ $d->nome}}</td>
								<td>{{ $d->sigla}}</td>
								<td><a class="btn btn-ufop" href="/departamentos/{{$d->id}}/edit"><i class="fa fa-pencil"></i> Editar</a></td>
								<td>
                                    <form method="post" action="/departamentos/{{ $d->id }}">
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
        </div><!-- end col-xs-12 col-md-8 col-md-offset-2 -->
        @include('layouts.modalDelete')
    </div><!-- end row -->
@endsection
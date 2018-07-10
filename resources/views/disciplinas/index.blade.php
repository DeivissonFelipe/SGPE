@extends('layouts.adminlte')

@push('tituloAba')
    Disciplinas
@endpush

@section('breadcrumb')

<h1>
	Disciplinas
	<small>Index</small>
</h1>

{!! Breadcrumbs::render('disciplina') !!}

@endsection

@section('content')
    <div class='row'>
        <div class='col-xs-12 col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Disciplinas Cadastradas</h3>
                    <div class="pull-right">
                    	<a class="btn btn-ufop" href="/disciplinas/create"><i class="fa fa-plus-square"></i> Novo</a>
                    </div><!-- end pull-right -->
                </div><!-- end box-header -->
                <div class="box-body">
                <div class="table-responsive">
                    <table id="table" class="table table-hover table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Departamento</th>
                            </tr>
                        </thead>
                        <tbody>
							@foreach($disciplinas as $d)
							<tr>
								<td>{{ $d->codigo}}</td>
								<td>{{ $d->nome}}</td>
								<td>{{ $d->Departamento->sigla}}</td>
                                <td><a class="btn btn-ufop" href="/disciplinas/{{$d->id}}/info"><i class="fa fa-plus"></i> info</a></td>
								<td><a class="btn btn-ufop" href="/disciplinas/{{$d->id}}/edit"><i class="fa fa-pencil"></i> Editar</a></td>
								<td>
                                    <form method="post" action="/disciplinas/{{ $d->id }}">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button class="confirm_delete btn btn-ufop " data-toggle="modal" data-target="#confirm" type="button"><i class="fa fa-trash"></i> Apagar</buttom>
                                    </form>
								</td>
                                @if(empty($d->ementa)  || empty($d->conteudo) || empty($d->bibliografiab) || empty($d->bibliografiac))
                                    <td class="warning"><a href="/disciplinas/{{$d->id}}/info">Incompleto</a></td>
                                @endif
							</tr>
							@endforeach
                        </tbody>
                    </table>
                </div> <!-- end table-responsive -->
                </div><!-- end box-body -->
            </div><!-- end box box-primary-ufop -->
            {{ $disciplinas->links() }}
        </div><!-- end col-xs-12 col-md-8 col-md-offset-2 -->
        @include('layouts.modalDelete')
    </div><!-- end row -->
@endsection
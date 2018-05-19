@extends('layouts.adminlte')

@push('tituloAba')
    Cursos
@endpush

@section('breadcrumb')

<h1>
	Cursos
	<small>Index</small>
</h1>

{!! Breadcrumbs::render('curso') !!}

@endsection


@section('content')
    <div class='row'>
        <div class='col-xs-12 col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Cursos Cadastrados</h3>
                    <div class="pull-right">
                    	<a class="btn btn-ufop" href="/cursos/create"><i class="fa fa-plus-square"></i> Novo</a>
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
							@foreach($cursos as $c)
							<tr>
								<td>{{ $c->nome}}</td>
								<td>{{ $c->sigla}}</td>
								<td><a class="btn btn-ufop" href="/cursos/{{$c->id}}/edit"><i class="fa fa-pencil"></i> Editar</a></td>
								<td>
                                    <form method="post" action="/cursos/{{ $c->id }}">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}    
                                        <button class="confirm_delete btn btn-ufop" data-toggle="modal" data-target="#confirm" type="button"><i class="fa fa-trash"></i> Apagar</buttom>
                                    </form>
                                </td>
							</tr>
							@endforeach
                        </tbody>
                    </table>
                </div><!-- end box-body -->
            </div><!-- end box box-primary-ufop -->
            {{ $cursos->links() }}
        </div><!-- end col-xs-12 col-md-8 col-md-offset-2 -->
    </div><!-- end row -->
    @include('layouts.modalDelete')
@endsection 




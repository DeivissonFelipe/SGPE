@extends('layouts.adminlte')

@push('tituloAba')
    Trocas
@endpush

@section('breadcrumb')

<h1>
	Substituições
	<small>Index</small>
</h1>

{!! Breadcrumbs::render('substituicao') !!}

@endsection

@section('content')
    <div class='row'>
        <div class='col-xs-12 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Substituições Cadastrados</h3>
                    <div class="pull-right">
                    	<a class="btn btn-ufop" href="/trocas/create"><i class="fa fa-plus-square"></i> Novo</a>
                    </div><!-- end pull-right -->
                </div><!-- end box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-hover table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Dia</th>
                                    <th>Substituição por</th>
                                    <th>Semestre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trocas as $t)
                                <tr>
                                    <td>{{ $t->dia}}</td>
                                    <td>{{ $t->substituicao}}</td>
                                    <td>{{ $t->semestre->rotulo}}</td>
                                    <td><a href="/trocas/{{$t->id}}/edit" class="btn  btn-ufop"><i class="fa fa-edit"></i> Editar</a></td>
                                    <td>
                                        <form method="post" action="/trocas/{{ $t->id }}">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="confirm_delete btn btn-ufop " data-toggle="modal" data-target="#confirm" type="button"><i class="fa fa-trash"></i> Apagar</buttom>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- end box-body -->
            </div><!-- end box box-primary-ufop -->
            {{ $trocas->links() }}
        </div><!-- end col-xs-12 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2 -->
        @include('layouts.modalDelete')
    </div><!-- end row -->
@endsection
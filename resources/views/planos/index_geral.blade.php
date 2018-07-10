@extends('layouts.adminlte')

@push('tituloAba')
    Planos
@endpush

@section('breadcrumb')

<h1>
    Planos
    <small>Geral</small>
</h1>

{!! Breadcrumbs::render('geral') !!}

@endsection

@section('content')
	<div class='row'>
        <div class='col-md-10 col-md-offset-1'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Planos Cadastrados</h3>
                </div><!-- end box-header -->
                <div class="box-body">
                 
                    <form class="navbar-form navbar-left" role="search" method="get" action="/search_geral">
                        <div class="form-group">    
                            <input type="text" class="form-control" id="navbar-search-input" name="busca">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                        </div>
                    </form><br><br>
                    
                    @if (count($planos) === 0)
                        <div class="error-page">
                            <h2 class="headline text-yellow"> Ops!!</h2>
                            <div class="error-content">
                                <h3><i class="fa fa-warning text-yellow"></i> Nenhum Registro Encontrado!</h3>
                            </div>
                        </div>
                    @else
                        <table id="table" class="table table-hover table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Professor</th>
                                    <th>Curso</th>
                                    <th>Turma</th>
                                    <th>Semestre</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($planos as $p)
                                <tr>
                                    <td><a href="/view/{{$p->id}}">{{$p->turma->disciplina->nome}}</a></td>
                                    <td>
                                    @foreach($p->turma->users as $usuario)
                                        {{ $usuario->name}} <br>
                                    @endforeach
                                    </td>
                                    <td>{{$p->turma->curso->nome}}</td>
                                    <td>{{$p->turma->numero_turma}}</td>
                                    <td>{{$p->turma->semestre->rotulo}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div><!-- end box-body -->
            </div><!-- end box box-primary-ufop -->
            {{ $planos->links() }}
        </div><!-- end col-md-8 col-md-offset-2 -->
    </div><!-- end row -->
@endsection
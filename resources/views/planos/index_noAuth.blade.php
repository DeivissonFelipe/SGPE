@extends('layouts.adminlte_noAuth')

@push('tituloAba')
    Pesquisa
@endpush

@section('breadcrumb')

<h1>
    Pesquisa
    <small>Index</small>
</h1>

{!! Breadcrumbs::render('search') !!}

@endsection

@section('content')
	<div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Planos Cadastrados</h3>
                </div><!-- end box-header -->
                <div class="box-body">
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
                                    <th>Curso</th>
                                    <th>Turma</th>
                                    <th>Semestre</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($planos as $p)
                                <tr>
                                    <td><a href="/view/{{$p->id}}">{{$p->turma->disciplina->nome}}</a></td>
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
            {{$planos->links()}}
        </div>        
    </div><!-- end row -->
@endsection
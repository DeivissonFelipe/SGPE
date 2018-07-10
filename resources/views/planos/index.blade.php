@extends('layouts.adminlte')

@push('tituloAba')
    Planos
@endpush

@section('breadcrumb')

<h1>
    Planos
    <small>Index</small>
</h1>

{!! Breadcrumbs::render('plano') !!}

@endsection

@section('content')
	<div class='row'>
        <div class='col-md-10 col-md-offset-1'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Meus Planos</h3>
                </div><!-- end box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-hover table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Curso</th>
                                    <th>Turma</th>
                                    <th>Semestre</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($planos as $p)
                                <tr>
                                    <td><a href="/planos/{{$p->id}}">{{$p->turma->disciplina->nome}}</a></td>
                                    <td>{{$p->turma->curso->nome}}</td>
                                    <td>{{$p->turma->numero_turma}}</td>
                                    <td>{{$p->turma->semestre->rotulo}}</td>
                                    @if($p->status == 'Aprovado')
                                        <td class="success">{{$p->status}}</td>
                                    @elseif($p->status == 'Em Análise')
                                        <td class="warning">{{$p->status}}</td>
                                    @elseif($p->pendencias()->count() > 0)
                                        <td class="danger">{{$p->status}}</td>
                                    @else
                                        <td>{{$p->status}}</td>
                                    @endif
                                    
                                    @can('update', $p)
										<td><a href="/planos/{{$p->id}}/edit" class="btn btn-ufop" data-tt="tooltip" title="Configuração"><i class="fa fa-wrench"></i></a></td>
										<td>
											<form method="post" action="/planos/{{$p->id}}">
												{{ method_field('DELETE') }}
												{{ csrf_field() }}
												<button class="confirm_delete btn btn-ufop " data-toggle="modal" data-target="#confirm" type="button" data-tt="tooltip" title="Excluir"><i class="fa fa-trash"></i></buttom>
											</form>
										</td>
									@endcan

                                    @if($p->pendencias()->count() > 0)
                                    <td>
                                        <a class="btn btn-warning" href="/planos/{{$p->id}}/view_pend" data-tt="tooltip" title="Pendências"><i class="fa fa-exclamation" aria-hidden="true"></i> {{$p->pendencias()->count()}}</a>
                                        
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if(!isset($planos) || $planos->count() <= 0)
                        <div class="well" id="planos_vazio">
                            Nenhum registro encontrado!
                        </div>
                        @endif
                    </div>
                </div><!-- end box-body -->
            </div><!-- end box box-primary-ufop -->
            {{ $planos->links() }}
        </div><!-- end col-md-8 col-md-offset-2 -->
        @include('layouts.modalDelete')
    </div><!-- end row -->
@endsection
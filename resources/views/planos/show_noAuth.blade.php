@extends('layouts.adminlte_noAuth')

@push('tituloAba')
    {{$plano->turma->disciplina->codigo}}
@endpush

@section('breadcrumb')

<h1>
    Pesquisa
    <small>Plano</small>
</h1>

{!! Breadcrumbs::render('search_plano', $plano) !!}

@endsection


@push('css')
    <link href="{{ asset('/css/plano.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="row">

    <!-- CORPO -->
    <div class='col-md-8 col-md-offset-2'>
        <div class="box box-primary-ufop">
            <div class="box-header">
                <div class="table-responsive">
                    <table id="ctitle">
                        <tr>
                            <td class="text-center" id="rep" width="20%">
                                <img src="{{URL::asset('/img/Republica-logo.jpeg')}}" alt="logo republica federativa do brasil">
                            </td>
                            <td class="text-center" id="text" width="60%" colspan="2">
                                <h4>UNIVERSIDADE FEDERAL DE OURO PRETO <br>PRÓ-REITORIA DE GRADUAÇÃO<br>PLANO DE ENSINO</h4>
                            </td>
                            <td class="text-center" id="ufop" width="20">
                                <img src="{{URL::asset('/img/Logomarca-min.jpg')}}" alt="logo ufop">
                                
                            </td>
                        </tr>            
                    </table>
                </div>
            </div><!-- end box-header -->
            
            <div class="box-body">
                <div class="table-responsive text-center">
                    <table>
                        <tr>
                            <td colspan="3" width =75% >
                                <div class="pull-left">Nome do Componente Curricular em português:</div><br>
                                <strong>{{$plano->turma->disciplina->nome}}</strong>
                                <br><br>
                                <div class="pull-left">Nome do Componente Curricular em inglês:</div><br>
                                {{$plano->turma->disciplina->name}}
                            </td>
                            <td colspan="3" class="pull-top">
                                <div class="pull-left">
                                    Código: {{$plano->turma->disciplina->codigo}}
                                </div> 
                            </td>
                        </tr>

                        <tr>
                            <td  colspan="3" class="nob_border">
                                <div class="pull-left">Nome e sigla do departamento:</div><br>
                                <div class="pull-left">{{$plano->turma->disciplina->departamento->nome}} - {{$plano->turma->disciplina->departamento->sigla}}</div>
                            </td>
                            <td colspan="3" class="nob_border">
                                <div class="pull-left">Unidade acadêmica: </div><br>
                                <div class="pull-left">ICEA</div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive text-center">
                    <table>
                        <tr>
                            <td colspan="5">
                                <div class="pull-left">Nome do docente:</div><br>
                                <div class="pull-left">
                                    @php ($cont=0)
                                    @foreach($plano->turma->users as $usuario)
                                        @if($cont>=1)
                                            - {{ $usuario->name}}
                                        @else
                                            {{ $usuario->name}}
                                        @endif
                                        @php ($cont++)
                                    @endforeach
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="nob_border">
                                Carga horária semestral<br>
                                {{$plano->turma->disciplina->chsemestral}} horas
                            </td>
                            <td colspan="2" class="nob_border">
                                Carga horária semanal teórica<br>
                                {{$plano->turma->disciplina->chsemanalt}} horas/aula
                            </td>
                            <td colspan="2" class="nob_border">
                                Carga horária semanal prática<br>
                                {{$plano->turma->disciplina->chsemanalp}} horas/aula
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <td>
                                <div class="pull-left">Data de aprovação na assembléia departamental: {!!$plano->aprovacao!!}</div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="pull-left">Ementa: </div><br>
                                {!!$plano->turma->disciplina->ementa!!}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="pull-left">Conteúdo programático: </div><br>
                                {!!$plano->turma->disciplina->conteudo!!}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="pull-left">Objetivos: </div><br>
                                {!!$plano->objetivo!!}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="pull-left">Metodologia: </div><br>
                                {!!$plano->metodologia!!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="pull-left">Atividades avaliativas: </div><br>
                                {!!$plano->avaliacao!!}
                            </td>
                        </tr>
                    </table>
                </div><br>
                <div class="cronograma">
                    <div class="pull-left">
                        Cronograma:
                    </div><br>
                    <h4 class="margembZero">Critérios de Avaliação</h4>
                    <div class="table-responsive">
                        <table class="margemtZero margembZero text-center" id="table">
                            <thead>
                                <tr>
                                    <th>Descrição da avaliação</th>
                                    <th>Peso da avaliação (%)</th>
                                    <th width="20%">Data</th>
                                    <th width="60%">Conteúdo avaliado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plano->exames as $e)
                                <tr>
                                    <td>{{$e->descricao}}</td>
                                    <td>{{$e->peso}}</td>
                                    <td>{{$e->data}}</td>
                                    <td>{{$e->conteudo}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="margemtZero text-center">
                            @if(count($plano->observacoes))
                                <tr>
                                    <td colspan="5">
                                        <div class="pull-left">{!!$plano->observacoes!!}</div>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div><br>
                          
                    @if($plano->tipo == 1)

                    <h4>Planejamento das Aulas (sujeito a mudanças no decorrer do semestre)</h4>
                    <div class="table-responsive">
                        <table class="text-center">
                            <thead>
                                <tr>
                                    <th>Aula</th>
                                    <th>Prática/<br>Teórica</th>
                                    <th width="20%">Data</th>
                                    <th width="60%">Conteúdo Previsto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plano->planejamentoAulas as $p)
                                <tr>
                                    <td>{{$p->aula}}</td>
                                    <td>{{$p->tipo}}</td>
                                    <td>{{$p->data}}</td>
                                    <td>{{$p->conteudo}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p class="margemtZero pull-left"><strong><u>Atenção:</u></strong> No planejamento acima, cada "aula" corresponde a duas aulas de 50 minutos ou 1h 40 minutos.</p>
                    </div>
                                        
                    @else
                        <h4>Planejamento das Aulas (sujeito a mudanças no decorrer do semestre)</h4>
                        <div class="table-responsive">
                            <table class="text-center">
                                <thead>
                                    <tr>
                                        <th>Unidade</th>
                                        <th>Hora/Aula</th>
                                        <th>Descrição</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($plano->planejamentoUnidades as $p)
                                    <tr>
                                        <td>{{$p->unidade}}</td>
                                        <td>{{$p->hora_aula}}</td>
                                        <td>{{$p->descricao}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div><br>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <td colspan="5">
                                <div class="pull-left">Bibliografia Básica:</div><br><br>
                                <div class="pull-left">{!!$plano->turma->disciplina->bibliografiab!!}</div>
                                
                            </td>
                        </tr>

                        <tr>
                            <td colspan="5">
                                <div class="pull-left">Bibliografia Complementar:</div><br><br>
                                <div class="pull-left">{!!$plano->turma->disciplina->bibliografiac!!}</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div><!-- end box box-primary-ufop -->
    </div><!-- end col-sm-12 col-md-8 -->

</div><!-- end row -->    
@endsection

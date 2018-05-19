<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Document</title>
    <link href="{{ asset('/css/plano.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/css/plano.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .container{
            border: 3px solid black;
        }
    </style>
</head>
<body>
    
    <table id="ctitle">
        <tr>
            <td id="rep" width="20%">
                <img src="img/Republica-logo.jpeg" alt="logo republica federativa do brasil">
            </td>
            <td id="text" width="60%" colspan="2">
                <h4>UNIVERSIDADE FEDERAL DE OURO PRETO <br>PRÓ-REITORIA DE GRADUAÇÃO<br>PLANO DE ENSINO</h4>
            </td>
            <td id="ufop" width="20">
                <img src="img/Logomarca-min.jpg" alt="logo ufop">
            </td>
        </tr>            
    </table>
    
    <div class="container">
        <table>
            <tr>
                <td colspan="3" width =75% >
                    <div class="pull-left">Nome do Componente Curricular em português:</div>
                    <strong>{{$plano->turma->disciplina->nome}}</strong>
                    <br><br>
                    <div class="pull-left">Nome do Componente Curricular em inglês:</div>
                    {{$plano->turma->disciplina->name}}
                </td>
                <td colspan="3" class="pull-top">
                    <div class="pull-left">
                        Código: {{$plano->turma->disciplina->codigo}}
                    </div> 
                </td>
            </tr>

            <tr>
                <td  colspan="3">
                    <div class="pull-left">Nome e sigla do departamento:</div>
                    <div class="pull-left">{{$plano->turma->disciplina->departamento->nome}}-{{$plano->turma->disciplina->departamento->sigla}}</div>
                </td>
                <td colspan="3">
                    <div class="pull-left">Unidade acadêmica: </div>
                    <div class="pull-left">ICEA</div>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td colspan="5">
                    <div class="pull-left">Nome do docente</div>
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
                <td colspan="2" >
                    <div class="pull-left">Carga horária semestral</div>
                    {{$plano->turma->disciplina->chsemestral}} horas
                </td>
                <td colspan="2" >
                    <div class="pull-left">Carga horária semanal teórica</div>
                    {{$plano->turma->disciplina->chsemanalt}} horas/aula
                </td>
                <td colspan="2" >
                    <div class="pull-left">Carga horária semanal prática</div>
                    {{$plano->turma->disciplina->chsemanalp}} horas/aula
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td colspan="5">
                    <div class="pull-left">Data de aprovação na assembléia departamental: {!!$plano->aprovacao!!}</div>
                </td>
            </tr>

            <tr>
                <td colspan="5">
                    <div class="pull-left">Ementa: {!!$plano->ementa!!}</div>
                </td>
            </tr>

            <tr>
                <td colspan="5">
                    <div class="pull-left">Conteúdo programático: {!!$plano->conteudo!!}</div>
                </td>
            </tr>

            <tr>
                <td colspan="5">
                    <div class="pull-left">Objetivos: {!!$plano->objetivo!!}</div>
                </td>
            </tr>

            <tr>
                <td colspan="5">
                    <div class="pull-left">Metodologia: {!!$plano->metodologia!!}</div>
                </td>
            </tr>
        </table>
        
        <div class="cronograma">
            <div class="pull-left">
                Cronograma:
            </div>
            <h4 class="margembZero">Critérios de Avaliação</h4>
            <table class="margemtZero margembZero" id="table">
                <thead>
                    <tr>
                        <th>Descrição da avaliação</th>
                        <th>Peso da avaliação (%)</th>
                        <th>Data</th>
                        <th>Conteúdo avaliado</th>
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
            <table class="margemtZero">
                @if(count($plano->observacoes))
                    <tr>
                        <td colspan="5">
                            <div class="pull-left">{!!$plano->observacoes!!}</div>
                        </td>
                    </tr>
                @endif
            </table>
                    
            <h4>Planejamento das Aulas (sujeito a mudanças no decorrer do semestre)</h4>
            <table>
                <thead>
                    <tr>
                        <th>Aula</th>
                        <th>Prática/Teórica</th>
                        <th>Data</th>
                        <th>Conteúdo Previsto</th>
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
            <div class="pull-left"><p class="margemtZero"><strong><u>Atenção:</u></strong> No planejamento acima, cada "aula" corresponde a duas aulas de 50 minutos ou 1h 40 minutos.</p></div>
            
        </div>

        <table>
            <tr>
                <td colspan="5">
                    <div class="pull-left">Bibliografia Básica:</div>
                    <div class="pull-left">{!!$plano->bibliografiab!!}</div>
                    <br>
                </td>
            </tr>

            <tr>
                <td colspan="5">
                    <div class="pull-left">Bibliografia Complementar:</div>
                    <div class="pull-left">{!!$plano->bibliografiac!!}</div>
                    <br>
                </td>
            </tr>
        </table>
        
    </div> <!-- end container -->

</body>
</html>
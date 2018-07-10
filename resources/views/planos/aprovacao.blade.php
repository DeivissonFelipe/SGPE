@extends('layouts.adminlte')

@push('tituloAba')
    Planos
@endpush

@section('breadcrumb')

<h1>
    Aprovação
    <small>Index</small>
</h1>

{!! Breadcrumbs::render('aprovacao') !!}

@endsection

@push('css')
    <link href="{{ asset('/css/ajax.css')}}" rel="stylesheet" type="text/css" />
@endpush
 
@push('javascript')
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="{{ asset ('/bower_components/select2/dist/js/select2.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush

@section('content')
    <div id="ajax-info"></div>
	<div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Planos em análise</h3>
                    <div id="loading" style="float:right; display:none">
                        <label>&nbsp;</label>
                        <div class="lds-dual-ring" style="float:right; margin-top: 0px; margin-right: 0px;">
                            <div></div>
                        </div>
                    </div>
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
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($planos as $p)
                                <tr>
                                    <td><a href="/planos/{{$p->id}}/expandir" target="_blank">{{$p->turma->disciplina->nome}}</a></td>
                                    <td>{{$p->turma->curso->nome}}</td>
                                    <td>{{$p->turma->numero_turma}}</td>
                                    <td>{{$p->turma->semestre->rotulo}}</td>
                                    <td><a href="/aprovar/{{$p->id}}" class="btn btn-success btn-sm">Aprovar</a></td>
                                    <td><a href="/planos/{{$p->id}}/pendencia" class="btn btn-danger btn-sm">Pendências</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- end box-body -->
            </div><!-- end box box-primary-ufop -->
            {{$planos->links()}}
        </div><!-- end col-md-8 col-md-offset-2 -->  
    </div><!-- end row -->
    
@endsection
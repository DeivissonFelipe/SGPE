@extends('layouts.adminlte')

@push('tituloAba')
	Planos
@endpush

@section('breadcrumb')

<h1>
    Planos
    <small>Edição</small>
</h1>

{!! Breadcrumbs::render('planoEdit', $plano) !!}

@endsection


@if ($plano->status != "Em Edição")
    @push('javascript')
        <script>
            $(document).ready(function(){
                $('.btn-edit').click(function(event){
                    var btn = $(this);
                    $('#continue').attr("href", btn.attr("data-href"));
                    $('#modaledit').show(); 
                });
            });
        </script>
    @endpush
@endif

@section('content')
	<div class="container-fluid">
		
		<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
			<div class="box box-primary-ufop">
			    <div class="box-header">
			    	<h2 class="page-header">{{$plano->turma->disciplina->nome}} </h2>
			    </div><!-- end box-header -->
			    <div class="box-body">
                    @if ($plano->status == "Em Edição")
					<div class="btn-group btn-group-justified" role="group" arial-label="menu" style="margin-bottom:1px">
                        <div class="btn-group" style="border:1px solid white">
                            <a class="btn btn-ufop btn-edit"  href="/planos/{{$plano->id}}/planejamentos">Planejamento</a>
                        </div>
                        <div class="btn-group" style="border:1px solid white">
                            <a class="btn btn-ufop btn-edit"  href="/planos/{{$plano->id}}/exames">Exames</a>
                        </div>
                        <div class="btn-group" style="border:1px solid white">
                            <a class="btn btn-ufop btn-edit"  href="/planos/{{$plano->id}}/avaliacoes">Atividades Avaliativas</a>
                        </div>
                    </div>
                    <div class="btn-group btn-group-justified" role="group" arial-label="menu">
                        <div class="btn-group" style="border:1px solid white"> 
                            <a class="btn btn-ufop btn-edit"  href="/planos/{{$plano->id}}/metodologias">Metodologia</a>
                        </div>
                        <div class="btn-group" style="border:1px solid white">
                            <a class="btn btn-ufop btn-edit"  href="/planos/{{$plano->id}}/objetivos">Objetivos</a>
                        </div>
                    </div>
                    @else
                    <div class="btn-group btn-group-justified" role="group" arial-label="menu" style="margin-bottom:1px">
                        <div class="btn-group" style="border:1px solid white">
                            <a class="btn btn-ufop btn-edit" data-toggle="modal" data-target="#modaledit" data-href="/planos/{{$plano->id}}/planejamentos">Planejamento</a>
                        </div>
                        <div class="btn-group" style="border:1px solid white">
                            <button class="btn btn-ufop btn-edit" data-toggle="modal" data-target="#modaledit" data-href="/planos/{{$plano->id}}/exames">Exames</button>
                        </div>
                        <div class="btn-group" style="border:1px solid white">
                            <a class="btn btn-ufop btn-edit" data-toggle="modal" data-target="#modaledit" data-href="/planos/{{$plano->id}}/avaliacoes">Atividades Avaliativas</a>
                        </div>
                    </div>
                    <div class="btn-group btn-group-justified" role="group" arial-label="menu">
                        <div class="btn-group" style="border:1px solid white"> 
                            <a class="btn btn-ufop btn-edit" data-toggle="modal" data-target="#modaledit" data-href="/planos/{{$plano->id}}/metodologias">Metodologia</a>
                        </div>
                        <div class="btn-group" style="border:1px solid white">
                            <a class="btn btn-ufop btn-edit" data-toggle="modal" data-target="#modaledit" data-href="/planos/{{$plano->id}}/objetivos">Objetivos</a>
                        </div>
                        
                    </div> 
                    <div id="modaledit" class="modal fade">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h4>Este plano se encontra com status "{{$plano->status}}". Alterá-lo mudará o seu status para "Em Edição" e deixará de ser acessível para outros usuários. Tem certeza que quer continuar?</h4>
                                    <div class="modal-footer">
                                        <a href="#"  id="continue" class="btn btn-warning">Continuar</a>
                                        <button type="button" data-dismiss="modal" id="cancel" class="btn btn-default">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    @endif

			    </div><!-- end box-body -->
			</div><!-- end box box-primary-ufop -->
		</div><!-- end col-lg-8 col-lg-offset-2  col-md-10 col-md-offset-1 --> 
	</div><!-- end container-fluid -->

@endsection
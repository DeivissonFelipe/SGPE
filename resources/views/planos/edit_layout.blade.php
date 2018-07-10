@extends('layouts.adminlte')

@push('tituloAba')
	Edição
@endpush

@section('content')
	<div class="container-fluid">
		<div class="btn-group btn-group-justified" role="group" arial-label="menu" style="margin-bottom:1px">
			<div class="btn-group" style="border:1px solid white">
				<a class="btn btn-ufop" href="/planos/{{$plano->id}}/planejamentos">Planejamento</a>
			</div>
			<div class="btn-group" style="border:1px solid white">
				<a class="btn btn-ufop" href="/planos/{{$plano->id}}/exames">Exames</a>
			</div>
			<div class="btn-group" style="border:1px solid white">
				<a class="btn btn-ufop" href="/planos/{{$plano->id}}/avaliacoes">Atividades Avaliativas</a>
			</div>
		</div>
		<div class="btn-group btn-group-justified" role="group" arial-label="menu">
			<div class="btn-group" style="border:1px solid white"> 
				<a class="btn btn-ufop" href="/planos/{{$plano->id}}/metodologias">Metodologia</a>
			</div>
			<div class="btn-group" style="border:1px solid white">
				<a class="btn btn-ufop" href="/planos/{{$plano->id}}/objetivos">Objetivos</a>
			</div>
		</div> <br>

		<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
			<div class="box box-primary-ufop">
			    <div class="box-header">
			    	<h2 class="page-header">{{$plano->turma->disciplina->nome}}  @stack('tituloPlano')</h2>
			    </div><!-- end box-header -->
			    <div class="box-body">
					@yield('edit-content')
			    </div><!-- end box-body -->
			</div><!-- end box box-primary-ufop -->
		</div><!-- end col-lg-8 col-lg-offset-2  col-md-10 col-md-offset-1 --> 
	</div><!-- end container-fluid -->
@endsection
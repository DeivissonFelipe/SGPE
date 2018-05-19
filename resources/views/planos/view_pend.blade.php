@extends('layouts.adminlte')

@push('tituloAba')
    Planos
@endpush

@section('breadcrumb')
<h1>
    Planos
    <small>Pendências</small>
</h1>

{!! Breadcrumbs::render('planoPend', $plano) !!}

@endsection
     
@section('content')
	<div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            @if(isset($pendencias))
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Pendências</h3>
                </div><!-- end box-header -->
                <div class="box-body">
                    @foreach($pendencias as $pend)
                    <div class="well">
                        <div class="pull-right">{{ Carbon\Carbon::parse($pend->created_at)->format('d-m-Y / H:i') }}</div><br><br>
                        {!!$pend->pendencia!!}
                    </div>
					@endforeach
                </div>
            </div>
            @endif
        </div><!-- end col-md-8 col-md-offset-2 -->  
    </div><!-- end row -->    
@endsection
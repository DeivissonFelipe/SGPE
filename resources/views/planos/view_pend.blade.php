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
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            {!!$pend->pendencia!!}
                        </div>
                        <div class="panel-footer" >
                            <span style="float:right">
                                {{ Carbon\Carbon::parse($pend->created_at)->format('d/m/y [H:i]') }}
                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
					@endforeach
                </div>
            </div>
            @endif
        </div><!-- end col-md-8 col-md-offset-2 -->  
    </div><!-- end row -->    
@endsection
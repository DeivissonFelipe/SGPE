@extends('layouts.error')

@push('tituloAba')
    Erro 503
@endpush

@section('content')
    <div class='row'>    
        <div class="error-page">
            <h2 class="headline text-yellow"> 503</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Serviço Indisponível.</h3>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.error')

@push('tituloAba')
    Erro 404
@endpush

@section('content')
    <div class='row'>    
        <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Desculpe! Não conseguimos encontrar a página solicitada.</h3>
            </div>
        </div>
    </div>
@endsection
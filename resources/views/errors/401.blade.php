@extends('layouts.error')

@push('tituloAba')
    Erro 401
@endpush

@section('content')
    <div class='row'>    
        <div class="error-page">
            <h2 class="headline text-red"> 401</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> Desculpe! Você não tem permissão necessária para acessar este conteúdo.</h3>
            </div>
        </div>
    </div>
@endsection
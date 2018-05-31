@extends('layouts.error')

@push('tituloAba')
    Erro 405
@endpush

@section('content')
    <div class='row'>    
        <div class="error-page">
            <h2 class="headline text-yellow"> 405</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Desculpe! Método não permitido.</h3>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.error')

@push('tituloAba')
    Erro 408
@endpush

@section('content')
    <div class='row'>    
        <div class="error-page">
            <h2 class="headline text-yellow"> 408</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Tempo de Solicitação Esgotado.</h3>
            </div>
        </div>
    </div>
@endsection
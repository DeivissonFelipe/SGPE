@extends('layouts.adminlte')

@push('css')
<style>
    p{
        text-align: justify;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-8 col-lg-offset-2">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <h3>Olá, {{Auth::user()->name}}</h3><br> 
                    <h4 style="text-align: justify;">O Sistema Gerenciador de Plano de Ensino(SGPE), é uma plataforma online que foi desenvolvida com o intuito de possibilitar a criação e a validação dos documentos de forma fácil, e integrá-los em um único local.</h4>

                    @if(Auth::user()->hasRole('Admin'))
                    <p>Você como <strong><i>Administrador</i></strong>, através da barra ao lado, tem acesso às seções:</p>
                    <ul>
                        <li><h4>Cursos</h4></li>
                            <p>Onde poderá criar, editar e excluir as informações dos cursos ofertados no campus. Que serão usadas para compor as turmas.</p>
                        <li><h4>Departamentos</h4></li>
                            <p>Para criar, editar e excluir informações dos departamentos do campus. Que serão usadas para compor as turmas.</p>
                        <li><h4>Disciplinas</h4></li>
                            <p>Para criar, editar e excluir informações das disciplinas ofertadas no campus.</p>
                        <li><h4>Feriados</h4></li>
                            <p>Criando, editando e excluindo os feriados e possíveis dias não letivos de um semestre específico, configura o calendário do sistema e facilita o processo de edição dos planos</p>
                        <li><h4>Semestre</h4></li>
                            <p>Criar, editar e excluir os dados de um semestre, ajuda a configurar o sistema para auxiliar no processo de criação das turmas e divisão dos planos através do tempo.</p>
                        <li><h4>Substituições</h4></li>
                            <p>Nesta seção você poderá configurar dias letivos que terão suas atividades trocadas de acordo com um dia específico da semana. Esse processo ajuda na validação dos dados do planos de ensino.</p>
                        <li><h4>Aprovação dos Planos</h4></li>
                            <p>Analisando os planos com status 'Em Análise', você poderá aprovar os planos de ensino, ou caso contrário reprová-los enviando uma pendência ao professor dono daquele plano.</p>
                    </ul>
                    @endif


                    
                    @if(Auth::user()->hasRole('Professor'))
                    <p>Você como <strong><i>Professor</i></strong>, através da barra ao lado, tem acesso às seções:</p>
                    <ul>
                        <li><h4>Novo Plano</h4></li>
                            Esta seção é destinada à criação de um novo plano, configurando a disciplina a ser lecionada, o semestre, curso, além dos dias lecionados e afins.
                        <li><h4>Meus Planos</h4></li>
                            É possível acessar as funcionalidades:
                            <ol>
                                <li>Pesquisar os seus planos de ensinos.</li>
                                <li>Acessar a área de visualização do plano.</li>
                                <li>Editar as informações do plano.</li>
                                <li>Enviar este plano para análise e aprovação.</li>
                            </ol>
                        <li><h4>Planos em Geral</h4></li>
                            Os planos aprovados e disponibilizados na plataforma são acessíveis nesta seção, além de visualizar a apresentação dos planos também é possível, exportar (copiar)
                            os dados destes planos para um plano recém criado.
                    </ul>
                    @endif
                    <p>Os planos possuem uma propriedade chamada <i>'status'</i>. Quando criado, um plano de ensino estará automaticamente com o status <i>'Em Edição'</i></p>
                    <p>Caso o plano for enviado para análise seu status será <i>'Em Análise'</i>. Neste modo o plano de ensino será acessível somente aos administradores do sistema.</p>
                    <p>Uma vez que o plano seja aprovado, seu status será <i>'Aprovado'</i>, e poderá ser acessado por todos.</p>
                    
                </div><!-- end panel-body -->
            </div><!-- end panel panel-default -->
        </div><!-- end col-md-8 col-md-offset-2 -->
    </div><!-- end row -->
</div><!-- end container -->

@endsection

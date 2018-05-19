@extends('layouts.adminlte')

@push('tituloAba')
   Planos
@endpush

@section('breadcrumb')
<h1>
    Planos
    <small>Exportação</small>
</h1>

{!! Breadcrumbs::render('planoExport', $pOrign) !!}

@endsection


@push('css')
    <style>
        .glyphicon.glyphicon-arrow-right {
            font-size: 75px;
            color:#962038;
        }
    </style>
@endpush

@push('javascript')
    <script src="{{ asset ('/bower_components/select2/dist/js/select2.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script>
        $(document).ready(function(){
            $('.confirm_export').click(function(event){
                var btnexport = $(this);
                var msg = "Esta ação irá excluir todos os dados do plano de ensino: "+ $('#nomeOrign').html() +" [ "+ $("[name='pOrign']").attr('data-semestre')+"], e copiar os dados do plano: "+ $("[name='pDestiny']").find('option:selected').attr('data-nome') +" [ "+ $("[name='pDestiny']").find('option:selected').attr('data-semestre')+"] para o anterior. Tem certeza que deseja continuar?"
                $('#modal-msg').html(msg);
                $('#export_modal').show(); 
                $('#export').off( "click").click(function(){
                    console.log(btnexport.closest('form'));
                    btnexport.closest('form').submit();
                }); 
            });
        });
	</script>

@endpush

@section('content')

    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Painel de Exportação</h3>
                </div><!-- end box-header -->
                <div class="box-body">                    
                    <form role="form" action="/planos/export" method="post">
                        {{ csrf_field() }} 
                        <div class='col-md-4'>
                            <input type="hidden" name="pOrign" data-semestre="{{$pOrign->turma->semestre->rotulo}}" value="{{$pOrign->id}}">
                            <label>Plano de Ensino <i>"Origem"</i></label>
                            <h5><span id="nomeOrign">{{$pOrign->turma->disciplina->nome}}</span> - {{$pOrign->turma->semestre->rotulo}} </h5>
                        </div>
                        <div class='col-md-4'>
                            <div class="text-center">
                                <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class="form-group">
                                <label>Selecione o Plano de Ensino <i>"destino"</i></label>
                                <select class="form-control select2" name="pDestiny">
                                    @foreach($planos_user as $p)
                                        <option value="{{$p->id}}" data-nome="{{$p->turma->disciplina->nome}}" data-semestre="{{$p->turma->semestre->rotulo}}">{{$p->turma->disciplina->codigo}} - {{$p->turma->disciplina->nome}} - {{$p->turma->semestre->rotulo}} </option>
                                    @endforeach
                                </select>
                            </div><!-- end form-group -->
                        </div>
                        
                        <div class='col-md-8 col-md-offset-2'>
                            <div class="box-footer">
                                <button type="button" class="btn btn-block btn-ufop confirm_export" data-toggle="modal" data-target="#export_modal">Exportar</button>
                            </div><!-- end box-footer -->
                        </div>
                    </form>
                    
                </div><!-- end box-body -->
            </div><!-- end box box-primary-ufop -->
        </div><!-- end col-md-8 col-md-offset-2 -->
    </div><!-- end row -->



    <div id="export_modal" class="modal fade">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 id="modal-msg"></h4>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" id="export" class="btn btn-danger">Exportar</button>
                        <button type="button" data-dismiss="modal" id="cancel" class="btn btn-default">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div> 

@endsection

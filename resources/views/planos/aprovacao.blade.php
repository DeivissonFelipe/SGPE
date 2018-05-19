@extends('layouts.adminlte')

@push('tituloAba')
    Planos
@endpush

@section('breadcrumb')

<h1>
    Aprovação
    <small>Index</small>
</h1>

{!! Breadcrumbs::render('aprovacao') !!}

@endsection

@push('css')
    <link href="{{ asset('/css/ajax.css')}}" rel="stylesheet" type="text/css" />
@endpush
 
@push('javascript')
    <meta name="_token" content="{!! csrf_token() !!}" />
	<script>
        $(document).ajaxStart(function(){ 
            $('#loading').show(); 
        });

        $(document).ajaxStop(function(){ 
            $('#loading').hide(); 
        });

        $('#form').submit(function(e){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            e.preventDefault(); 

            var formData = {
                semestre: $('#semestre').val(),
            }

            var type = "POST"; 
            var my_url = '/aprovacaoSemestre';


            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    var row;
                    //Apagar a tabela e colocar os novos valores;
                    $('#tbody').empty();
                    $.each(data, function(index, value){
                        row = "<tr>";
                        row += "<td><a href='/planos/" + value.id + "'>" + value.nome + "</a></td>";
                        row += "<td>"+ value.curso +"</td>";
                        row += "<td>"+ value.turma +"</td>";
                        row += "<td>"+ value.semestre +"</td>";
                        row += "<td><button  class='btn btn-success btn-sm'>Aprovar</button></td>";
                        row += "<td><a href='/planos/"+ value.id +"/pendencia' class='btn btn-danger btn-sm'>Pendências</a></td>";
                        row += "</tr>";
                        $('#tbody').append(row);
                    });
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

        });

        (function($) {	  
            aprovar = function(item, id) {
                var $tr = $(item).closest('tr');	
                $.ajax({
                    type: 'get',
                    url: '/aprovar/' + id,
                    dataType: 'json',
                    success: function(e){
                        if (e.success) {
                            $tr.fadeOut(600, function() {
                                $tr.remove();
                            });
                            $("div#ajax-info").html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="close">&times;</button><div class="ajax-msg"></div></div>');
                            $(".ajax-msg").text(e.msg);
                            $("div#ajax-info").show();
                            $("div#ajax-info").delay(3000).slideUp(300);
                        }
                    }
                });
    	    }	
        })(jQuery);
	</script>
    <script src="{{ asset ('/bower_components/select2/dist/js/select2.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush

@section('content')
    <div id="ajax-info"></div>
	<div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Planos em análise</h3>
                </div><!-- end box-header -->
                <div class="box-body">
                    <div class="row">
                        <form id="form" >
                            <div class="form-group col-sm-4">
                                <label for="semestre">Semestre</label>
                                <select class="form-control select2" tabindex="-1" aria-hidden="true" name="semestre" id="semestre">
                                    @foreach($array as $a)
                                        <option value="{{$a['id']}}">{{$a['nome']}}</option>  
                                    @endforeach
                                </select>
                            </div><!-- end form-group  col-sm-4 -->

                            <div class="form-group col-sm-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-ufop btn-sm btn-block">Buscar</button>
                            </div><!-- end form-group col-sm-4 -->
                            <div class="form-group col-sm-1" id="loading" style="display:none">
                                <label>&nbsp;</label>
                                <div class="lds-dual-ring" style="margin-top: -5px">
                                    <div></div>
                                </div>
                            </div>
                        </form>
                    </div> 
                    <div class="table-responsive">
                        <table id="table" class="table table-hover table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Curso</th>
                                    <th>Turma</th>
                                    <th>Semestre</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($planos as $p)
                                <tr>
                                    <td><a href="/planos/{{$p->id}}">{{$p->turma->disciplina->nome}}</a></td>
                                    <td>{{$p->turma->curso->nome}}</td>
                                    <td>{{$p->turma->numero_turma}}</td>
                                    <td>{{$p->turma->semestre->rotulo}}</td>
                                    <td><button type="button" onclick="aprovar(this, {{$p->id}})" class="btn btn-success btn-sm">Aprovar</a></td>
                                    <td><a href="/planos/{{$p->id}}/pendencia" class="btn btn-danger btn-sm">Pendências</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- end box-body -->
            </div><!-- end box box-primary-ufop -->
            {{$planos->links()}}
        </div><!-- end col-md-8 col-md-offset-2 -->  
    </div><!-- end row -->
    
@endsection
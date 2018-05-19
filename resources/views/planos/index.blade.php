@extends('layouts.adminlte')

@push('tituloAba')
    Planos
@endpush

@section('breadcrumb')

<h1>
    Planos
    <small>Index</small>
</h1>

{!! Breadcrumbs::render('plano') !!}

@endsection

@push('css')
    <link href="{{ asset('/css/ajax.css')}}" rel="stylesheet" type="text/css" />
@endpush
 
@push('javascript')
    <script src="{{ asset ('/bower_components/select2/dist/js/select2.min.js')}}" type="text/javascript"></script>
    <meta name="_token" content="{!! csrf_token() !!}" />
    
	<script>
        $(document).ajaxStart(function(){ 
            $('#loading').show(); 
            $('#container-ajaxTransition').hide();
        });

        $(document).ajaxStop(function(){ 
            $('#loading').hide(); 
            $('#container-ajaxTransition').show();
        });

		$('#category').on('change', function(e){
            var id = e.target.value;
            
            if(id == '0'){
                $('.disable').prop("disabled", true);
                $('#subcategory').empty();
                $('#form').submit();
            }else{
                $('.disable').prop("disabled", false);
                $.get('/ajax-category?id=' + id, function(data){
                    $('#subcategory').empty();
                    $.each(data, function(index, object){
                        $('#subcategory').append('<option value="'+ object.id +'">'+ object.nome +'</option>');
                    });
                });
            }
        });

        $('#form').submit(function(e){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            e.preventDefault(); 

            var formData = {
                category: $('#category').val(),
                subcategory: $('#subcategory').val(),
            }

            var type = "POST"; 
            var my_url = '/busca';


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
                        row += "</tr>";
                        $('#tbody').append(row);
                    
                    });
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

        });

    </script>
        
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush

@section('content')
	<div class='row'>
        <div class='col-md-8'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Planos Cadastrados</h3>
                </div><!-- end box-header -->
                <div class="box-body">
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- end box-body -->
            </div><!-- end box box-primary-ufop -->
            {{ $planos->links() }}
        </div><!-- end col-md-8 col-md-offset-2 -->

        <div class='col-md-4'>
            <div class="box box-primary-ufop">
                <div class="box-header">
                    <h3 class="box-title">Pesquisa</h3>
                </div><!-- end box-header -->
                <div class="box-body">
                    
                    <form id="form" >
                        <div class="form-group col-sm-auto">
                            <label>Categoria</label>
                            <select class="form-control select2" style="width: 100%;" name="category" id="category">
                                <option value="0">Meus Planos</option>    
                                <option value="1">Disciplina</option>
                                <option value="2">Código</option>
                                <option value="3">Professor</option>
                                <option value="4">Curso</option>
                                <option value="5">Semestre</option>
                            </select>
                        </div><!-- end form-group  col-sm-auto -->
                        <div class="col-sm-4 col-sm-offset-4" id="loading" style="display:none">
                            <div class="lds-dual-ring">
                                <div></div>
                            </div>
                        </div>
                        <div id="container-ajaxTransition">
                            <div class="form-group col-sm-8" >
                                <label>SubCategoria</label>
                                <select class="form-control select2 disable" style="width: 100%;" name="subcategory" id="subcategory" disabled>
                                    <option value="0"></option>    
                                </select>
                            </div><!-- end form-group col-sm-8 -->
                            <div class="form-group col-sm-4">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-ufop btn-sm btn-block disable" disabled="disabled">Buscar</button>
                            </div><!-- end form-group col-sm-4 -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- end row -->
    
@endsection
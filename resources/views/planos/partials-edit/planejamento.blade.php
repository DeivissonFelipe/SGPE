@extends('planos.edit_layout')

@push('tituloPlano')
	(Planejamento)
@endpush

@section('breadcrumb')
<h1>
    Planos
    <small>Planejamento</small>
</h1>

{!! Breadcrumbs::render('planoPlan', $plano) !!}

@endsection


@push('css')
  <!-- Bootstrap toggle v2.2.0 -->
  <link href="{{ asset('/bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}" rel="stylesheet" type="text/css" />
  <!-- CDN Bootstrap toggle v2.2.0-->
  <!-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"> -->
  
  <link href="{{ asset('/css/ajax.css')}}" rel="stylesheet" type="text/css" />
  <style>
    .datepicker-edit {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
  </style>

  <!-- Datepicker v1.7.1 -->
	<link href="{{ asset('/jquery-ui-1.12.1.custom-ufop/jquery-ui.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/css/ajax.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('javascript')
  <meta name="_token" content="{!! csrf_token() !!}" />

  <!-- Bootstrap toggle v2.2.0 -->
  <script src="{{ asset ('/bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js') }}" type="text/javascript"></script>
  <!-- CDN Bootstrap toggle v2.2.0 -->
  <!-- <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->

  <script type="text/javascript">
    $( document ).ready(function() {
      if({{$plano->tipo}} == 1){
        $('#toggle-event').bootstrapToggle('on');
        $('#divPlanAula').show();
        $('#divPlanUnidade').hide();
      }else if({{$plano->tipo}} == 2){
        $('#toggle-event').bootstrapToggle('off');
        $('#divPlanUnidade').show();
        $('#divPlanAula').hide();
      }
    });

    $(document).ajaxStart(function(){ 
        $('#loading').show(); 
        $('#toggle-planTipo').hide();
    });

    $(document).ajaxStop(function(){ 
        $('#loading').hide(); 
        $('#toggle-planTipo').show();
    });

    $(function() {
      $('#toggle-event').change(function() {
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });
        if($(this).prop('checked')){
          $.ajax({
            type: 'POST',
            url: '/planTipo',
            data: {tipo:"1", id: {{$plano->id}}}, //Plano Aula
            success: function (data) {
              $('#divPlanAula').show();
              $('#divPlanUnidade').hide();
            }
          });
          
        }
        else{
          $.ajax({
            type: 'POST',
            url: '/planTipo',
            data: {tipo:"2", id: {{$plano->id}}}, //Plano Unidade
            success: function (data) {
              $('#divPlanUnidade').show();
              $('#divPlanAula').hide();
            }
          }); 
        }
      });
    });
  </script>

  <script type="text/javascript">
    $('.modal').on('shown.bs.modal', function() {
        var str = $(this).attr('id');
        var res = str.split("-");
        var datepickerid = "#datepicker-"+res[1];

        var d_inicio = {{\Carbon\Carbon::parse($semestre->inicio)->day}};
        var m_inicio = {{\Carbon\Carbon::parse($semestre->inicio)->month}} - 1;
        var y_inicio = {{\Carbon\Carbon::parse($semestre->inicio)->year}};
        var d_fim = {{\Carbon\Carbon::parse($semestre->fim)->day}};
        var m_fim = {{\Carbon\Carbon::parse($semestre->fim)->month}} - 1;
        var y_fim = {{\Carbon\Carbon::parse($semestre->fim)->year}};
        var diasNaoLetivos = {!!$diasNaoLetivos!!};
        $(datepickerid).datepicker("destroy");
        $(datepickerid).datepicker({
          autoclose: true,
          orientation: "bottom",
          minDate: new Date(y_inicio,m_inicio,d_inicio),
          maxDate: new Date(y_fim,m_fim,d_fim),
          dateFormat: 'dd-mm-yy',
          beforeShowDay: function(date) {
            var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
            var day = date.getDay();
            return (day != 0) ? [$.inArray(string, diasNaoLetivos) == -1] : [false];
          }
        });
    });
  </script>

	<!-- Datepicker v1.7.1 -->
	<script src="{{ asset ('/jquery-ui-1.12.1.custom-ufop/jquery-ui.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			var d_inicio = {{\Carbon\Carbon::parse($semestre->inicio)->day}};
			var m_inicio = {{\Carbon\Carbon::parse($semestre->inicio)->month}} - 1;
			var y_inicio = {{\Carbon\Carbon::parse($semestre->inicio)->year}};
			var d_fim = {{\Carbon\Carbon::parse($semestre->fim)->day}};
			var m_fim = {{\Carbon\Carbon::parse($semestre->fim)->month}} - 1;
			var y_fim = {{\Carbon\Carbon::parse($semestre->fim)->year}};
			var diasNaoLetivos = {!!$diasNaoLetivos!!};
		
		    $( '#exame_data, #planejamento_data ').datepicker({
				autoclose: true,
				orientation: "bottom",
				minDate: new Date(y_inicio,m_inicio,d_inicio),
				maxDate: new Date(y_fim,m_fim,d_fim),
				dateFormat: 'dd-mm-yy',
				beforeShowDay: function(date) {
					var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
					var day = date.getDay();
					return (day != 0) ? [$.inArray(string, diasNaoLetivos) == -1] : [false];
        }
			});
		});
	</script>
@endpush

@section('edit-content')
<div class="tab-pane" id="planejamento">

  <div class="header pull-right">
    <div id="toggle-planTipo">
      <input id="toggle-event" type="checkbox" data-size="small" data-width="100" data-toggle="toggle" data-on="Aula" data-off="Unidade" data-onstyle="warning" data-offstyle="info">
    </div>
    <div id="loading" style="display:none">
        <div class="lds-dual-ring">
            <div></div>
        </div>
    </div>
  </div><!-- end header pull-right -->
                        
  <br><br><br>  

  <div class="box box-primary-ufop" id="divPlanAula">
    <div class="box-header with-border">
      <h3 class="box-title">Planejamento por Aula</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div><!-- end box-tools pull-right -->
    </div><!-- end box-header with-border -->

    <div class="box-body">
      @if(count($plano->planejamentoAulas)>0)
      <table id="table" class="table table-hover table-striped table-bordered text-center">
        <thead>
          <tr>
            <th>Aula</th>
            <th>Prática/Teórica</th>
            <th>Data</th>
            <th>Conteúdo Previsto</th>
          </tr>
        </thead>
        <tbody>
          @foreach($plano->planejamentoAulas as $p)
            <tr>
              <td>{{$p->aula}}</td>
              <td>{{$p->tipo}}</td>
              <td>{{$p->data}}</td>
              <td>{{$p->conteudo}}</td>
              <td><a class="btn btn-ufop"  role="button" data-toggle="modal" data-target="#pAulaModal-{{$p->id}}" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil"></i></a></td>
              <td>
                <form method="post" action="/planejamentoAulas/{{ $p->id }}">
                  {{ method_field('DELETE') }}
                  {{ csrf_field() }}
                  <input type="text" name="plano_id" value="{{$plano->id}}" hidden>
                  <button class="confirm_delete btn btn-ufop " data-toggle="modal" data-target="#confirm" type="button" data-toggle="tooltip" title="Apagar"><i class="fa fa-trash"></i></buttom>
                </form>
              </td>
            </tr>

            <!-- ********************************************************************************************* -->
            <div class="modal fade" id="pAulaModal-{{$p->id}}" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edição - Planejamento Aula</h4>
                  </div><!-- end modal-header -->
                  <div class="modal-body">
                    <form role="form" action="/planejamentoAulas/{{ $p->id }}" method="post"> 
                      {{ method_field('PATCH') }}
                      {{ csrf_field() }}
                      <div class="row">
                        
                        <input type="text" name="plano_id" value="{{$plano->id}}" hidden>
                        
                        <div class="form-group col-lg-4">
                          <label for="aula">Aula</label>
                          <input type="number" class="form-control" name="aula" id="aula" value="{{ $p->aula }}" min="1"/>
                        </div><!-- end form-group col-lg-2 -->

                        <div class="form-group col-lg-4">
                          <label for="tipo">Tipo</label>
                          <select class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" name="tipo" value="{{ $p->tipo }}">
                          @php 
                            $array = ['T','P','P/T'];
                            foreach($array as $a){
									            if($a == $p->tipo){
                          @endphp
                              <option value="{{$p->tipo}}" selected>{{$p->tipo}}</option>
                          @php 
                              }else{
                          @endphp
                              <option value="{{$a}}">{{$a}}</option>
                          @php 
                              }
                            }
                          @endphp
                            
                          </select>
                        </div><!-- end form-group col-lg-2 -->

                        <div class="form-group col-lg-4">
                          <label for="data">Data</label>
                          <div class="input-group" >
                            <div class="input-group-addon" data-provide="datepicker">
                              <i class="fa fa-calendar"></i>
                            </div><!-- end input-group-addon -->
                            <input type="text" class="form-control pull-right date datepicker-edit" id="datepicker-{{ $p->id }}" name="data" value="{{ $p->data}}" >
                          </div><!-- end input-group -->
                        </div><!-- end form-group col-lg-2 -->

                        <div class="form-group col-lg-8 col-lg-offset-2">
                          <label for="conteudo">Conteúdo</label>
                          <input type="text" class="form-control" name="conteudo" id="conteudo" value="{{ $p->conteudo }}"/>
                        </div><!-- end form-group col-lg-4 -->

                        <div class="form-group col-lg-12 ">
                          <label>&nbsp;</label>
                          <button type="submit" class="btn btn-ufop btn-md btn-block">Salvar</button>
                        </div><!-- end form-group col-lg-2-->

                      </div><!-- end row -->
                    </form>
                  </div><!-- end modal-body -->
                </div><!-- end modal-content -->
              </div><!-- end modal-dialog -->
            </div><!-- end modal-fade -->
            <!-- ********************************************************************************************* -->
          @endforeach
        </tbody>
      </table><br>
      @endif
      <form role="form" action="/planejamentoAulas" method="post"> 
        {{ csrf_field() }}
        <div class="row">
          <input type="text" name="plano_id" value="{{$plano->id}}" hidden>
          
          <div class="form-group col-md-2 col-lg-2">
            <label for="aula">Aula</label>
            <input type="number" class="form-control" name="aula" id="aula" min="1" value="{{ old('aula') }}"/>
          </div><!-- end form-group col-md-2 col-lg-2 -->
          
          <div class="form-group col-lg-2">
            <label for="tipo">Tipo</label>
            <select class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" name="tipo">
              <option value="T">T</option>
							<option value="P">P</option>
              <option value="P/T">P/T</option>
						</select>
          </div><!-- end form-group col-lg-2 -->

          <div class="form-group col-md-3 col-lg-2">
            <label for="data">Data</label>
            <div class="input-group " data-provide="datepicker">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div><!-- end input-group-addon -->
              <input type="text" class="form-control pull-right date datepicker-me" id="planejamento_data" name="data">
            </div><!-- end input-group -->
          </div><!-- end form-group col-md-3 col-lg-2 -->

          <div class="form-group col-md-3 col-lg-4">
            <label for="conteudo">Conteúdo</label>
            <input type="text" class="form-control" name="conteudo" id="conteudo" value="{{ old('conteudo') }}"/>
          </div><!-- end form-group col-md-3 col-lg-4 -->

          <div class="form-group col-md-2 col-lg-2">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-ufop btn-md btn-block">Adicionar</button>
          </div><!-- end form-group col-md-2 col-lg-2 -->
        </div><!-- end row -->
      </form>
    </div><!-- end box-body -->
  </div><!-- end box box-primary-ufop collapsed-box -->

  

  <div class="box box-primary-ufop" id="divPlanUnidade">
    <div class="box-header with-border">
      <h3 class="box-title">Planejamento por Unidade</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
      </div><!-- end box-tools pull-right -->
    </div><!-- end box-header with-border -->

    <div class="box-body">
      @if(count($plano->planejamentoUnidades)>0)
      <table id="table" class="table table-hover table-striped table-bordered text-center">
        <thead>
          <tr>
              <th>Unidade</th>
              <th>Hora-aula</th>
              <th>Descrição</th>
          </tr>
        </thead>
        <tbody>
          @foreach($plano->planejamentoUnidades as $p)
            <tr>
              <td>{{$p->unidade}}</td>
              <td>{{$p->hora_aula}}</td>
              <td>{{$p->descricao}}</td>
              <td><a class="btn btn-ufop"  role="button" data-toggle="modal" data-target="#pUnidadeModal{{$p->id}}" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil"></i></a></td>
              <td>
                <form method="post" action="/planejamentoUnidades/{{ $p->id }}">
                  {{ method_field('DELETE') }}
                  {{ csrf_field() }}
                  <input type="text" name="plano_id" value="{{$plano->id}}" hidden>
                  <button class="confirm_delete btn btn-ufop " data-toggle="modal" data-target="#confirm" type="button" data-toggle="tooltip" title="Apagar"><i class="fa fa-trash"></i></buttom>
                </form>
              </td>
            </tr>

            <!-- ********************************************************************************************* -->
            <div class="modal fade" id="pUnidadeModal{{$p->id}}" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edição - Planejamento Unidade</h4>
                  </div><!-- end modal-header -->
                  <div class="modal-body">
                    <form role="form" action="/planejamentoUnidades/{{ $p->id }}" method="post"> 
                      {{ method_field('PATCH') }}
                      {{ csrf_field() }}
                      <div class="row">
                        <div class="col-lg-0 col-sm-auto">
                          <input type="text" name="plano_id" value="{{$plano->id}}" hidden>
                        </div><!-- end col-lg-1 col-sm-auto -->

                        <div class="form-group col-lg-6">
                          <label for="unidade">Unidade</label>
                          <input type="number" class="form-control" name="unidade" id="unidade" value="{{ $p->unidade}}" min="1"/>
                        </div><!-- end form-group col-lg-2 -->

                        <div class="form-group col-lg-6">
                          <label for="hora_aula">Hora-aula</label>
                          <input type="text" class="form-control" name="hora_aula" id="hora_aula" value="{{ $p->hora_aula}}"/>
                        </div><!-- end form-group col-lg-2 -->

                        <div class="form-group col-lg-6 ">
                          <label for="descricao">Descrição</label>
                          <input type="text" class="form-control" name="descricao" id="descricao" value="{{ $p->descricao}}"/>
                        </div><!-- end form-group col-lg-6 -->

                        <div class="form-group col-lg-4 col-sm-auto">
                          <label>&nbsp;</label>
                          <button type="submit" class="btn btn-ufop btn-md btn-block">Salvar</button>
                        </div><!-- end form-group col-lg-2 col-sm-auto -->
                      </div><!-- end row -->
                    </form>
                  </div><!-- end modal-body -->
                </div><!-- end-content-->
              </div>
            </div>
            <!-- ********************************************************************************************* -->
          @endforeach
        </tbody>
      </table><br>
      @endif
      <form role="form" action="/planejamentoUnidades" method="post"> 
        {{ csrf_field() }}
        <div class="row">
          <input type="text" name="plano_id" value="{{$plano->id}}" hidden>
          <div class="form-group col-md-2 col-lg-2">
            <label for="unidade">Unidade</label>
            <input type="number" class="form-control" name="unidade" id="unidade" min="1" value="{{ old('unidade') }}"/>
          </div><!-- end form-group col-lg-2 -->

          <div class="form-group col-md-2 col-lg-2">
            <label for="hora_aula">Hora-aula</label>
            <input type="text" class="form-control" name="hora_aula" id="hora_aula" value="{{ old('hora_aula') }}"/>
          </div><!-- end form-group col-lg-2 -->

          <div class="form-group col-md-5 col-lg-6">
            <label for="descricao">Descrição</label>
            <input type="text" class="form-control" name="descricao" id="descricao" value="{{ old('descricao') }}"/>
          </div><!-- end form-group col-lg-6 -->

          <div class="form-group col-md-3 col-lg-2">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-ufop btn-md btn-block">Adicionar</button>
          </div><!-- end form-group col-lg-2 -->
        </div><!-- end row -->
      </form>
    </div><!-- end box-body -->
  </div><!-- end box box-primary-ufop collapsed-box -->
@include('layouts.modalDelete')
</div><!-- end tab-pane -->
@endsection

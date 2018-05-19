@extends('planos.edit_layout')

@push('tituloPlano')
	(Exames)
@endpush

@section('breadcrumb')
<h1>
    Planos
    <small>Exames</small>
</h1>

{!! Breadcrumbs::render('planoExame', $plano) !!}

@endsection

@push('css')
	<!-- Datepicker v1.7.1 -->
	<link href="{{ asset('/jquery-ui-1.12.1.custom-ufop/jquery-ui.css')}}" rel="stylesheet" type="text/css" />
@endpush
     
@push('javascript')
	<!-- Tinymce -->
  	<script src="{{ asset ('/bower_components/tinymce/tinymce.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
		tinymce.init({
            selector: '.textareaTinymce',          
            menubar: false,
            plugins: "advlist lists autolink link autosave save charmap hr searchreplace table",

            toolbar1: 'undo redo | restoredraft save | link unlink | table subscript superscript charmap blockquote hr searchreplace',
            toolbar2: 'styleselect | bold italic strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | fontselect fontsizeselect | removeformat',
            
            browser_spellcheck: true,
            contextmenu: false,
            toolbar_items_size: 'small',
            autosave_ask_before_unload: false,
            autosave_interval: "30s",
            content_style: "p{padding:0; margin:0;}",
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
					var fimSemana = jQuery.datepicker.noWeekends(date);	
					return fimSemana[0] ? [$.inArray(string, diasNaoLetivos) == -1] : fimSemana[0];
        		}
			});
		});
	</script>
@endpush

@section('edit-content')
<div class="tab-pane" id="exame">
	@if(count($plano->exames)>0)
    <table id="table" class="table table-hover table-striped table-bordered text-center">
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Peso</th>
                <th>Data</th>
                <th>Conteúdo</th>
            </tr>
        </thead>
        <tbody>
        	@foreach($plano->exames as $e)
        	<tr>
				<td>{{$e->descricao}}</td>
				<td>{{$e->peso}}</td>
				<td>{{$e->data}}</td>
				<td>{{$e->conteudo}}</td>

				<td><a class="btn btn-ufop"  role="button" data-toggle="modal" data-target="#avaliacaoModal{{$e->id}}" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil"></i></a></td>
				<td>
					<form method="post" action="/exames/{{ $e->id }}">
						{{ method_field('DELETE') }}
						{{ csrf_field() }}
						<input type="text" name="plano_id" value="{{$plano->id}}" hidden>
						<button class="confirm_delete btn btn-ufop " data-toggle="modal" data-target="#confirm" type="button" data-toggle="tooltip" title="Apagar"><i class="fa fa-trash"></i></buttom>
					</form>
				</td>
			</tr>

			<!-- ********************************************************************************************* -->
			<div class="modal fade" id="avaliacaoModal{{$e->id}}" role="dialog">
			    <div class="modal-dialog">
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Edição - Avaliação</h4>
			        </div>
			        <div class="modal-body">
				        <form role="form" action="/exames/{{ $e->id }}" method="post"> 
							{{ method_field('PATCH') }}
							{{ csrf_field() }}
							<div class="row">
								
								<input type="text" name="plano_id" value="{{$plano->id}}" hidden>
								
								<div class="form-group col-lg-6">
									<label for="descricao">Descrição</label>
									<input type="text" class="form-control" name="descricao" id="descricao" value="{{$e->descricao}}" />
								</div><!-- end form-group col-lg-6 -->

								<div class="form-group col-lg-4">
									<label for="peso">Peso</label>
									<input type="number" class="form-control" name="peso" id="peso" placeholder="Valor da avaliação" value="{{$e->peso}}"/>
								</div><!-- end form-group col-lg-4 -->

								<div class="form-group col-lg-12">
									<label for="conteudo">Conteúdo</label>
									<input type="text" class="form-control" name="conteudo" id="conteudo" value="{{$e->conteudo}}" />
								</div><!-- end form-group col-lg-12 -->

								<div class="form-group col-lg-4">
									<label for="data">Data</label>
									<div class="input-group" data-provide="datepicker">
									  <div class="input-group-addon">
									    <i class="fa fa-calendar"></i>
									  </div><!-- end input-group-addon -->
									  <input type="text" class="form-control pull-right date datepicker-me" id="data" name="data" value="{{$e->data}}">
									</div><!-- end input-group -->
								</div><!-- end form-group col-lg-4 -->
								
								<div class="form-group col-lg-4 col-sm-auto">
									<label>&nbsp;</label>
									<button type="submit" class="btn btn-ufop btn-md btn-block">Salvar</button>
								</div><!-- end form-group col-lg-4 col-sm-auto -->
							</div><!-- end row -->
					    </form>
			        </div><!-- end modal-body -->
			      </div><!-- end modal-content -->
			    </div><!-- end modal-dialog -->
			</div><!-- end modal fade -->
			<!-- ********************************************************************************************* -->
			@endforeach
        </tbody>
    </table><br>
	@endif
	
    <form role="form" action="/exames" method="post"> 
		{{ csrf_field() }}
		<div class="row">
			<input type="text" name="plano_id" value="{{$plano->id}}" hidden>
			<div class="form-group col-md-3 col-lg-2">
				<label for="descricao">Descrição</label>
				<input type="text" class="form-control" name="descricao" id="descricao"/>
			</div><!-- end form-group col-lg-2 -->

			<div class="form-group col-md-2 col-lg-2">
				<label for="peso">Peso</label>
				<input type="number" class="form-control" name="peso" id="peso"/>
			</div><!-- end form-group col-lg-2 -->

			<div class="form-group col-md-3 col-lg-2">
				<label for="data">Data</label>
				<div class="input-group" data-provide="datepicker">
					<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</div><!-- end input-group-addon -->
					<input type="text" class="form-control pull-right date datepicker-me" id="exame_data" name="data">
				</div><!-- end input-group date datepicker-me -->
			</div><!-- end form-group col-lg-2 -->
					
			<div class="form-group col-md-4 col-lg-4">
				<label for="conteudo">Conteúdo</label>
				<input type="text" class="form-control" name="conteudo" id="conteudo"/>
			</div><!-- end form-group col-lg-4 -->

			<div class="form-group col-md-auto col-lg-2">
				<label>&nbsp;</label>
				<button type="submit" class="btn btn-ufop btn-md btn-block">Adicionar</button>
			</div><!-- end form-group col-lg-2 -->
		</div><!-- end row -->
    </form>

    <hr>
    <div class="box box-primary-ufop collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">Observações</h3>
		  <div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
          </div><!-- end box-tools pull-right -->
        </div><!-- end box-header with-border -->

        <div class="box-body">
			<form role="form" action="/planos/observacao" method="post"> 
				{{ csrf_field() }}
				<input type="text" name="plano_id" value="{{$plano->id}}" hidden>
				<div class="form-group">
					<textarea class="form-control textareaTinymce" name="observacoes">{{$plano->observacoes}}</textarea>
				</div><!-- end form-group -->
				<div class="row">
					<div class="form-group col-md-2 col-md-offset-10">
						<button type="submit" name="submitbtn" class="btn btn-ufop btn-md btn-block">Salvar</button>
					</div><!-- end form-group col-md-2 col-md-offset-10 -->
				</div><!-- end row -->
			</form>
        </div><!-- end box-body -->
    </div><!-- end box box-primary-ufop collapsed-box -->
	@include('layouts.modalDelete')
</div><!-- end tab-pane -->
@endsection
<div class="tab-pane" id="conteudo">
    <h4>Especificar os temas que compõe a ementa, detalhar os componentes do programa e apresentar os conhecimentos e habilidades em tópicos ou unidades de estudo.</h4>
    <br>
	<form role="form" action="/disciplinas/conteudo" method="post"> 
		{{ csrf_field() }}
		<input type="text" name="disciplina_id" value="{{$disciplina->id}}" hidden>
		<div class="form-group">
			<textarea class="form-control textareaTinymce" name="conteudo">{{$disciplina->conteudo}}</textarea>
		</div><!-- end form-group -->
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-10">
				<button type="submit" name="submitbtn" class="btn btn-ufop btn-md btn-block">Salvar</button>
			</div><!-- end form-group col-md-2 col-md-offset-10 -->
		</div><!-- end row -->
	</form>
</div><!-- end tab-pane active -->
<div class="tab-pane" id="bibc">
    <h4>Indicar no mínimo cinco e no máximo sete obras, de acordo com os livros que estão na biblioteca da unidade. 
        <a href="http://200.239.128.190/pergamum/biblioteca/index.php" target="_blank"> Link da biblioteca</a>
    </h4>
	<br>
    <form role="form" action="/disciplinas/bibliografiac" method="post"> 
        {{ csrf_field() }}
        <input type="text" name="disciplina_id" value="{{$disciplina->id}}" hidden>
        <div class="form-group">
            <textarea class="form-control textareaTinymce" name="bibliografiac">{{$disciplina->bibliografiac}}</textarea>
        </div><!-- end form-group -->
        <div class="row">
            <div class="form-group col-md-2 col-md-offset-10">
                <button type="submit" name="submitbtn" class="btn btn-ufop btn-md btn-block">Salvar</button>
            </div><!-- end form-group col-md-2 col-md-offset-10 -->
        </div><!-- end row -->
    </form>
</div><!-- end tab-pane active -->
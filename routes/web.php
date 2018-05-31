<?php

Route::group(['middleware' => 'auth'], function () {

	Route::get('/', function () {
    	return view('home');
	});

	Route::get('/home', function () {
    	return view('home');
	})->name('home');

	Route::group(['middleware' => 'roles', 'roles' =>['Professor','Admin']], function () {
		Route::resource('turmas', 'TurmaController', ['except'=> ['show']]);
		Route::resource('planos', 'PlanoController', ['except'=> ['create', 'store', 'update','destroy']]);
		Route::resource('horarios', 'HorarioController', ['only' => ['store', 'update', 'destroy']]);
		Route::resource('atendimentos', 'AtendimentoController', ['only' => ['store', 'update', 'destroy']]);
		Route::resource('exames', 'ExameController', ['only' => ['store', 'update', 'destroy']]);
		Route::resource('planejamentoAulas', 'PlanejamentoAulaController', ['only' => ['store', 'update', 'destroy']]);
		Route::resource('planejamentoUnidades', 'PlanejamentoUnidadeController', ['only' => ['store', 'update', 'destroy']]);

		Route::get('/planos/{plano}/atendimentos', 'AtendimentoController@atendimento');	
		Route::get('/planos/{plano}/aula', 'HorarioController@aula');	
		Route::get('/planos/{plano}/exames', 'ExameController@exame');	
		Route::get('/planos/{plano}/planejamentos', 'PlanoController@index_planejamento');	
		Route::get('/planos/{plano}/metodologias', 'PlanoController@index_metodologia');	
		Route::get('/planos/{plano}/bibliografias', 'PlanoController@index_bibliografia');	
		Route::get('/planos/{plano}/conteudos', 'PlanoController@index_conteudo');	
		Route::get('/planos/{plano}/ementas', 'PlanoController@index_ementa');	
		Route::get('/planos/{plano}/objetivos', 'PlanoController@index_objetivo');	
		Route::get('/planos/{plano}/avaliacoes', 'PlanoController@index_avaliacao');	

		Route::post('/planos/observacao', 'PlanoController@observacao');
		Route::post('/planos/ementa', 'PlanoController@ementa');
		Route::post('/planos/conteudo', 'PlanoController@conteudo');
		Route::post('/planos/objetivo', 'PlanoController@objetivo');
		Route::post('/planos/metodologia', 'PlanoController@metodologia');
		Route::post('/planos/avaliacao', 'PlanoController@avaliacao');
		Route::post('/planos/bibliografiab', 'PlanoController@bibliografiab');
		Route::post('/planos/bibliografiac', 'PlanoController@bibliografiac');
		Route::get('/planos/{plano}/export', 'PlanoController@export');
		Route::post('/planos/export', 'PlanoController@cpyPlano');
		Route::get('/planos/{plano}/view_pend', 'PlanoController@view_pend');

		Route::get('/ajax-category', 'PlanoController@category');
		Route::post('/busca', ['uses' => 'PlanoController@buscar', 'as'=>'busca']);
		Route::post('/planTipo', 'PlanoController@planTipo');
		Route::get('/planos/{plano}/verificacao', 'PlanoController@verificacao');
		Route::get('/planos/{plano}/warnings', 'PlanoController@warnings');
	});
	
	
	Route::group(['middleware' => 'roles', 'roles' =>['Admin']], function () {
		Route::resource('cursos', 'CursoController', ['except'=> ['show']]);
		Route::resource('departamentos', 'DepartamentoController', ['except'=> ['show']]);
		Route::resource('semestres', 'SemestreController', ['except'=> ['show']]);
		Route::resource('trocas', 'TrocaController', ['except'=> ['show']]);
		Route::resource('disciplinas', 'DisciplinaController', ['except'=> ['show']]);
		Route::resource('feriados', 'FeriadoController', ['except'=> ['show']]);
		Route::get('/aprovacao', 'PlanoController@aprovacao')->name('aprovacao');
		Route::post('/aprovacaoSemestre', 'PlanoController@aprovacaoSemestre');
		Route::get('/aprovar/{plano}', 'PlanoController@aprovar');
		Route::get('/planos/{plano}/pendencia', 'PlanoController@pendencia');
		Route::post('/planos/registrarPendencia', 'PlanoController@registrarPendencia');
		Route::get('/ajax-semestre', 'FeriadoController@ajaxSemestre');
		Route::get('/ajax-trocas', 'TrocaController@ajaxSemestre');
 	});


	Route::group(['middleware' => 'web'], function () {
		Route::get('/admin', [
		    'uses' => 'AppController@getAdminPage',
		    'as' => 'admin',
		    'middleware' => 'roles',
		    'roles' => ['Admin']
		]);

		Route::post('/admin/assign-roles', [
		    'uses' => 'AppController@postAdminAssignRoles',
		    'as' => 'admin.assign',
		    'middleware' => 'roles',
		    'roles' => ['Admin']
		]);
	});

	Route::get('/pdf', array('as' => 'pdf', 'uses' => 'PlanoController@pdf'));
	Route::get('/pdf2', array('as' => 'pdf2', 'uses' => 'PlanoController@pdf2'));
	
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

// Rota desprotegida de autenticação
//--------------------------------------------->>
Route::get('/search', 'PlanoController@index')->name('search');
Route::post('/search', 'PlanoController@search');
Route::get('/view/{plano}', 'PlanoController@show');
//--------------------------------------------->>


//--------------------------------------------->>

	// Route::get('/registro', function () {
    // 	return view('auth.myRegister');
	// });

//--------------------------------------------->>

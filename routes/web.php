<?php

Route::group(['middleware' => 'auth'], function () {

	Route::get('/', function () {
    	return view('home');
	});

	Route::get('/home', function () {
    	return view('home');
	})->name('home');

	Route::group(['middleware' => 'roles', 'roles' =>['Professor']], function () {
		Route::resource('planos', 'PlanoController');
		Route::get('/planos/{plano}/edit_dados', 'PlanoController@edit_dados');	
		
		Route::resource('exames', 'ExameController', ['only' => ['store', 'update', 'destroy']]);
		Route::resource('planejamentoAulas', 'PlanejamentoAulaController', ['only' => ['store', 'update', 'destroy']]);
		Route::resource('planejamentoUnidades', 'PlanejamentoUnidadeController', ['only' => ['store', 'update', 'destroy']]);
		
		Route::get('/index_geral', 'PlanoController@index_geral')->name('geral');
		Route::get('/search_geral', 'PlanoController@search_geral');
		Route::get('/busca', 'PlanoController@buscar');

		Route::get('/planos/{plano}/exames', 'ExameController@exame');	
		Route::get('/planos/{plano}/planejamentos', 'PlanoController@index_planejamento');	
		Route::get('/planos/{plano}/metodologias', 'PlanoController@index_metodologia');	
		Route::get('/planos/{plano}/objetivos', 'PlanoController@index_objetivo');	
		Route::get('/planos/{plano}/avaliacoes', 'PlanoController@index_avaliacao');	

		Route::post('/planos/observacao', 'PlanoController@observacao');
		Route::post('/planos/objetivo', 'PlanoController@objetivo');
		Route::post('/planos/metodologia', 'PlanoController@metodologia');
		Route::post('/planos/avaliacao', 'PlanoController@avaliacao');
		Route::get('/planos/{plano}/export', 'PlanoController@export');
		Route::post('/planos/export', 'PlanoController@cpyPlano');
		Route::get('/planos/{plano}/view_pend', 'PlanoController@view_pend');
		Route::get('/planos/{plano}/expandir', array('as' => 'expandir', 'uses' => 'PlanoController@expandir'));

		Route::get('/ajax-category', 'PlanoController@category'); 
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
		Route::get('/disciplinas/{disciplina}/info', 'DisciplinaController@info')->name('info');
		Route::post('/disciplinas/ementa', 'DisciplinaController@ementa');
		Route::post('/disciplinas/conteudo', 'DisciplinaController@conteudo');
		Route::post('/disciplinas/bibliografiab', 'DisciplinaController@bibliografiab');
		Route::post('/disciplinas/bibliografiac', 'DisciplinaController@bibliografiac');

		Route::resource('feriados', 'FeriadoController', ['except'=> ['show']]);
		Route::get('/aprovacao', 'PlanoController@aprovacao')->name('aprovacao');
		Route::get('/aprovar/{plano}', 'PlanoController@aprovar');

		Route::get('/planos/{plano}/pendencia', 'PlanoController@pendencia');
		Route::post('/planos/registrarPendencia', 'PlanoController@registrarPendencia');
		Route::get('/ajax-semestre', 'FeriadoController@ajaxSemestre');
		Route::get('/ajax-trocas', 'TrocaController@ajaxSemestre');
		Route::get('/planos/{plano}/expandir', array('as' => 'expandir', 'uses' => 'PlanoController@expandir'));
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
	
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

// Rota desprotegida de autenticação
//--------------------------------------------->>
Route::get('/index', 'PlanoController@index')->name('search');
Route::get('/search', 'PlanoController@search');
Route::get('/view/{plano}', 'PlanoController@show');
//--------------------------------------------->>


//--------------------------------------------->>
	// Route::get('/registro', function () {
    // 	return view('auth.myRegister');
	// });
//--------------------------------------------->>

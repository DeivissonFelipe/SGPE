<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('home'));
});

//-------------------------------------------------------------------------------------->

// Home > Cursos
Breadcrumbs::register('curso', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Cursos', route('cursos.index'));
});

// Home > Cursos > Novo Curso
Breadcrumbs::register('ncurso', function($breadcrumbs){
    $breadcrumbs->parent('curso');
    $breadcrumbs->push('Novo Curso', route('cursos.create'));
});

// Home > Cursos > [Curso]
Breadcrumbs::register('cursoId', function($breadcrumbs, $cursoId){
    $breadcrumbs->parent('curso');
    $breadcrumbs->push($cursoId->nome, route('cursos.edit', $cursoId->id));
});

//-------------------------------------------------------------------------------------->

// Home > Departamentos
Breadcrumbs::register('departamento', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Departamentos', route('departamentos.index'));
});

// Home > Departamentos > Novo Departamento
Breadcrumbs::register('ndepartamento', function($breadcrumbs){
    $breadcrumbs->parent('departamento');
    $breadcrumbs->push('Novo Departamento', route('departamentos.create'));
});

// Home > Departamentos > [Departamento]
Breadcrumbs::register('departamentoId', function($breadcrumbs, $departamentoId){
    $breadcrumbs->parent('departamento');
    $breadcrumbs->push($departamentoId->sigla, route('departamentos.edit', $departamentoId->id));
});

//-------------------------------------------------------------------------------------->

// Home > Disciplina
Breadcrumbs::register('disciplina', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Disciplinas', route('disciplinas.index'));
});

// Home > Disciplina > Novo Disciplina
Breadcrumbs::register('ndisciplina', function($breadcrumbs){
    $breadcrumbs->parent('disciplina');
    $breadcrumbs->push('Nova Disciplina', route('disciplinas.create'));
});

// Home > Disciplina > [Disciplina]
Breadcrumbs::register('disciplinaId', function($breadcrumbs, $disciplinaId){
    $breadcrumbs->parent('disciplina');
    $breadcrumbs->push($disciplinaId->codigo, route('disciplinas.edit', $disciplinaId->id));
});

//-------------------------------------------------------------------------------------->

// Home > Feriados
Breadcrumbs::register('feriado', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Feriados', route('feriados.index'));
});

// Home > Feriados > Novo Feriado
Breadcrumbs::register('nferiado', function($breadcrumbs){
    $breadcrumbs->parent('feriado');
    $breadcrumbs->push('Novo Feriado', route('feriados.create'));
});

// Home > Feriados > [Feriado]
Breadcrumbs::register('feriadoId', function($breadcrumbs, $feriadoId){
    $breadcrumbs->parent('feriado');
    $breadcrumbs->push($feriadoId->data, route('feriados.edit', $feriadoId->id));
});

//-------------------------------------------------------------------------------------->

// Home > Semestres
Breadcrumbs::register('semestre', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Semestres', route('semestres.index'));
});

// Home > Semestres > Novo Semestre
Breadcrumbs::register('nsemestre', function($breadcrumbs){
    $breadcrumbs->parent('semestre');
    $breadcrumbs->push('Nova Semestre', route('semestres.create'));
});

// Home > Semestres > [Semestre]
Breadcrumbs::register('semestreId', function($breadcrumbs, $semestreId){
    $breadcrumbs->parent('semestre');
    $breadcrumbs->push($semestreId->rotulo, route('semestres.edit', $semestreId->id));
});

//-------------------------------------------------------------------------------------->

// Home > Substituições
Breadcrumbs::register('substituicao', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Substituições', route('trocas.index'));
});

// Home > Substituições > Nova Substituição
Breadcrumbs::register('nsubstituicao', function($breadcrumbs){
    $breadcrumbs->parent('substituicao');
    $breadcrumbs->push('Nova Substituição', route('trocas.create'));
});

// Home > Substituições > [substituicao]
Breadcrumbs::register('substituicaoId', function($breadcrumbs, $troca){
    $breadcrumbs->parent('substituicao');
    $breadcrumbs->push($troca->dia, route('trocas.edit', $troca->id));
});

//-------------------------------------------------------------------------------------->

// Home > Planos
Breadcrumbs::register('plano', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Planos', route('planos.index'));
});

// Home > Planos > [plano]
Breadcrumbs::register('planoId', function($breadcrumbs, $planoId){
    $breadcrumbs->parent('plano');
    $breadcrumbs->push($planoId->turma->disciplina->codigo, route('planos.show', $planoId->id));
});

// Home > Planos > [plano] > Edição
Breadcrumbs::register('planoEdit', function($breadcrumbs, $planoEdit){
    $breadcrumbs->parent('planoId', $planoEdit);
    $breadcrumbs->push('Edit', route('planos.edit', $planoEdit->id));
});

// Home > Planos > [plano] > Exportar
Breadcrumbs::register('planoExport', function($breadcrumbs, $planoExport){
    $breadcrumbs->parent('planoId', $planoExport);
    $breadcrumbs->push('Exportação');
});

// Home > Planos > [plano] > Edição > Pendência
Breadcrumbs::register('planoPend', function($breadcrumbs, $planoPend){
    $breadcrumbs->parent('planoEdit', $planoPend);
    $breadcrumbs->push('Pendência');
});

// Home > Planos > [plano] > Edição > Exame
Breadcrumbs::register('planoExame', function($breadcrumbs, $planoExam){
    $breadcrumbs->parent('planoEdit', $planoExam);
    $breadcrumbs->push('Exame');
});

// Home > Planos > [plano] > Edição > Avaliação
Breadcrumbs::register('planoAvaliac', function($breadcrumbs, $planoAvaliac){
    $breadcrumbs->parent('planoEdit', $planoAvaliac);
    $breadcrumbs->push('Avaliação');
});

// Home > Planos > [plano] > Edição > Planejamento
Breadcrumbs::register('planoPlan', function($breadcrumbs, $planoPlan){
    $breadcrumbs->parent('planoEdit', $planoPlan);
    $breadcrumbs->push('Planejamento');
});

// Home > Planos > [plano] > Edição > Metodologia
Breadcrumbs::register('planoMetod', function($breadcrumbs, $planoMetod){
    $breadcrumbs->parent('planoEdit', $planoMetod);
    $breadcrumbs->push('Metodologia');
});

// Home > Planos > [plano] > Edição > Objetivo
Breadcrumbs::register('planoObjt', function($breadcrumbs, $planoObjt){
    $breadcrumbs->parent('planoEdit', $planoObjt);
    $breadcrumbs->push('Objetivo');
});

//-------------------------------------------------------------------------------------->

// Home > Aprovação
Breadcrumbs::register('aprovacao', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Aprovação', route('aprovacao'));
});

// Home > Aprovação
Breadcrumbs::register('aprv_pend', function($breadcrumbs, $planoPend){
	$breadcrumbs->parent('aprovacao');
	$breadcrumbs->push($planoPend->turma->disciplina->codigo);
});

//-------------------------------------------------------------------------------------->

// Pesquisa
Breadcrumbs::register('search', function($breadcrumbs){
    $breadcrumbs->push('Pesquisa', route('search'));
});

// Pesquisa > [plano]
Breadcrumbs::register('search_plano', function($breadcrumbs, $plano){
    $breadcrumbs->parent('search');
    $breadcrumbs->push($plano->turma->disciplina->codigo);
});

//-------------------------------------------------------------------------------------->

// Home > Geral
Breadcrumbs::register('geral', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Geral', route('geral'));
});

// Home > Geral > [plano]
Breadcrumbs::register('show', function($breadcrumbs, $planoId){
    $breadcrumbs->parent('geral');
    $breadcrumbs->push($planoId->turma->disciplina->codigo, route('planos.show', $planoId->id));
});


// Home > Novo Plano
Breadcrumbs::register('nplano', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Novo Plano', route('planos.create'));
});


// Home > Disciplina > Info
Breadcrumbs::register('info', function($breadcrumbs, $disciplina){
   $breadcrumbs->parent('disciplina');
   $breadcrumbs->push('info: '. $disciplina->codigo, route('info', $disciplina->id));
});


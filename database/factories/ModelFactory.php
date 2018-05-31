<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'matricula' => $faker->randomNumber(6),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Role::class, function (Faker\Generator $faker) {
    $roles = ['Admin', 'Professor'];
    return [
        'name' => $faker->randomElement($roles),
        'description' => $faker->sentence(),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Curso::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name,
        'sigla' => $faker->unique()->word,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Departamento::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name,
        'sigla' => $faker->unique()->word(),
    ];
});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Disciplina::class, function (Faker\Generator $faker) {
    $departamentos = App\Departamento::pluck('id')->toArray();
    return [
        'codigo' => $faker->unique()->word,
        'nome' => $faker->name,
        'name' => $faker->name,
        'chsemestral' => $faker->numberBetween('1', '72'),
        'chsemanalp' => $faker->numberBetween('1', '4'),
        'chsemanalt' => $faker->numberBetween('1', '4'),
        'departamento_id' => $faker->randomElement($departamentos),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Turma::class, function (Faker\Generator $faker) {
    $disciplinas = App\Disciplina::pluck('id')->toArray();
    $semestres = App\Semestre::pluck('id')->toArray();
    $cursos = App\Curso::pluck('id')->toArray();
    return [
        'disciplina_id' => $faker->randomElement($disciplinas),
        'semestre_id' => $faker->randomElement($semestres),
        'curso_id' => $faker->randomElement($cursos),
        'tipo_turma' => $faker->randomElement(array('0','1')),
        'numero_turma' => $faker->numberBetween($min = 10, $max = 99),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Plano::class, function (Faker\Generator $faker) {
    $turmas = App\Turma::pluck('id')->toArray();
    return [
        'tipo' => $faker->randomElement(array('0','1')),
        'turma_id' => $faker->randomElement($turmas),
        'status' => 'Em Edição',
        'observacoes' => $faker->text($maxNbChars = 200),
        'ementa' => $faker->text($maxNbChars = 200),
        'conteudo' => $faker->text($maxNbChars = 200),
        'objetivo' => $faker->text($maxNbChars = 200),
        'metodologia' => $faker->text($maxNbChars = 200),
        'bibliografiab' => $faker->text($maxNbChars = 200),
        'bibliografiac' => $faker->text($maxNbChars = 200),
        'avaliacao' => $faker->text($maxNbChars = 200),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Semestre::class, function (Faker\Generator $faker) {
    return [
        'rotulo' => $faker->unique()->word, 
        'inicio' => $faker->dateTimeBetween('now', '+2 years'),
        'fim' => $faker->dateTimeBetween('now', '+2 years'),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Feriado::class, function (Faker\Generator $faker) {
    $semestres = App\Semestre::pluck('id')->toArray();
    return [
        'data' => $faker->dateTimeBetween('now', '+2 years'),
        'semestre_id'  => $faker->randomElement($semestres),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Troca::class, function (Faker\Generator $faker) {
    $dias = ['Segunda-Feira','Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira'];
    $semestres = App\Semestre::pluck('id')->toArray();
    return [
        'dia' => $faker->dateTimeBetween('now', '+2 years'),
        'substituicao' => $faker->randomElement($dias),
        'semestre_id'  => $faker->randomElement($semestres),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Atendimento::class, function(Faker\Generator $faker){
    $dias = ['Segunda-Feira','Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira'];
    $planos = App\Plano::pluck('id')->toArray();
    return [
        'dia' => $faker->randomElement($dias),
        'inicio' => $faker->time($format = 'H:i'),
        'fim' => $faker->time($format = 'H:i'),
        'sala' => $faker->word,
        'plano_id' => $faker->randomElement($planos),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Exame::class, function (Faker\Generator $faker) {
    $planos = App\Plano::pluck('id')->toArray();
    return [
        'descricao' => $faker->sentence(),
        'peso' => $faker->numberBetween('1', '50'),
        'data' => $faker->dateTimeBetween('now', '+2 years'),
        'conteudo' => $faker->sentence(),
        'plano_id' => $faker->randomElement($planos),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Horario::class, function (Faker\Generator $faker) {
    $planos = App\Plano::pluck('id')->toArray();
    return [
        'dia' => $faker->dateTimeBetween('now', '+2 years'),
        'inicio' => $faker->time($format = 'H:i'),
        'fim' => $faker->time($format = 'H:i'),
        'plano_id' => $faker->randomElement($planos),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Pendencia::class, function (Faker\Generator $faker) {
    $planos = App\Plano::pluck('id')->toArray();
    return [
        'pendencia' => $faker->text($maxNbChars = 200),
        'plano_id' => $faker->randomElement($planos),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\PlanejamentoAula::class, function (Faker\Generator $faker) {
    $planos = App\Plano::pluck('id')->toArray();
    return [
        'aula' => $faker->numberBetween(1,40),
        'tipo' => $faker->randomElement(array('T', 'P', 'T/P')),
        'data' => $faker->dateTimeBetween('now', '+2 years'),
        'conteudo' => $faker->sentence,
        'plano_id' => $faker->randomElement($planos),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\PlanejamentoUnidade::class, function (Faker\Generator $faker) {
    $planos = App\Plano::pluck('id')->toArray();
    return [
        'unidade' => $faker->numberBetween(1, 100),
        'hora_aula' => $faker->numberBetween(1, 100),
        'descricao' => $faker->sentence,
        'plano_id' => $faker->randomElement($planos),
    ];
});


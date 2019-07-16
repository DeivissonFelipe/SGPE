# Sistema de Gerencimento de Planos de Ensino

O objetivo deste projeto é o desenvolvimento de um sistema Web destinado a
criação e gerenciamento dos planos de ensino do ICEA. Tal sistema visa proporcionar um ambiente mais interativo e prático, de modo a garantir a corretude dos dados.

O framework php utilizado neste trabalho foi o Laravel 5.4. Além de manter o código limpo e simples o Laravel foi priorizado neste projeto devido a fácil adaptação aos padrões adotados pela implementação do Lightweight Directory Access Protocol ([LDAP](https://github.com/jpmoura/ldapi)). O Instituto de Ciências Exatas e Aplicadas ([ICEA](https://www.icea.ufop.br/)) utiliza desta tecnologia visando facilitar o processo de autenticação e recuperação de dados para os serviços que são mantidos no servidor do campus.

### Pré-requisitos

Será necessária a instalação do gerenciador de pacotes [Composer](https://getcomposer.org/), permitindo o gerenciamento de dependências de software php.
Caso não utilize uma plataforma de desenvolvimento web como por exemplo o [WampServer](http://www.wampserver.com/en/) ou o [Laravel Homestead](https://laravel.com/docs/5.6/homestead), o laravel prevê como pré-requisitos:

* PHP >= 7.1.3
* BCMath PHP Extension
* Ctype PHP Extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension

### Instalação

O comando `composer install` executa o download e configura as dependências necessárias para o funcionamento do projeto.

```
$ composer install
```

Se faz necessário a criação do arquivo `.env` na raiz do projeto, para configuração das informações de banco de dados, bem como outras variáveis de ambiente. Com o arquivo `.env` configurado execute os comandos abaixo:

```
$ php artisan migrate
$ php artisan key:generate
```

O Laravel utiliza de classes chamadas “migrations” para auxiliar no processo de criação e atualização do banco de dados durante a etapa de desenvolvimento.

## Executando os testes

Para a etapa de teste foi utilizada a biblioteca `php faker`, nativamente implementada nas dependências do Laravel, para a criação de dados randômicos, simulando o cenário real de uso do sistema. Os testes ficam localizados na pasta `./tests/` na raiz do projeto e são facilmente executados pelo comando:

```
$ .\vendor\bin\phpunit
```

## Tecnologias Utilizadas

* [Laravel](https://laravel.com/) - O framework php.
* [WampServer](http://www.wampserver.com/en/) - Plataforma de desenvolvimento web que provê as aplicações Apache, MySQL e PHP.
* [AdminLTE](https://adminlte.io/) - Template para criação do painel administrativo.

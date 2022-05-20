<?php

    //Import do arquivo de autoload, que fara as instancias do slim
    require_once('vendor/autoload.php');

    //Criando um objeto do slim chamado app, para configurar os EndPoints
    $app = new \Slim\App();

    //EndPoint: Requisição para listar todos os contatos
    $app->get('/contatos', function($request, $response, $args) {
        $response->write('Testando a API pelo GET');
    });

    //EndPoint: Requisição para os contatos pelo id
    $app->get('/contatos/{id}', function($request, $response, $args) {

    });

    //EndPoint: Requisição para inserir um novo contato
    $app->get('/contatos', function($request, $response, $args) {

    });

?>
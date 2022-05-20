<?php

    /*
     * $request - recebe dados do corpo da requisição (JSON, FORM/DATA, XML, ...)
     * $response - envia dados de retorno da API
     * $args - permite receber dados de atributos na API 
    */

    //Import do arquivo de autoload, que fara as instancias do slim
    require_once('vendor/autoload.php');

    //Criando um objeto do slim chamado app, para configurar os EndPoints
    $app = new \Slim\App();

    //EndPoint: Requisição para listar todos os contatos
    $app->get('/contatos', function($request, $response, $args) {

        require_once('../modulo/config.php');

        //import da controller de contatos que fará a busca de dados
        require_once('../controller/controllerContatos.php');

        //Solicita os dados para controller
        if ($dados = listarContato()) {

            //Realiza conversão do array para JSON
            if ($dadosJSON = createJSON($dados)) {
                //Caso exista dados a serem retornados,informamos o statusCode 200 e enviamo um JSON com todos os dados encontrados
                return $response   ->withStatus(200)
                                   ->withHeader('Content-Type', 'application/json') 
                                   ->write($dadosJSON);
            }
                
        } else {
            //retorna um statusCode que significa a requisição foi aceita, porém sem conteúdo de retorno
            return $response   ->withStatus(204);
                               
        }
            
            

        
        
    });

    //EndPoint: Requisição para os contatos pelo id
    $app->get('/contatos/{id}', function($request, $response, $args) {
        
        $id = $args['id'];

        require_once('../modulo/config.php');

        require_once('../controller/controllerContatos.php');

        if ($dados = buscarContato($id)) {

             //Realiza conversão do array para JSON
             if ($dadosJSON = createJSON($dados)) {
                //Caso exista dados a serem retornados,informamos o statusCode 200 e enviamo um JSON com todos os dados encontrados
                return $response   ->withStatus(200)
                                   ->withHeader('Content-Type', 'application/json') 
                                   ->write($dadosJSON);
            }
        } else {
            return $response   ->withStatus(204);
        }
        

    });

    //EndPoint: Requisição para inserir um novo contato
    $app->post('/contatos', function($request, $response, $args) {

    });
    
    //Executa os endpoints
    $app->run();

?>
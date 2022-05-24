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
        
        //Recebe o id do registro que devera ser retornado pela API (este id esta chegando pela variavel criada no endpoint)
        $id = $args['id'];

        require_once('../modulo/config.php');

        require_once('../controller/controllerContatos.php');

        if($dados = buscarContato($id)) {
             
            if (!isset($dados['idErro'])) {

             //Realiza conversão do array para JSON
             if ($dadosJSON = createJSON($dados)) {
                //Caso exista dados a serem retornados,informamos o statusCode 200 e enviamo um JSON com todos os dados encontrados
                return $response   ->withStatus(200)
                                   ->withHeader('Content-Type', 'application/json') 
                                   ->write($dadosJSON);
            }
            } else {
                $dadosJSON = createJSON($dados);
                return $response   ->withStatus(404)
                                    ->withHeader('Content-Type', 'application/json') 
                                    ->write('{"message": Dados invalidos, 
                                            "Erro": '.$dadosJSON.'}');
            }
        } else {
            return $response    ->withStatus(204);
                                
            } 

    });

    //EndPoint: Requisição para inserir um novo contato
    $app->post('/contatos', function($request, $response, $args) {

    });

    //EndPoint: Requisição para deletar um contato
    $app->delete('/contatos/{id}', function($request, $response, $args) {

        if(is_numeric($args['id'])) {
            
            //Recebe o id do registro que devera ser retornado pela API (este id esta chegando pela variavel criada no endpoint)
            $id = $args['id'];

            require_once('../modulo/config.php');
            require_once('../controller/controllerContatos.php');

            //busca o nome da foto para ser excluida na controller
            if ($dados = buscarContato($id)) {

                $foto = $dados['foto'];
                //Cria um array com o ID e o nome da foto a ser enviada para controller excluir o registro
                 $arrayDados = array (
                     "id"       => $id,
                     "foto"     => $foto 
                 );

                 //chama a função de excluir o contato encaminhando o array com a foto e o id
                 $resposta = excluirContato($arrayDados);
                 //Validação referente ao erro 5, que significa que o registro foi excluído do BD e a img não existia do server
                 if(is_bool($resposta) && $resposta == true) {
                    return $response    ->withStatus(200)
                                        ->withHeader('Content-Type', 'application/json')   
                                        ->write('{"message": "Registro excluído com sucesso"}');
                 } elseif(is_array($resposta) && isset($resposta['idErro'])) {
                    if($resposta['idErro'] == 5) {
                        return $response    ->withStatus(200)
                                            ->withHeader('Content-Type', 'application/json')   
                                            ->write('{"message": "Registro excluído com sucesso, porém houve um problema na exclusão da imagem na pasta do servidor"}');
                    } else {
                        $dadosJSON = createJSON($resposta);
                        return $response   ->withStatus(404)
                                            ->withHeader('Content-Type', 'application/json') 
                                            ->write('{"message": "Houve um problema na hora de excluir", 
                                                    "Erro": '.$dadosJSON.'}');
                    }
                    
                 }
            } else {
                return $response    ->withStatus(404)
                                    ->withHeader('Content-Type', 'application/json')   
                                    ->write('{"message": "O ID informado não existe na base dados"}');
            }

        } else {
            return $response    ->withStatus(404)
                                ->withHeader('Content-Type', 'application/json')   
                                ->write('{"message": "É obrigatorio informar um id em formato valido (número)"}');
        }
        


    });


    
    //Executa os endpoints
    $app->run();

?>
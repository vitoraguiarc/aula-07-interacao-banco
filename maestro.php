<?php
    /****************************************************************************
        * Objetivo: Arquivo de rota, para segmentar as ações encaminhadas pela View 
        * (dados de um form, listagem de dados, ação de excluir ou atualizar). Esse
        * arquivo será responsável por encaminhar as solicitações para a Controller
        * Autor: Vitor Aguiar
        * Data: 04/03/2022
        * Versão: 1.0
    *****************************************************************************/

    $action = (string) null;
    $component = (string) null;

    //validação para verificar se a requisição é um POST de formulário
    if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {

        //Recebendo dados via URL p/ saber quem tá solicitando e qual ação será realizada
        $component =  strtoupper($_GET['component']);
        $action = strtoupper($_GET['action']);


        //Estrutura condicional para validar quem esta solicitando algo para o maestro
        switch($component)
        {
            case 'CONTATOS';

                //Importar o arquivo da controller
                require_once('controller/controller-contatos.php');

                //Validação para qual ação será realizada
                if($action == 'INSERIR') {

                    if (isset($_FILES) && !empty($_FILES)) {
                        //Chama a função de inserir na controller
                        $resposta = inserirContato($_POST, $_FILES);
                    } else {
                        
                        $resposta = inserirContato($_POST, null);
                    }
                    
                    //Valida o tipo de dados que a controller retornou
                    if (is_bool($resposta)) /*Se for booleaan*/ {   

                        //Verificar se o retorno foi verdadeiro
                        if ($resposta) 
                            echo("<script>
                                    alert('Registro inserido com sucesso!!');
                                    window.location.href = 'index.php';
                                </script>");
                    
                    }   //Se o retorno for um array significa houve erro no processo de inserção
                        elseif (is_array($resposta))
                            echo("<script>
                                    alert('".$resposta['message']."');
                                    window.history.back();
                                </script>");
                                
                } elseif ($action == 'DELETAR') {
                    //Recebe o id do registro que devera ser excluído, este foi enviado pela url no link da imagem do excluir que foi acionado na index
                    $idContato = $_GET['id']; 
                    
                    $resposta = excluirContato($idContato);

                    if(is_bool($resposta)) 
                        echo("<script>
                                alert('Registro excluído com sucesso!!');
                                window.location.href = 'index.php';
                            </script>");
                     elseif (is_array($resposta))
                        echo("<script>
                                alert('".$resposta['message']."');
                                window.history.back();
                            </script>"); 
                    
                } elseif ($action == 'BUSCAR') {

                   //Recebe o id do registro que devera ser excluído, este foi enviado pela url no link da imagem do excluir que foi acionado na index
                   $idContato = $_GET['id']; 
                    
                   //Chama a função de excluir na controller
                   $dados = buscarContato($idContato);

                   //Ativa a utilização de variaveis de sessao no server
                   session_start();

                   //Guarda em uma variavel de sessao os dados que o BD retornou para a busca do ID
                   //OBS - essa variavel de sessão será utilizada na index.php, visando inserir os dados nas suas respectivas caixas de texto
                   $_SESSION['dadosContato'] = $dados;
                   
                   //utilizando o header tambem podemos chamar a index.php mas havera uma ação de carregamento no navegador
                   //header('location: index.php');
                   
                   // utilizando o require não havera um novo carregamento, apenas a importação da inde.php
                   require_once('index.php');
                } elseif ($action == 'EDITAR') {

                    //Recebe o id que foi encaminhado no action do form pela URL
                    $idContato = $_GET['id'];

                    //Chama a função de editar na controller
                    $resposta = atualizarContato($_POST, $idContato);

                    //Valida o tipo de dados que a controller retornou
                    if (is_bool($resposta)) /*Se for booleaan*/ {   

                        //Verificar se o retorno foi verdadeiro
                        if ($resposta) 
                            echo("<script>
                                    alert('Registro modificado com sucesso!!');
                                    window.location.href = 'index.php';
                                </script>");
                    
                    }   //Se o retorno for um array significa houve erro no processo de inserção
                        elseif (is_array($resposta))
                            echo("<script>
                                    alert('".$resposta['message']."');
                                    window.history.back();
                                </script>");
                }
                    
                
                
            break;

        }
    }


?>
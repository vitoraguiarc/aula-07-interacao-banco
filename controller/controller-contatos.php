<?php
    /******************************************************************* 
     * Objetivo: Arquivo responsavel pela manipulação de dados de contato
     * Obs: Este arquivo fara a ponte entre a view e a model
     * Autor: Vitor Aguiar   
     * Data: 25/02/2022
     * Versão: 1.0    
    *********************************************************************/

    //Função para receber dados da view e encaminhar para a model (Inserir)
    function inserirContato($dadosContato){
        if(!empty($dadosContato)){
            //Validação de caixa vazia pois esses elementos são obrigatórios no banco de dados
            if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail'])){
                
                //Criação do array de dados que será encaminhado a model para inserir no BD, é importante criar este array conforme as necessidades de manipulação do BD 
                //OBS: criar as chave do array conforme os nomes dos atributos do BD

                $arrayDados = array (
                    "nome"     => $dadosContato['txtNome'],
                    "telefone" => $dadosContato['txtTelefone'],
                    "celular"  => $dadosContato['txtCelular'],
                    "email"    => $dadosContato['txtEmail'],
                    "obs"      => $dadosContato['txtObs'],

                ); 

                //Require do arquivo da model que faz a conexão direta com o BD
                require_once('./model/bd/contato.php');
                //Função que recebe o array e passa ele pro BD
                if (insertContato($arrayDados))
                    return true;
                else
                    return array ('idErro' => 1, 
                                  'message' => 'Não foi posivel inserir os dados no Banco de Dados');

            }else
                return array ('idErro'  => 2,
                              'message' => 'Existem campos obrigatórios que não foram preenchidos');
        }
    }

    //Função para receber dados da view e encaminhar para a model (Atualizar)
    function atualizarContato(){
        
    }

    //Função para realizar a exclusão de um contato (Excluir)
    function excluirContato($id){
        
        //Validação para verificar se o id contem um numero valido
        if($id != 0 && !empty($id) && is_numeric($id)) {
            
            //Import do arquivo de contato
            require_once('./model/bd/contato.php');

            //Chama a função na model e valida se o retorno foi verdadeiro ou falso
            if(deleteContato($id))
                return true;
            else
                return array('idErro' => 3,
                             'message' => 'O banco de dados não pode excluir o registro.');
        
        } else 
            return array('idErro' => 4,
                             'message' => 'Não é possivel excluir um registro sem informar um id válido.');
    }

    //Função para solicitar os dados da model e encaminhar a lista de contatos p/ view (Listar)
    function listarContato(){
        //import do arquivo que vai buscar os dados no BD
        require_once('model/bd/contato.php');

        //chama a função q8e vai buscar os dados no BD
        $dados = selectAllContatos();

        if (!empty($dados))
            return $dados;
        else
            return false;
    }

    //Função para buscar um contato atraves do id do registro
    function buscarContato($id) {

        //validação para verificar se o id contem um numero valido
        if($id != 0 && !empty($id) && is_numeric($id)) {

            //import do arquivo de contato
            require_once('model/bd/contato.php');

            //chama a função na model que vai buscar no BD
            $dados = selectByIdContato($id);

            //valida se existem dados para serem devolvidos
            if(!empty($dados))
                return $dados;
            else
                return false;

        } else {
            return array('idErro' => 4,
                             'message' => 'Não é possivel excluir um registro sem informar um id válido.');
        }
    }


?>

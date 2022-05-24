<?php
    /******************************************************************* 
     * Objetivo: Arquivo responsavel pela manipulação de dados de contato
     * Obs: Este arquivo fara a ponte entre a view e a model
     * Autor: Vitor Aguiar   
     * Data: 25/02/2022
     * Versão: 1.0    
    *********************************************************************/

    //import do arquivo configuração do projeto
    require_once(SRC.'modulo/config.php');

    

    //Função para receber dados da view e encaminhar para a model (Inserir)
    function inserirContato($dadosContato, $file){

        $nomeFoto = (string) null;

        if(!empty($dadosContato)){
            //Validação de caixa vazia pois esses elementos são obrigatórios no banco de dados
            if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail']) && !empty($dadosContato['sltEstado'])){
                
                
                
                if ($file['fleFoto']['name'] != null) {

                    //import da função de upload
                    require_once('modulo/upload.php');
                    
                    //chama a função
                    $nomeFoto = uploadFile($file['fleFoto']);
                    
                    if (is_array($nomeFoto)) {
                        
                        return $nomeFoto;
                    }

                }

               
                
                
                //Criação do array de dados que será encaminhado a model para inserir no BD, é importante criar este array conforme as necessidades de manipulação do BD 
                //OBS: criar as chave do array conforme os nomes dos atributos do BD

                $arrayDados = array (
                    "nome"     => $dadosContato['txtNome'],
                    "telefone" => $dadosContato['txtTelefone'],
                    "celular"  => $dadosContato['txtCelular'],
                    "email"    => $dadosContato['txtEmail'],
                    "obs"      => $dadosContato['txtObs'],
                    "foto"     => $nomeFoto,
                    "idestado" => $dadosContato['sltEstado']

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
    function atualizarContato($dadosContato, $arrayDados){

        $statusUpload = (boolean) false;

        //Recebe o id enviado pelo arrayDados
        $id = $arrayDados['id'];

        //Recebe a foto enviada pelo arrayDados (nome da foto ja existente no BD)
        $foto = $arrayDados['foto'];

        //Recebe o objeto de array referente a nova foto que poderá ser enviada ao servidor
        $file = $arrayDados['file'];

        if(!empty($dadosContato)){
            //Validação de caixa vazia pois esses elementos são obrigatórios no banco de dados
            if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail']) ){
                
                //validação para garantir que o id seja valido
                if(!empty($id) && $id != 0 && is_numeric($id)) {

                    //validação para identificar se será enviado uma nova foto
                    if($file['fleFoto']['name'] != null) {

                        //import da função de upload
                        require_once('modulo/upload.php');
                        
                        //chama a função de upload para enviar para o servidor
                        $novaFoto = uploadFile($file['fleFoto']);
                
                    } else {
                        //permanece a mesma foto no banco
                        $novaFoto = $foto;
                        $statusUpload = true;
                    }

                    //Criação do array de dados que será encaminhado a model para inserir no BD, é importante criar este array conforme as necessidades de manipulação do BD 
                    //OBS: criar as chave do array conforme os nomes dos atributos do BD
                    $arrayDados = array (
                        "id"       => $id,
                        "nome"     => $dadosContato['txtNome'],
                        "telefone" => $dadosContato['txtTelefone'],
                        "celular"  => $dadosContato['txtCelular'],
                        "email"    => $dadosContato['txtEmail'],
                        "obs"      => $dadosContato['txtObs'],
                        "foto"     => $novaFoto,
                        "idestado" => $dadosContato['sltEstado']

                    ); 

                    //Require do arquivo da model que faz a conexão direta com o BD
                    require_once('./model/bd/contato.php');
                    //Função que recebe o array e passa ele pro BD
                    if (updateContato($arrayDados)) {
                        //validação para verificar se será necessario apagar a foto antiga
                        if($statusUpload) {
                            //apaga a foto antiga do servidor
                            unlink(DIRETORIO_FILE_UPLOAD.$foto);
                        }
                        
                        return true;
                    }else
                        return array ('idErro' => 1, 
                                      'message' => 'Não foi posivel atualizar os dados no Banco de Dados');
                } else
                    return array ('idErro'  => 4,
                                  'message' => 'Não é possivel editar um registro sem um ID válido ');

            } else
                return array ('idErro'  => 2,
                              'message' => 'Existem campos obrigatórios que não foram preenchidos');
        }
    }
    

    //Função para realizar a exclusão de um contato (Excluir)
    function excluirContato($arrayDados) {

        //Recebe o id do registro que será excluido
        $id = $arrayDados['id'];

        //Recebe o nome da foto que será excluida da pasta do servidor
        $foto = $arrayDados['foto'];
        
        //Validação para verificar se o id contem um numero valido
        if($id != 0 && !empty($id) && is_numeric($id)) {
            
            //Import do arquivo de contato
            require_once(SRC.'model/bd/contato.php');

            //import da constante
            // require_once('./modulo/config.php');

            //Chama a função na model e valida se o retorno foi verdadeiro ou falso
            if(deleteContato($id)) {
                //unlink() - função para apagar um arquivo de um diretorio
                //permite apagar a foto fisicamente do servidor

                if($foto != null) {
                    if(@unlink(SRC.DIRETORIO_FILE_UPLOAD.$foto))
                    return true;
                else
                    return array ('idErro'   => 5, 
                                  'message'  => 'O registro no Banco de Dados foi excluído com sucesso
                                  porem a imagem não foi excluída do diretorio do servidor'); 
                } else
                    return true;
                
            } else
                return array('idErro' => 3,
                             'message' => 'O banco de dados não pode excluir o registro.');
        
        } else 
            return array('idErro' => 4,
                             'message' => 'Não é possivel excluir um registro sem informar um id válido.');
    }

    //Função para solicitar os dados da model e encaminhar a lista de contatos p/ view (Listar)
    function listarContato(){
        //import do arquivo que vai buscar os dados no BD
        require_once(SRC.'model/bd/contato.php');

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
            require_once(SRC.'model/bd/contato.php');

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

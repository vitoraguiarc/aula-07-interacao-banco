<?php

    /******************************************************************* 
         * Objetivo: Arquivo responsavel em realizar upload de arquivos
         * Autor: Vitor Aguiar   
         * Data: 25/04/2022
         * Versão: 1.0    
    *********************************************************************/

    function uploadFile ($arrayFile) {

        //Import do arquivo para constantes
        require_once('modulo/config.php');

        $arquivo = $arrayFile;

        $sizeFile = (int) 0;
        $typeFile = (string) null;
        $nameFile = (string) null;
        $tempFile = (string) null;

        //validação para identificar se o arquivo existe é maior que 0 e possua uma extensão
        if ($arquivo['size'] > 0 && $arquivo['type'] != "") {
            
            $sizeFile = $arquivo['size']/1024; #Recupera o tamanho do arquivo que é em bytes e converte para kb
            $typeFile = $arquivo['type']; #Recupera o tipo do arquivo
            $nameFile = $arquivo['name']; #Recupera o nome do arquivo
            $tempFile = $arquivo['tmp_name']; #Recupera o nome do arquivo
            
            //Validação para permitir o upload apenas de arquivos até 5mb
            if ($sizeFile <= MAX_FILE_UPLOAD) {

                //Validação para permitir apenas as extensões validas
                if (in_array($typeFile, EXT_FILE_UPLOAD)) {

                    //Separa somente o nome do arquivo de sua extensão
                    $nome = pathinfo($nameFile, PATHINFO_FILENAME);

                    //Separa somente a extensão do arquivo
                    $extensao = pathinfo($nameFile, PATHINFO_EXTENSION);

                    //Existem diversos algoritimos para a criptografia de dados
                        # md5 ()
                        # sha1 ()
                        # hash ()
                    
                    //md5() gerando uma criptografia de dados
                    //uniqid gerando um id a sequencia numerica diferente tendo como base, configurações da maquina
                    //time() pega a hora:minuto:segundo que esta sendo feito o upload da foto
                    $nomeCripty = md5($nome.uniqid(time()));

                    //Montamos novamente o nome do arquivo com a extensão
                    $foto = $nomeCripty.".".$extensao;

                    //Envia o arquivo da pasta temporaria do apache para a pasta criada no projeto
                    if (move_uploaded_file($tempFile, DIRETORIO_FILE_UPLOAD.$foto)) {
                        return $foto;
                    } else {
                        return array ('idErro'  => 13,
                                  'message' => 'Não foi possível mover o arquivo para o servidor');    
                    }
                    
                } else {
                    return array ('idErro'  => 12,
                                  'message' => 'A extensão do arquivo selecionado não é permitida no upload');
                }

            } else {
                return array ('idErro'  => 10,
                              'message' => 'Tamanho de arquivo errado no upload');
            }
        
        } else {
                return array ('idErro'  => 11,
                              'message' => 'Não é possível realizar o upload sem um arquivo selecionado.');
        }

        
    }

?>
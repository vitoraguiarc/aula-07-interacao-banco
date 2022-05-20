<?php

    /******************************************************************* 
         * Objetivo: Arquivo responsavel pela criação de variaveis e constantes do projeto
         * Autor: Vitor Aguiar   
         * Data: 25/04/2022
         * Versão: 1.0    
    *********************************************************************/

    const MAX_FILE_UPLOAD = 5120; #Limitação de 5MB para upload de imagens
    const EXT_FILE_UPLOAD = array("image/jpg", "image/jpeg", "image/gif", "image/png");
    const DIRETORIO_FILE_UPLOAD = "arquivos/";

    define('SRC', $_SERVER['DOCUMENT_ROOT'].'/vitor/aula07/');

    #FUNÇÕES GLOBAIS PARA O PROJETO

    //Função para converter um array em JSON
    function createJSON($arrayDados) {

        //Verificação se o array possui dados
        if(!empty($arrayDados)) {
            //Configura o padrão da conversão para JSON
            header('Content-Type: application/json');
            $dadosJSON = json_encode($arrayDados);

            // json_encode() - array for json
            // json_decode - json for array

            return $dadosJSON;
        } else
            return false;
        
    }

?>

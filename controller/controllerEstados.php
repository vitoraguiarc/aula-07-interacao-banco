<?php

/******************************************************************* 
     * Objetivo: Arquivo responsavel pela manipulação de dados de contato
     * Obs: Este arquivo fara a ponte entre a view e a model
     * Autor: Vitor Aguiar   
     * Data: 10/05/2022
     * Versão: 1.0    
*********************************************************************/


    //import do arquivo configuração do projeto
    require_once('modulo/config.php');

    //Função para solicitar os dados da model e encaminhar a lista de contatos p/ view (Listar)
    function listarEstado(){
        //import do arquivo que vai buscar os dados no BD
        require_once('model/bd/estado.php');

        //chama a função q8e vai buscar os dados no BD
        $dados = selectAllEstados();

        if (!empty($dados))
            return $dados;
        else
            return false;
    }


?>
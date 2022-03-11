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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Recebendo dados via URL p/ saber quem tá solicitando e qual ação será realizada
        $component =  strtoupper($_GET['component']);
        $action = strtoupper($_GET['action']);

        //Estrutura condicional para validar quem esta solicitando algo para o maestro
        switch($component)
        {
            case 'CONTATOS';
            //Importar o arquivo da controller
            require_once('controller/controller-contatos.php');

            if($action == 'INSERIR')
                inserirContato($_POST);
            elseif($action == 'EDITAR')
                atualizarContato($_POST);
            break;
        }
    }


?>
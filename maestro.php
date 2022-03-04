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
        $action = $_GET['action'];

        //Estrutura condicional para validar quem esta solicitando algo para o maestro
        switch($component)
        {
            case 'CONTATOS';
            echo('chamando a controller de contatos');
            break;
        }
    }


?>
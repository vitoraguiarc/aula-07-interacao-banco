<?php

    /********************************************************************************
    *  Objetivo: Arquivo principal da API que irá receber a URL requisitada e rediricionar para as APIs
    *  Data: 19/05/2022
    *  Autor: Vitor Aguiar
    *  Versão: 1.0
    ********************************************************************************/ 

    //Permite ativar quais endereços de sites que poderão fazer requisições na API (* Libera para todos os sites)
    header('Access-Control-Allow-Origin: *');

    //Permite ativar os metodos do protocolo HTTP que irao requisitar a API
    header('Acess-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

    //Permite ativar o Content-Type das requisições (Formato de dados que será utilizado (JSON, XML, FORM/DATA, ...))
    header('Acess-Control-Allow-Header: Content-Type');

    //Permite liberar quais content-types serão utilizados na API
    header('Content-Type: application/json');

    //Recebe a URl digitada na requisição
    $urlHTTP = (string) $_GET['url'];
    
    //Converte a url requisitada em um array para dividir as opções de busca que é separada pela "/"
    $url = explode('/', $urlHTTP);
  
    //Verifica qual a API será encaminhada a requisição (contatos, estados, etc)
    switch (strtoupper($url[0])) {
        case 'CONTATOS':

            require_once('contatosAPI/index.php');
            break;
        case 'ESTADOS':
            require_once('estadosAPI/index.php');
            break;
    }

?>
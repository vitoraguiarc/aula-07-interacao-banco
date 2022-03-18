<?php

/******************************************************************* 
     * Objetivo: Arquivo responsavel por manipular os dados dentro do BD (insert, update, select e delete)
     * Autor: Vitor Aguiar    
     * Data: 11/03/2022
     * Versão: 1.0    
*********************************************************************/
//Import do arquivo que estabelece a conexão com o BD
require_once('conexaoMysql.php');

//Função para realizar o insert no BD
function insertContato($dadosContato) {
    
    //Abre a conexão com o BD
    $conexao = conexaoMysql();

    //Monta o script para enviar os dados
    $sql = "insert into tblcontato
                (nome,
                 telefone,
                 celular,
                 email,
                 obs)
            values
                ('".$dadosContato['nome']."',
                '".$dadosContato['telefone']."',
                '".$dadosContato['celular']."',
                '".$dadosContato['email']."',
                '".$dadosContato['obs']."'); ";
    
        
    //Executa o scriipt no BD
    //Validação para verificar se o script esta correto
    if (mysqli_query($conexao, $sql)) {
        return true;

        //Validação para verificar se uma linha foi acrescentada no BD
        if (mysqli_affected_rows($conexao))
            return true;
        else
            return false;
    }  
    else
        return false;  
}

//Função para realizar o update no BD
function updateContato() {
    

}

//Função para deletar no BD
function deleteContato() {
    

}

//Função para listar todos os contatos no BD
function selectAllContatos() {
    
    //Abre a conexão
    $conexao = conexaoMysql();

    $sql = "select from tblcontato";
    $result = mysqli_query($conexao, $sql);

    if ($result)
    {   
        // mysqli_fetch_assoc() - permite converter os dados do bd em um array para manipulação no PHP
        // nesta repetição estamos, convertendo os dados do BD em um array ($rsDados), além de o próprio while conseguir gerenciar a qtde de vezes que devera ser feita a repetiçao
        $cont = 0;
        while ($rsDados = mysqli_fetch_assoc($result)) {

            //Cria um array com os dados do BD
            $arrayDados[$cont] = array (
                "nome"       => $rsDados['nome'],
                "telefone"   => $rsDados['telefone'],
                "celular"    => $rsDados['celular'],
                "email"      => $rsDados['email'],
                "obs"        => $rsDados['obs']
            );
            $cont++;
        }

        return $arrayDados;
    }
}

?>
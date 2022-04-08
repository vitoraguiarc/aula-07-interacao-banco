<?php

/******************************************************************* 
     * Objetivo: Arquivo responsavel por manipular os dados dentro do BD (insert, update, select e delete)
     * Autor: Vitor Aguiar    
     * Data: 11/03/2022
     * Versão: 1.0    
*********************************************************************/
//Import do arquivo que estabelece a conexão com o BD
require_once('conexao-my-sql.php');

//Função para realizar o insert no BD
function insertContato($dadosContato) {
    
    //Declaração de varaiavel para utilização no return desta função
    $statusResposta = (boolean) false;

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

        //Validação para verificar se uma linha foi acrescentada no BD
        if (mysqli_affected_rows($conexao)) 
            $statusResposta = true; 
       
        fecharConexaoMysql($conexao);
        return $statusResposta;
    } 
        
    
        
}

//Função para realizar o update no BD
function updateContato($dadosContato) {
    
    //Declaração de varaiavel para utilização no return desta função
    $statusResposta = (boolean) false;

    //Abre a conexão com o BD
    $conexao = conexaoMysql();

    //Monta o script para enviar os dados
    $sql = "update tblcontato set
                 nome     = '".$dadosContato['nome']."',
                 telefone = '".$dadosContato['telefone']."',
                 celular  = '".$dadosContato['celular']."',
                 email    = '".$dadosContato['email']."',
                 obs      = '".$dadosContato['obs']."' 
            
            where idcontato =".$dadosContato['id'];

            
            
            
               
    //Executa o scriipt no BD
    //Validação para verificar se o script esta correto
    if (mysqli_query($conexao, $sql)) {

        //Validação para verificar se uma linha foi acrescentada no BD
        if (mysqli_affected_rows($conexao)) 
            $statusResposta = true; 
       
        fecharConexaoMysql($conexao);
        
        return $statusResposta;
    } 
        

}

//Função para deletar no BD
function deleteContato($id) {

    //Declaração de varaiavel para utilização no return desta função
    $statusResposta = (boolean) false;

    //Abre a conexão
    $conexao = conexaoMysql();

    //Script para deletar um registro do BD
    $sql = "delete from tblcontato where idcontato =".$id;
    
    //Valida se o script esta correto, sem erro de sintaxe e executa no BD
    if(mysqli_query($conexao, $sql))
        //Valida se o BD teve sucesso na execução do excript 
        if(mysqli_affected_rows($conexao))
            $statusResposta = true;

    fecharConexaoMysql($conexao);
    return $statusResposta;

}

//Função para listar todos os contatos no BD
function selectAllContatos() {
    
    //Abre a conexão
    $conexao = conexaoMysql();

    $sql = "select * from tblcontato order by idcontato desc";
    $result = mysqli_query($conexao, $sql);

    if ($result)
    {   
        // mysqli_fetch_assoc() - permite converter os dados do bd em um array para manipulação no PHP
        // nesta repetição estamos, convertendo os dados do BD em um array ($rsDados), além de o próprio while conseguir gerenciar a qtde de vezes que devera ser feita a repetiçao
        $cont = 0;
        while ($rsDados = mysqli_fetch_assoc($result)) {

            //Cria um array com os dados do BD
            $arrayDados[$cont] = array (
                "id"         => $rsDados['idcontato'],
                "nome"       => $rsDados['nome'],
                "telefone"   => $rsDados['telefone'],
                "celular"    => $rsDados['celular'],
                "email"      => $rsDados['email'],
                "obs"        => $rsDados['obs']
            );
            $cont++;
        }

        //Solicita o fechamento da conexão com o BD
        fecharConexaoMysql($conexao);

        return $arrayDados;
    }
}

//Função para buscar um contato no BD atraves do ID
function selectByIdContato($id) {

    //Abre a conexão
    $conexao = conexaoMysql();

    $sql = "select * from tblcontato where idcontato =".$id;

    //Executa o script sql no BD e guarda o retorno dos dados, se houver
    $result = mysqli_query($conexao, $sql);

    if ($result)
    {   
        // mysqli_fetch_assoc() - permite converter os dados do bd em um array para manipulação no PHP
        // nesta repetição estamos, convertendo os dados do BD em um array ($rsDados), além de o próprio while conseguir gerenciar a qtde de vezes que devera ser feita a repetiçao
    
        if ($rsDados = mysqli_fetch_assoc($result)) {

            //Cria um array com os dados do BD
            $arrayDados = array (
                "id"         => $rsDados['idcontato'],
                "nome"       => $rsDados['nome'],
                "telefone"   => $rsDados['telefone'],
                "celular"    => $rsDados['celular'],
                "email"      => $rsDados['email'],
                "obs"        => $rsDados['obs']
            );
            
        }

        //Solicita o fechamento da conexão com o BD
        fecharConexaoMysql($conexao);

        return $arrayDados;
    }

}

?>
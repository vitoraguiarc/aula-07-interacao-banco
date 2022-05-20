<?php

/******************************************************************* 
     * Objetivo: Arquivo responsavel por manipular os dados dentro do BD (insert, update, select e delete)
     * Autor: Vitor Aguiar    
     * Data: 10/05/2022
     * Versão: 1.0    
*********************************************************************/

//import da conexão
require_once('ConexaoMySql.php');

//Função para listar todos os estados no BD
function selectAllEstados() {
    
    //Abre a conexão
    $conexao = conexaoMysql();

    $sql = "select * from tblestados order by nome asc";

    $result = mysqli_query($conexao, $sql);

    if ($result)
    {   
        // mysqli_fetch_assoc() - permite converter os dados do bd em um array para manipulação no PHP
        // nesta repetição estamos, convertendo os dados do BD em um array ($rsDados), além de o próprio while conseguir gerenciar a qtde de vezes que devera ser feita a repetiçao
        $cont = 0;
        while ($rsDados = mysqli_fetch_assoc($result)) {

            //Cria um array com os dados do BD
            $arrayDados[$cont] = array (
                "idestado"         => $rsDados['idestado'],
                "sigla"       => $rsDados['sigla'],
                "nome"   => $rsDados['nome']
            );
            $cont++;
        }

        //Solicita o fechamento da conexão com o BD
        fecharConexaoMysql($conexao);

        if (isset($arrayDados)) {
            return $arrayDados;
        } else
            return false;
        
    }
}

?>
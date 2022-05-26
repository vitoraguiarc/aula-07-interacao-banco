<?php
    //import do arquivo de configurações do projeto
    require_once('./modulo/config.php');

    //variavel que tem como finalidade diferenciar no action do form qual será a action encaminhada para a router (inserir ou editar)
    $form = (string) "maestro.php?component=contatos&action=inserir";

    //variavel para carregar o nome da foto do banco de dados
    $foto = (string) null;

    //variavel para ser utilizada no carregar dos estados (opção de editar)
    $idestado = (string) null;

    //Valida se a utilização de variaveis de sessão esta ativa no servidor
    if(session_status()) {

        //Valida se a variavel de sessão dadosContato não esta vazia
        if(!empty($_SESSION['dadosContato'])) {

            $id       = $_SESSION['dadosContato']['id'];
            $nome     = $_SESSION['dadosContato']['nome'];
            $telefone = $_SESSION['dadosContato']['telefone'];
            $celular  = $_SESSION['dadosContato']['celular'];
            $email    = $_SESSION['dadosContato']['email'];
            $obs      = $_SESSION['dadosContato']['obs'];
            $foto      = $_SESSION['dadosContato']['foto'];
            $idestado = $_SESSION['dadosContato']['idestado'];
            

            //Mudando o action para editar
            $form = "maestro.php?component=contatos&action=editar&id=".$id."&foto=".$foto;

            //Destroi uma variavel da memoria do servidor
            unset($_SESSION['dadosContato']);

        }

    }
        
?>

<!DOCTYPE>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title> Cadastro </title>
        <link rel="stylesheet" type="text/css" href="css/style.css">


    </head>
    <body>
       
        <div id="cadastro"> 
            <div id="cadastroTitulo"> 
                <h1> Cadastro de Contatos </h1>
                
            </div>
            <div id="cadastroInformacoes">
                 <form  action="<?=$form?>" name="frmCadastro" method="post" enctype="multipart/form-data"> 
                 <!-- /*sem o enctype não é possivel enviar arquivos do form em html para o servidor  */ -->
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Nome: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="text" name="nome" value="<?=isset($nome)?$nome:null?>" placeholder="Digite seu Nome" maxlength="100">
                            <!-- isset($nome)?$nome:null - if ternario  -->
                        </div>
                    </div>

                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Estado: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <select name="estado" id="">
                                <option value="">Selecione um item</option>
                                <?php
                                    //import da controller de estados
                                     require_once('controller/controllerEstados.php');
                                     //chama a função para carregar todos os estados no banco
                                     $listEstados = listarEstado();
                   
                                         foreach ($listEstados as $item) {

                                             ?>
                                                <option <?=$idestado==$item['idestado']?'selected':null ?> value="<?=$item['idestado']?>"><?=$item['sigla']?></option>
                                             <?php
                                         }
                                
                                ?>
                            </select>
                        </div>
                    </div>
                                     
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Telefone: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="telefone" value="<?=isset($telefone)?$telefone:null?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Celular: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="celular" value="<?=isset($celular)?$celular:null?>">
                        </div>
                    </div>
                   
                    
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Email: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="email" name="email" value="<?=isset($email)?$email:null?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Escolha um arquivo: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="file" name="foto" accept=".jpg, .png, .jpeg, .gif" >
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Observações: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <textarea name="obs" cols="50" rows="7"><?=isset($obs)?$obs:null?></textarea>
                        </div>
                    </div>
                    <div class="campos">
                        <img src="<?=DIRETORIO_FILE_UPLOAD.$foto?>" alt="">
                    </div>
                    
                    <div class="enviar">
                        <div class="enviar">
                            <input type="submit" name="btnEnviar" value="Salvar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="consultaDeDados">
            <table id="tblConsulta" >
                <tr>
                    <td id="tblTitulo" colspan="6">
                        <h1> Consulta de Dados.</h1>
                    </td>
                </tr>
                <tr id="tblLinhas">
                    <td class="tblColunas destaque"> Nome </td>
                    <td class="tblColunas destaque"> Celular </td>
                    <td class="tblColunas destaque"> Email </td>
                    <td class="tblColunas destaque"> Foto </td>
                    <td class="tblColunas destaque"> Opções </td>
                </tr>
                
               <?php
                    require_once('./controller/controllerContatos.php');
                    $listContatos = listarContato();

                    if($listContatos) {
                    
                        foreach ($listContatos as $item)
                        {
                            $foto = $item['foto'];
               ?>
                    <tr id="tblLinhas">
                        <td class="tblColunas registros"><?=$item['nome']?></td>
                        <td class="tblColunas registros"><?=$item['celular']?></td>
                        <td class="tblColunas registros"><?=$item['email']?></td>
                        <td class="tblColunas registros"><img src="<?=DIRETORIO_FILE_UPLOAD.$foto?>" class="foto"></td>
                        
                    
                        <td class="tblColunas registros">

                                <a href="maestro.php?component=contatos&action=buscar&id=<?=$item['id']?>">
                                    <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                                </a>
                                
                                <a onclick="return confirm('Deseja realmente excluir o contato <?=$item['nome']?>?')" href="maestro.php?component=contatos&action=deletar&id=<?=$item['id']?>&foto=<?=$foto?>">
                                    <img src="img/trash.png" alt="Excluir" title="Excluir" class="excluir" >
                                </a>

                                <img src="img/search.png" alt="Visualizar" title="Visualizar" class="pesquisar">
                        </td>
                    </tr>
                <?php
                    }
                    
                    
                }
                ?>
            </table>
        </div>
    </body>
</html>
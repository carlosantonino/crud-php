<?php 
    require_once 'classe-pessoa.php';
    $p = new Pessoa("crudpdo","localhost","root","");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Crud php</title>
</head>
<body>
    <?php 
    if(isset($_POST['nome'])) 
        // clicou no botao cadastrar ou editar
        {
            // --------------EDITAR------------------------------
            if(isset($_GET['id_up']) && !empty($_GET['id_up'])) 
            /** 
             * isset($_GET['id_up']): isset() 
             * é uma função PHP que verifica se uma variável ou um elemento de matriz está definido. 
             * Neste caso, está sendo verificado se o parâmetro GET chamado 'id_up' está presente na 
             * URL. Se estiver presente, o valor retornado será verdadeiro (true); caso contrário, 
             * será falso (false).             * 
            */
            {
            $id_upd = addslashes($_GET['id_up']); //  Isso acessa o parâmetro GET chamado 'id_up', que foi passado na URL 
            // e addslashes() função do PHP para tratamento de string
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);

            if (!empty($nome) && !empty($telefone) && !empty($email)) // Verifica se nome , telefone e email
            // foram passados com valor diferente de vazio
            {
                // EDITAR
                $p->atualizarDados($id_upd, $nome, $telefone, $email); // Se condição satisfaz então
                // executa a função atualizarDados e vai para o index.php
                header("location: index.php");

            }
                else
                
                    { // Se não satistez a condição cai nessa mensagem
                        ?>
                        <div class="aviso">
                            <img src="aviso.png">
                            <h4>Preencha todos os campos</h4> <!-- Mensagem que aparece na tela -->
                        </div>
                        <?php
                    }

            }
            // -------------------CADASTRAR ---------------------
            else 
            {
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);

            if (!empty($nome) && !empty($telefone) && !empty($email))
            {
                if(!$p-> cadastrarPessoa($nome, $telefone, $email))
                    {
                        ?>
                        <div class="aviso">
                            <h4>Email ja esta cadastrado!</h4>
                        </div>
                       
                        <?php
                    }
            }
                else
                
                    {
                        ?>
                        <div class="aviso">
                            <img src="aviso.png">
                            <h4>Preencha todos os campos</h4>
                        </div>
                        
                        <?php
                    }

            }
                    
        }    
   ?>
   <?php 
        if(isset($_GET['id_up'])) // se a pessoa clicou no editar
        {
            $id_update = addslashes($_GET['id_up']);
            $res = $p->buscarDadosPessoa($id_update);

        }
   ?>

    <section id="esquerda">
        <form method="POST">
            <h2>CADASTRAR PESSOA</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];}?>">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" value="<?php if(isset($res)){echo $res['telefone'];}?>">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php if(isset($res)){echo $res['email'];}?>">
            <input type="submit" value="<?php if(isset($res)) {echo "Atualizar";} else {echo "Cadastrar";} ?>">
        </form>
    </section>

    <section id="direita">
        
        <table>
            <tr id="titulo">
                <td>NOME</td>
                <td>TELEFONE</td>
                <td colspan="2">EMAIL</td>
            </tr>
        <?php 
            $dados = $p->buscarDados();
            if(count($dados) > 0) // se tem pessoas cadastradas
            {
                for ($i=0; $i < count($dados); $i++) 
                { 
                    echo "<tr>";
                    foreach ($dados[$i] as $k => $v)
                    {
                        
                        if($k != "id")
                        {
                            echo "<td>".$v."</td>";
                        }
                    }
                    ?>
                    <td>
                        <a href="index.php?id_up=<?php echo $dados[$i]['id']; ?>">Editar</a>
                        <a href="index.php?id=<?php echo $dados[$i]['id']; ?>">Excluir</a>
                    </td>
                    <?php
                    echo "</tr>";
                }
                

            } 
            else
            {
             ?>

        </table>
        
        <div class="aviso">
            <h4>Ainda nao há pessoas cadastradas</h4>
        </div>
    
    <?php

}
?>

    </section>
    
</body>
</html>

<?php 
    if(isset($_GET['id']))
    {
        $id_pessoa = addslashes($_GET['id']);
        $p->excluirPessoa($id_pessoa);
        header("location:index.php");
    }
?>

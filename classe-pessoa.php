<?php

Class Pessoa {

    private $pdo;
    // 6 funcoes
    // conexao com o banco de dados
    public function __construct($dbname, $host, $user, $senha)
    {
        try {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
        } catch (PDOException $e) {
            echo "Erro com banco de dados: " . $e->getMessage();
            exit();
        }catch (Exception $e) {
            //throw $th;
            echo "Erro generico: ". $e->getMessage();
            exit();

    } 
    }
   
     // funcao colocar para buscar dados e colocar no canto direito 
    public function buscarDados()
    {
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }



// Aqui vai o script para cadastrar pessoa ----------------------

    public function cadastrarPessoa($nome, $telefone, $email)
    {
    //antes de cadastrar verificar se ja tem o email cadastrado
    $cmd = $this->pdo->prepare("SELECT id from pessoa WHERE email = :e");
    $cmd -> bindValue(":e",$email);
    $cmd->execute();
    if($cmd->rowCount() > 0) // email ja existe no banco
    
    {
        return false;

    } else // nao foi encontrado o email
    {
        $cmd = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        return true;
    }

}


// ============= excluir dados ===========================================

public function excluirPessoa($id) 
{
    $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
    $cmd->bindValue(":id", $id);
    $cmd->execute();
}

// ======================= editar =======================================
// buscar dados de uma pessao
public function buscarDadosPessoa($id)
{
    $res = array();
    $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
    $cmd->bindValue(":id", $id);
    $cmd->execute();
    $res = $cmd->fetch(PDO::FETCH_ASSOC);
    return $res;
}

// atualizar dados no banco de dados

public function atualizarDados($id, $nome, $telefone, $email)
{
    // antes de atualizar, vericar se email ja esta cadastrado
  
    $cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
    $cmd->bindValue(":n",$nome);
    $cmd->bindValue(":t",$telefone);
    $cmd->bindValue(":e",$email);
    $cmd->bindValue(":id",$id);
    $cmd->execute();
    
   
}

}
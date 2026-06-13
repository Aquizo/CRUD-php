<?php
    $nome = "";
    $telefone = "";
    $email = "";
    $senha = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $host = "localhost";
        $db = "projetoweb";
        $user = "root";
        $pass = "";

        try {
           $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           $id = $_POST['id'];

           $sql = "SELECT * FROM usuarios where id = :id";
           $stmt = $pdo->prepare($sql);
           $stmt->bindParam(':id',$id, PDO::PARAM_INT);

           $stmt->execute();

           $row = $stmt->fetch(PDO::FETCH_ASSOC);

           if($row){
            $nome = $row['nome'];
            $telefone = $row['telefone'];
            $email = $row['email'];
            $senha = $row['senha'];
           } else {
                $nome = "";
                $telefone = "";
                $email = "";
                $senha = "";
           }
        } catch(PDOExcepetion $e){
            echo "Erro: " . $e->getMessage();
        }
    } else {
        echo "Conexão não estabelecida";
    }        
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa e atualização</title>
</head>
<body>
    <h2>Atualizar cadastro</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <p>
            ID: <input type="text" name="id">
            <input type="submit" value="Pesquisar">
        </p>
    </form>
<hr>
<?php
    if(!empty($nome)){
?>
    <form method="post" action="">
        <p>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
        </p>
        Nome: <br><p><input type="text" name="nome" value="<?php echo $nome; ?>"></p>
        Telefone: <br><p><input type="text" name="telefone" value="<?php echo $telefone; ?>"></p>
        Email: <p><input type="email" name="email" value="<?php echo $email; ?>"></p>
        Senha: <p><input type="password" name="senha" value="<?php echo $senha; ?>"></p>
        <p><input type="submit" value="Atualizar usuário"></p>
    </form>
<?php
    }
?>
</body>
</html>
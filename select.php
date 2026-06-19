<?php

session_start();

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.html");
    exit();
}

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

        $pdo = new PDO(
            "mysql:host=$host;dbname=$db",
            $user,
            $pass
        );

        $pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        $id = $_POST['id'];

        $sql = "SELECT * FROM usuarios WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            $nome = $row['nome'];
            $telefone = $row['telefone'];
            $email = $row['email'];
            $senha = $row['senha'];
        } else {
    echo "<p>Usuário não encontrado.</p>";
}

    } catch(PDOException $e){
        echo "Erro: " . $e->getMessage();
    }

// } else {

//     echo "Conexão não estabelecida";

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pesquisa e atualização</title>
</head>
<body>
<nav class="navbar">
  <ul class="nav-links">
    <li><a href="form.html">Formulário</a></li>
    <li><a href="login.html">Login</a></li>
    <li><a href="select.php">Atualizar</a></li>
    <li><a href="delete.html">Delete</a></li>
  </ul>
</nav>
<div class="login-wrapper">
    
        <p>Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?>!</p>
        <a href="logout.php">Sair</a>
        <h2>Pesquisa e Atualização</h2>
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <p>
                    ID: <input type="number" name="id" required>
                    <input type="submit" value="Pesquisar">
                </p>
            </form>
        </div>
</div>
<hr>
<?php
    if(!empty($nome)){
?>
<div class="login-wrapper">
    <div class="login-card">
    <form method="post" action="update.php">
        <p>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
        </p>
        Nome: <br><p><input type="text" name="nome" value="<?php echo $nome; ?>"></p>
        Telefone: <br><p><input type="text" name="telefone" value="<?php echo $telefone; ?>"></p>
        Email: <p><input type="email" name="email" value="<?php echo $email; ?>"></p>
        Senha: <p><input type="password" name="senha" value="<?php echo $senha; ?>"></p>
        <p><input type="submit" value="Atualizar usuário"></p>
    </form>
    </div>
</div>
<?php
    }
?>
</body>

</html>
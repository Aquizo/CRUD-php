<?php

session_start();

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

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "
        SELECT *
        FROM usuarios
        WHERE email = :email
        AND senha = :senha
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);

    $stmt->execute();

    if($stmt->rowCount() > 0){

        $usuario = $stmt->fetch();

        $_SESSION['usuario_id'] =
            $usuario['id'];

        $_SESSION['usuario_nome'] =
            $usuario['nome'];

        header("Location: select.php");
        exit();

    } else {

        echo "Email ou senha inválidos.";

    }

}catch(PDOException $e){

    echo "Erro: ".$e->getMessage();

}
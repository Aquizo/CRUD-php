<?php

session_start();

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.html");
    exit();
}

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $host = "localhost";
        $db = "projetoweb";
        $user = "root";
        $pass = "";

        try {
           $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           $id = $_POST['id'];

           $sql = "DELETE FROM usuarios where id = :id";
           $stmt = $pdo->prepare($sql);
           $stmt->bindParam(':id',$id, PDO::PARAM_INT);

           if($stmt->execute()){
                echo 'Usuário excluído com sucesso';
           } else {
                echo 'Erro ao excluir usuário.';
           }
           

           
        } catch(PDOException $e){
            echo "Erro: " . $e->getMessage();
        }
    } else {
        echo "Conexão não estabelecida";
    }        

?>
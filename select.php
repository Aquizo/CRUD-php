<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

$nome = "";
$telefone = "";
$email = "";
$id = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $host = "localhost";
    $db = "projetoweb";
    $user = "root";
    $pass = "";

    try {

        $pdo = new PDO(
            "mysql:host=$host;dbname=$db;charset=utf8",
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

        if ($row) {

            $nome = $row['nome'];
            $telefone = $row['telefone'];
            $email = $row['email'];

        } else {

            echo "<p>Usuário não encontrado.</p>";

        }

    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();

    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa e Atualização</title>
    <link rel="stylesheet" href="style.css">
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

    <div class="login-card">

        <p>
            Bem-vindo,
            <?= htmlspecialchars($_SESSION['usuario_nome']); ?>!
        </p>

        <p>
            <a href="logout.php">Sair</a>
        </p>

        <h2>Pesquisa e Atualização</h2>

        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <p>
                <label for="id">ID do usuário</label><br>

                <input
                    type="number"
                    id="id"
                    name="id"
                    required
                >
            </p>

            <p>
                <button type="submit">
                    Pesquisar
                </button>
            </p>

        </form>

    </div>

</div>

<?php if (!empty($nome)) : ?>

<div class="login-wrapper">

    <div class="login-card">

        <h2>Atualizar Usuário</h2>

        <form method="post" action="update.php">

            <input
                type="hidden"
                name="id"
                value="<?= htmlspecialchars($id); ?>"
            >

            <p>
                <label for="nome">Nome</label><br>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    value="<?= htmlspecialchars($nome); ?>"
                    required
                >
            </p>

            <p>
                <label for="telefone">Telefone</label><br>

                <input
                    type="text"
                    id="telefone"
                    name="telefone"
                    value="<?= htmlspecialchars($telefone); ?>"
                    required
                >
            </p>

            <p>
                <label for="email">E-mail</label><br>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= htmlspecialchars($email); ?>"
                    required
                >
            </p>

            <p>
                <label for="senha">Nova senha</label><br>

                <input
                    type="password"
                    id="senha"
                    name="senha"
                    placeholder="Digite uma nova senha"
                >
            </p>

            <p>
                <button type="submit">
                    Atualizar Usuário
                </button>
            </p>

        </form>

    </div>

</div>

<?php endif; ?>

</body>

</html>

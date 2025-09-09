<?php

$mysqli = new mysqli("localhost", "root", "root", "futebol_db");
if ($mysqli->connect_errno) {
    die("Erro de conexão: " . $mysqli->connect_error);
}

session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST["username"] ?? "";
    $pass = $_POST["senha"] ?? "";

    $stmt = $mysqli->prepare("SELECT id, username, senha FROM usuarios WHERE username=? AND senha=?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    $dados = $result->fetch_assoc();
    $stmt->close();

    if ($dados) {
        $_SESSION["user_id"] = $dados["id"];
        $_SESSION["username"] = $dados["username"];
        header("Location: index.php");
        exit;
    } else {
        $msg = "Usuário ou senha incorretos!";
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Login Simples</title>
<link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>

<?php if (!empty($_SESSION["user_id"])): ?>
  <div class="card">
    <h3>Bem-vindo, <?= $_SESSION["username"] ?>!</h3>
    <p>Sessão ativa.</p>
    <p><a href="?logout=1">Sair</a></p>
    <?php

?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleção</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>
    <header>

    </header>

    <main class="centralizar flex">
<a href="../public/jogadores/read.php">
<button class="botoes_menu">
    <h1>Jogadores</h1>
</button>
</a>
<a href="../public/times/read.php">
<button class="botoes_menu">
    <h1>Times</h1>
</button>
</a>
<a href="../public/partidas/read.php">
    <button class="botoes_menu">
        <h1>Partidas</h1>
    </button>
</a>
    </main>

    <footer>

    </footer>
</body>
</html>

  </div>

<?php else: ?>
  <div class="card">
    <h3>Login</h3>
    <?php if ($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>
    <form method="post">
      <input type="text" name="username" placeholder="Usuário" required>
      <input type="senha" name="senha" placeholder="Senha" required>
      <button type="submit">Entrar</button>
    </form>
  </div>
<?php endif; ?>

</body>
</html>
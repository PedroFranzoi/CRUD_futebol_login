<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Excluir partida</title>
</head>
<body>
    <h2>Excluir Partida</h2>
    <p>Deseja realmente excluir a partida?</p>
    <form action="" method="post">
        <button type="submit">Excluir</button>
    </form>
    <a href="read.php">Voltar</a>
    
</body>
</html>
    <?php
        include '../../config/db.php';

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $stmt = $conn->prepare("DELETE FROM partidas WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                header("Location: read.php");
            }
        }else{
            header("Location: read.php");
        }
        
    ?>
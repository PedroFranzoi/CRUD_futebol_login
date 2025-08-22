<?php

include '../../config/db.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['nome'];
    $posicao = $_POST['posicao'];
    $numero = $_POST['numero_camisa'];

    $sql = "UPDATE jogadores SET nome ='$name', posicao= '$posicao', numero_camisa ='$numero' WHERE id=$id";

    if ($conn->query($sql) === true) {
        echo "Registro atualizado com sucesso.
        <a href='read.php'>Ver registros.</a>
        ";
    } else {
        echo "Erro " . $sql . '<br>' . $conn->error;
    }
    $conn->close();
    exit(); 
}

$sql = "SELECT * FROM jogadores WHERE id=$id";
$result = $conn -> query($sql);
$row = $result -> fetch_assoc();


?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update</title>
</head>

<body>

    <form method="POST" action="update.php?id=<?php echo $row['id_produto'];?>">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?php echo $row['nome'];?>" required>

        <label for="preco">Preço:</label>
        <input type="preco" name="preco" value="<?php echo $row['preco'];?>" required>

        <label for="descricao">Descrição:</label>
        <input type="descricao" name="descricao" value="<?php echo $row['descricao'];?>" required>

        <label for="quantidade_estoque">Quantidade:</label>
        <input type="quantidade_estoque" name="quantidade_estoque" value="<?php echo $row['quantidade_estoque'];?>" required>

        <input type="submit" value="Atualizar">

    </form>

    <a href="read.php">Ver registros.</a>

</body>

</html>
<?php

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['nome'];
    $posicao = $_POST['posicao'];
    $numero = $_POST['numero_camisa'];
    

    $sql = " INSERT INTO jogadores (nome,posicao,numero) VALUE ('$name','$posicao','$numero')";

    if ($conn->query($sql) === true) {
        echo "Novo jogador registrado criado com sucesso.";
    } else {
        echo "Erro " . $sql . '<br>' . $conn->error;
    }
    $conn->close();
}

?>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link rel="stylesheet" href="../styles.css">

</head>

<body>

<div class="centralizador">

    
    <div class="centro">
    <h1>Adicionar o Produto</h1>
     <form method="POST" action="create.php">
    <div class="flex">
        <label for="name">Nome:</label>
        <input type="text" name="name" required>

        <label for="posicao">Posição:</label>
        <input type="text" name="posicao" required>

        <label for="numero">Numero da Camisa:</label>
        <input type="number" name="numero">
    </div>
        <input id="botaoAdd" type="submit" value="Adicionar">
        <div>
            <a href="readJogador.php">Ver Registros</a>
        </div>
        
</div>

    </form>

</div>
    
</body>


</html>
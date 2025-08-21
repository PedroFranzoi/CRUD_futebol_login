<?php

include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['nome'];
    $posicao = $_POST['posicao'];
    $numero = $_POST['numero_camisa'];
    $time = $_POST['']; // não sei fazer, perguntar amanhã

    $sql = " INSERT INTO jogadores (nome,posicao,numero) VALUE ('$name','$posicao','$numero')";

    if($numero > 99 || $numero <= 0){
        echo "Coloque o numero da camisa do jogador de maneira correta(entre 1 e 99).";
    }else{
        if ($conn->query($sql) === true) {
            echo "Novo jogador registrado criado com sucesso.";
        } else {
            echo "Erro " . $sql . '<br>' . $conn->error;
        }
        $conn->close();
    }

    
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
        <select name="posicao" name="posicao">
            <option value="GOL">GOL</option>
            <option value="ZAG">ZAG</option>
            <option value="LE">LE</option>
            <option value="LD">LD</option>
            <option value="ALA-E">ALA-E</option>
            <option value="ALA-D">ALA-D</option>
            <option value="VOL">VOL</option>
            <option value="MC">MC</option>
            <option value="MEI">MEI</option>
            <option value="MD">MD</option>
            <option value="ME">ME</option>
            <option value="SA">SA</option>
            <option value="PD">PD</option>
            <option value="PE">PE</option>
            <option value="CA">CA</option>
        </select>

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
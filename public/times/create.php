<?php

include 'futebol_db';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $cidade = $_POST['cidade'];

    $sql = " INSERT INTO times (name, cidade) VALUE ('$name', '$cidade')";

    if ($conn->query($sql) === true) {
        echo "Novo time registrado criado com sucesso.";
    } else {
        echo "Erro " . $sql . '<br>' . $conn->error;
    }
    $conn->close();
}

?>


<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Times</title>
</head>

<body>

    <form method="POST" action="create.php">

        <label for="name">Nome:</label>
        <input type="text" name="name" required>
        <label for="cidade">Cidade:</label>
        <input type="text" name="cidade" required>



        <input type="submit" value="Adicionar time">

    </form>

</body>

</html>
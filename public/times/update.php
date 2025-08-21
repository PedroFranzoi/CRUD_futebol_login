<?php

include 'db.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $cidade = $_POST['cidade'];

    $sql = "UPDATE times SET name ='$name',cidade ='$cidade' WHERE id=$id";

    if ($conn->query($sql) === true) {
        echo "Time atualizado com sucesso.";
    } else {
        echo "Erro " . $sql . '<br>' . $conn->error;
    }
    $conn->close();
    exit(); 
}

$sql = "SELECT * FROM times WHERE id=$id";
$result = $conn -> query($sql);
$row = $result -> fetch_assoc();


?>


<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar times</title>
</head>

<body>

    <form method="POST" action="update.php?id=<?php echo $row['id'];?>">

        <label for="name">Nome:</label>
        <input type="text" name="name" value="<?php echo $row['name'];?>" required>

        <label for="cidade">Cidade:</label>
        <input type="text" name="cidade" value="<?php echo $row['cidade'];?>" required>

        <input type="submit" value="Atualizar time">

    </form>

</body>

</html>
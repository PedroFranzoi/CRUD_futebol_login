<?php

include '../../config/db.php';

$sqlTimes = "SELECT id, nome FROM times";
$resultTimes = $conn->query($sqlTimes);

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['nome'];
    $posicao = $_POST['posicao'];
    $numero = $_POST['numero_camisa'];
    $timeId = $_POST['time'];

    $sql = "UPDATE jogadores SET nome ='$name', time='$timeId', posicao= '$posicao', numero_camisa ='$numero' WHERE id=$id";


    if($numero > 99 || $numero <= 0){
        echo "Coloque o numero da camisa do jogador de maneira correta(entre 1 e 99).";
    }else{
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

    <form method="POST" action="update.php?id=<?php echo $row['id'];?>">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?php echo $row['nome'];?>" required>

        <label for="time">Time:</label>
        <select name="time">
            <?php while ($dado = $resultTimes->fetch_assoc()): ?>
                <option value="<?= $dado['id'] ?>" <?php if($row['time_id'] == $dado['id']){echo 'selected';} ?>><?= $dado['nome'] ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="posicao">Posição:</label>
        <select name="posicao" name="posicao">
            <option value="<?php echo $row['posicao'];?>" selected><?php echo $row['posicao'];?></option>
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

        <label for="numero_camisa">Numero da Camisa:</label>
        <input type="number" name="numero_camisa" value="<?php echo $row['numero_camisa'];?>" required>

        <input type="submit" value="Atualizar">

    </form>

    <a href="read.php">Ver registros.</a>

</body>

</html>

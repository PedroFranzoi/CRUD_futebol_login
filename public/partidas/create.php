<?php
include '../../config/db.php';

$sqlTimes = "SELECT id, nome FROM times";
$resultTimes = $conn->query($sqlTimes);
$resultTimes2 = $conn->query($sqlTimes);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idTimeCasa = $_POST["timeCasa"];
    $idTimeFora = $_POST["timeFora"];
    $dataPartida = $_POST["data"];
    $golsCasa = $_POST["golsCasa"];
    $golsFora = $_POST["golsFora"];

    if($idTimeCasa == $idTimeFora){
        echo 'Não é possível definir o mesmo time para Casa e para Fora!';
    }else if($golsCasa < 0 || $golsFora < 0){
        echo 'Não é possível definir valores negativos para a quantidade de gols!';
    }else{
        $stmt = $conn->prepare("INSERT INTO partidas (time_casa_id, time_fora_id, data_jogo, gols_casa, gols_fora) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisii", $idTimeCasa, $idTimeFora, $dataPartida, $golsCasa, $golsFora);
        if ($stmt->execute()) {
            header("Location: read.php");
        } else {
            echo "Erro ao cadastrar!";
        }
    }
    
}
?>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Registrar Partida</title>
</head>

<body>
    <h2>Registrar Partida:</h2>
    <form action="create.php" method="post">
        <label for="timeCasa">Time de Casa:</label>
        <select name="timeCasa">
        <?php while ($row = $resultTimes->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nome']) ?></option>
        <?php endwhile; ?>
        </select><br>
        <label for="timeFora">Time de Fora:</label>
        <select name="timeFora">
        <?php while ($row = $resultTimes2->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nome']) ?></option>
        <?php endwhile; ?>
        </select><br>
        <label for="data">Data da Partida:</label>
        <input type="date" name="data" id="data"> <br>
        <label for="golsCasa">Gols do time da Casa:</label>
        <input type="number" name="golsCasa" id="golsCasa"><br>
        <label for="golsFora">Gols do time de Fora:</label>
        <input type="number" name="golsFora" id="golsFora"><br>
        <button type="submit">Registrar Partida</button>
    </form>

</body>

</html>
<?php
include '../../config/db.php';

$sqlTimes = "SELECT id, nome FROM times WHERE 1=1";
$resultTimes = $conn->query($sqlTimes);

$sql = "SELECT timeCasa.nome AS nomeCasa, timeFora.nome AS nomeFora, data_jogo, gols_casa, gols_fora FROM partidas INNER JOIN times timeCasa ON partidas.time_casa_id = timeCasa.id INNER JOIN times timeFora ON partidas.time_fora_id = timeFora.id";

if (isset($_GET['id_time']) && $_GET['id_time'] != '') {
    $idTime = $_GET['id_time'];
    $sql .= " AND ( partidas.time_casa_id = $idTime OR partidas.time_fora_id = $idTime )";
}

if(isset($_GET['data_inicial']) && $_GET['data_inicial'] != '' && isset($_GET['data_final']) && $_GET['data_final'] != ''){
    $data_inicial = $_GET['data_inicial'];
    $data_final = $_GET['data_final'];
    $sql .= " AND ( partidas.data_jogo >= '$data_inicial' AND partidas.data_jogo <= '$data_final' )";
}

if (isset($_GET['ganhou']) && $_GET['ganhou'] != '') {
    $ganhador = $_GET['ganhou'];
    if($ganhador == 'casa'){
        $sql .= " AND ( partidas.gols_casa > partidas.gols_fora )";
    }
    if($ganhador == 'fora'){
        $sql .= " AND ( partidas.gols_casa < partidas.gols_fora )";
    }
    
}

$result = $conn->query($sql);
?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partidas</title>
</head>
<body>
    <form method="get">
        <h3>Filtros:</h3>
        <label>Time:</label>
        <select name="id_time">
            <option></option>
            <?php foreach ($resultTimes as $time): ?>
                <option value="<?= $time['id'] ?>" <?php if(isset($_GET['id_time'])){if($_GET['id_time'] == $time['id']){echo 'selected';}} ?>><?= $time['nome'] ?></option>
            <?php endforeach; ?>
        </select><br>
        <label>Data inicial:</label>
        <input type="date" value="<?php if(isset($_GET['data_inicial'])){echo $_GET['data_inicial'];} ?>" name="data_inicial" id="dataInicial"><br>
        <label>Data final:</label>
        <input type="date"  value="<?php if(isset($_GET['data_final'])){echo $_GET['data_final'];} ?>" name="data_final" id="dataFinal"><br>
        <label>Ganhador:</label>
        <select name="ganhou">
            <option></option>
            <option value="casa" <?php if(isset($_GET['ganhou'])){if($_GET['ganhou'] == 'casa'){echo 'selected';}} ?>>Casa</option>
            <option value="fora" <?php if(isset($_GET['ganhou'])){if($_GET['ganhou'] == 'fora'){echo 'selected';}} ?>>Fora</option>
        </select><br>
        <button type="submit">Filtrar</button>
    <a href="read.php">Remover Filtros</a>
</form>
    
</body>
</html>

<?php



if($result->num_rows > 0){

    echo "<table border = '1'>
        <tr>
            <th> Time de Casa </th>
            <th> Time de Fora </th>
            <th> Data da Partida </th>
            <th> Gols (Time de Casa) </th>
            <th> Gols (Time de Fora) </th>
        </tr>
    ";

    while($row = $result->fetch_assoc()){

        echo "<tr>
                <td> {$row['nomeCasa']} </td>
                <td> {$row['nomeFora']} </td>
                <td> {$row['data_jogo']} </td>
                <td> {$row['gols_casa']} </td>
                <td> {$row['gols_fora']} </td>
            </tr>
        ";
    }
    echo "</table>";
}else{
    echo "Nenhuma partida encontrada.";    
}
echo "<a href='create.php'>Registrar partida</a>";

$conn -> close();

?>
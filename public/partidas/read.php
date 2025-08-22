<?php
include '../../config/db.php';

function buildQueryString($exclude = []) {
    $params = $_GET;
    foreach ($exclude as $param) {
        unset($params[$param]);
    }
    return http_build_query($params);
}

$sqlTimes = "SELECT id, nome FROM times WHERE 1=1";
$resultTimes = $conn->query($sqlTimes);

$sql = "SELECT partidas.id AS id_partida, timeCasa.nome AS nomeCasa, timeFora.nome AS nomeFora, data_jogo, gols_casa, gols_fora FROM partidas INNER JOIN times timeCasa ON partidas.time_casa_id = timeCasa.id INNER JOIN times timeFora ON partidas.time_fora_id = timeFora.id";

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

$pagina = 0;
$registroPorPagina = 10;
$resultado = mysqli_query($conn, $sql);
$num_linhas = mysqli_num_rows($resultado);
$total_paginas = $num_linhas / $registroPorPagina;
$total_paginas = ceil($total_paginas);

if($resultado->num_rows > 0){
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];
}
if($pagina < 0){
    $pagina = 0;
}

if($pagina >= $total_paginas){
    $pagina = $total_paginas - 1;
}

$paginaAnterior = $pagina -1;
$paginaPosterior = $pagina +1;

$index = $pagina * $registroPorPagina;

$sql .= " LIMIT $index, $registroPorPagina";

$result = $conn->query($sql);
}


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
        <button type="submit">Atualizar</button>
    <a href="read.php">Remover Filtros</a>
</form>
    


<?php



if($resultado->num_rows > 0){
    $paginaExibida = $pagina + 1;
    $queryBase = buildQueryString(['pagina']);

$paginaAnteriorLink = "?$queryBase&pagina=$paginaAnterior";
$paginaPosteriorLink = "?$queryBase&pagina=$paginaPosterior";

echo "<a href='$paginaAnteriorLink'>Anterior</a> ";
echo "<a href='$paginaPosteriorLink'>Próxima</a>";
echo "<br> Página $paginaExibida de $total_paginas";
echo "<br> Total de $num_linhas resultados";

    echo "<table border = '1'>
        <tr>
            <th> Time de Casa </th>
            <th> Time de Fora </th>
            <th> Data da Partida </th>
            <th> Gols (Time de Casa) </th>
            <th> Gols (Time de Fora) </th>
            <th> Ações </th>
        </tr>
    ";

    while($row = $result->fetch_assoc()){

        echo "<tr>
                <td> {$row['nomeCasa']} </td>
                <td> {$row['nomeFora']} </td>
                <td> {$row['data_jogo']} </td>
                <td> {$row['gols_casa']} </td>
                <td> {$row['gols_fora']} </td>
                <td>
                    <a href='update.php?id={$row['id_partida']}'>Atualizar</a>
                    <a href='delete.php?id={$row['id_partida']}'>Deletar</a>
                </td>
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
</body>
</html>


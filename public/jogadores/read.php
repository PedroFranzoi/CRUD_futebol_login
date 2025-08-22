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

$sql = "SELECT jogadores.id AS id_jogador, times.nome AS nomeTime, jogadores.nome AS nome_jogador, posicao, numero_camisa FROM jogadores INNER JOIN times ON jogadores.time_id = times.id WHERE 1=1";

if (isset($_GET['nome_jogador']) && $_GET['nome_jogador'] != '') {
    $nome_jogador = $_GET['nome_jogador'];
    $sql .= " AND ( jogadores.nome = '$nome_jogador' )";
}

if (isset($_GET['id_time']) && $_GET['id_time'] != '') {
    $idTime = $_GET['id_time'];
    $sql .= " AND ( jogadores.time_id = $idTime )";
}

if (isset($_GET['posicao']) && $_GET['posicao'] != '') {
    $posicao = $_GET['posicao'];
    $sql .= " AND ( posicao = '$posicao' )";
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
    <title>Jogadores</title>
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
        <label>Nome do Jogador:</label>
        <input type="text" value="" name="nome_jogador" id="nome_jogador"><br>
        <label for="posicao">Posição:</label>
        <select name="posicao" name="posicao">
            <option></option>
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
            <th> Nome </th>
            <th> Posição </th>
            <th> Numero da Camisa </th>
            <th> Time </th>
        </tr>
    ";
    while($row = $result->fetch_assoc()){

        echo "<tr>
                <td> {$row['nome_jogador']} </td>
                <td> {$row['posicao']} </td>
                <td> {$row['numero_camisa']} </td>
                <td> {$row['nomeTime']} </td>
                <td>
                    <a href='update.php?id={$row['id_jogador']}'>Atualizar</a>
                </td>
                <td>
                    <a href='delete.php?id={$row['id_jogador']}'>Deletar</a>
                </td>
            </tr>
        ";
    }
    echo "</table>";
}else{
    echo "Nenhum jogador encontrado.";    
}
echo "<a href='create.php'>Registrar jogador</a>";

$conn -> close();

?>
</body>
</html>


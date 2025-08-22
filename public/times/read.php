<?php

include '../../config/db.php';

function buildQueryString($exclude = []) {
    $params = $_GET;
    foreach ($exclude as $param) {
        unset($params[$param]);
    }
    return http_build_query($params);
}


$sql = "SELECT * FROM times WHERE 1=1 ";

if (isset($_GET['nome_time']) && $_GET['nome_time'] != '') {
    $nome_time = $_GET['nome_time'];
    $sql .= " AND ( nome = '$nome_time' )";
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
        <label>Nome do Time:</label>
        <input type="text" value="" name="nome_time" id="nome_time"><br>
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
    echo "<table border ='1'>
        <tr>
            <th> ID </th>
            <th> Nome </th>
            <th> Cidade </th>
            <th> Editar Times </th>
            <th> Deletar Times </th>
            </tr>
            <a href='../times/create.php' >Criar times<a>
         ";

    while ($row = $result->fetch_assoc()) {

        echo "<tr>
                    <td> {$row['id']} </td>
                    <td> {$row['nome']} </td>
                    <td> {$row['cidade']} </td>
                    <td> <a href='update.php?id={$row['id']}'> Editar </a> </td>
                    <td> <a href='delete.php?id={$row['id']}'> Deletar </a></td>
                </tr>"
                ;
    }
    echo "</table>";
} else {
    echo "Nenhum Registro de Time Encontrado.";
    echo "<a href='create.php'>Criar Registro de Time</a>";
}

$conn -> close();
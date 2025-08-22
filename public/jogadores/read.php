<?php

include '../../config/db.php';


$sql = "SELECT * FROM jogadores";

$sql = "SELECT jogadores.id AS id_jogador, times.nome AS nomeTime, jogadores.nome AS nome_jogador, posicao, numero_camisa FROM jogadores INNER JOIN times ON jogadores.time_id = times.id";

$result = $conn->query($sql);

if($result->num_rows > 0){

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
                    <a href='update.php?id={$row['id_jogador']}'>Utualizar</a>
                </td>
                <td>
                    <a href='delete.php?id={$row['id_jogador']}'>Deletar</a>
                </td>
            </tr>
        ";
    }
    echo "</table>";
    echo "<a href='create.php'>Criar Registro</a>";
}else{
    echo "Nenhum Jogador Registrado.";
    echo "<a href='create.php'>Criar Registro</a>";
}

$conn -> close();

?>
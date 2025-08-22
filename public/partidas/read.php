<?php

include '../../config/db.php';

$sql = "SELECT timeCasa.nome AS nomeCasa, timeFora.nome AS nomeFora, data_jogo, gols_casa, gols_fora FROM partidas INNER JOIN times timeCasa ON partidas.time_casa_id = timeCasa.id INNER JOIN times timeFora ON partidas.time_fora_id = timeFora.id";
$result = $conn->query($sql);

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
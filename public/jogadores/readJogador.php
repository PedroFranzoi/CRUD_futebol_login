<?php

include '../../config/db.php';


$sql = "SELECT * FROM jogadores";

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
                <td> {$row['nome']} </td>
                <td> {$row['posicao']} </td>
                <td> {$row['numero_camisa']} </td>
                <td> {$row['time_id']} </td>
                <td> {$row['id_usuario']} </td>
                <td>
                    <a href='updateJogador.php?id={$row['id']}'>Utualizar</a>
                </td>
                <td>
                    <a href='deleteJogador.php?id={$row['id']}'>Deletar</a>
                </td>
            </tr>
        ";
    }
    echo "</table>";
    echo "<a href='create.php'>Criar Registro</a>";
}else{
    echo "Nenhum produto registrado.";
    echo "<a href='create.php'>Criar Registro</a>";
}

$conn -> close();

?>
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
                <td>
                    <a href='update.php?id={$row['id']}'>Utualizar</a>
                </td>
                <td>
                    <a href='delete.php?id={$row['id']}'>Deletar</a>
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
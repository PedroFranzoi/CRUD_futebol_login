<?php

include '../../config/db.php';



$sql = "SELECT * FROM times";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo "<table border ='1'>
        <tr>
            <th> ID </th>
            <th> Nome </th>
            <th> Cidade </th>
            <th> Editar Times </th>
            <th> Deletar Times </th>
            <a href='../times/create.php' >Criar times<a>
        </tr>
         ";

    while ($row = $result->fetch_assoc()) {

        echo "<tr>
                <td> {$row['id']} </td>
                <td> {$row['nome']} </td>
                <td> {$row['cidade']} </td>
                 <td>
                    <a href='../times/update.php' >Editar time<a>
                </td>
                <td>
                    <a href='../times/delete.php' >Deletar time<a
                </td>
                </tr>"
                ;
    }
    echo "</table>";
} else {
    echo "Nenhum Registro de Time Encontrado.";
    echo "<a href='create.php'>Criar Registro de Time</a>";
}

$conn -> close();
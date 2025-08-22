<?php

include '../../config/db.php';

$id = $_GET['id'];

$sql = "DELETE FROM times WHERE id=$id";
$sql = "SELECT * jogadores WHERE id <> '' ";

if ($conn->query($sql) === true) {
    echo "Time excluído com sucesso.";
} else{
     echo "Erro " . $sql . '<br>' . $conn->error;
}
$conn -> close();
exit();
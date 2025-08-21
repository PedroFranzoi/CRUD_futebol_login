<?php

include 'futebol_db';
include 'partidas';

$id = $_GET['id'];

$sql = " DELETE FROM times WHERE id=$id ";

if ($conn->query($sql) === true) {
    echo "Time excluído com sucesso.";
}else if(data_jogo === true){
    echo "Esse time há pendências, tire as pendências para deletá-lo." . $sql . '<br>' . $conn->error;
} else {
    echo "Erro " . $sql . '<br>' . $conn->error;
}
$conn -> close();
exit();
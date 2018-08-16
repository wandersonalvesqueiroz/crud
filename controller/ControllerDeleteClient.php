<?php include("../class/Client.php");

$clients = new Client();
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$clients->delete(
    "clients",
    "id=?",
    array($id)
);

echo 'Cliente removido com sucesso!';

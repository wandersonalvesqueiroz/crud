<?php include("../class/Client.php");

$clients = new Client();
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$clients->delete(
    "client_phone",
    "id=?",
    array($id)
);

echo 'Telefone removido com sucesso!';

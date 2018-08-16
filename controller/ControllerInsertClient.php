<?php

include('../includes/Variables.php');
include('../class/Client.php');

$clientInsert = new Client();

if ($action == 'insert'){

    $clientInsert->insert(
        'clients',
        '?,?,?,?,?',
        array($id, $name, $cpf, $email, $situation)
    );

    if (!empty($phone)) {
        $clientInsert->insertPhone($phone);
    }

    echo 'Cliente adicionado com sucesso!';

}else{

    $clientInsert->update(
        'clients',
        'name=?,cpf=?,email=?,situation=?',
        'id=?',
        array($name, $cpf, $email, $situation,$id)
    );

    if (!empty($phone)) {
        $clientInsert->insertPhone($phone,$id);
    }

    echo 'Cliente alterado com sucesso!';

}

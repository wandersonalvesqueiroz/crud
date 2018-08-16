<?php

if (isset($_POST['action'])) {
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
} elseif (isset($_GET['action'])) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $action = '';
}

if (isset($_POST['id'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
} elseif (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $id = 0;
}

if (isset($_POST['name'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
} elseif (isset($_GET['name'])) {
    $name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $name = '';
}

if (isset($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
} elseif (isset($_GET['email'])) {
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
} else {
    $email = '';
}

if (isset($_POST['cpf'])) {
    $cpf = str_replace('-', '',filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT));
} elseif (isset($_GET['cpf'])) {
    $cpf = str_replace('-', '',filter_input(INPUT_GET, 'cpf', FILTER_SANITIZE_NUMBER_INT));
} else {
    $cpf = '';
}

if (isset($_POST['situation'])) {
    $situation = filter_input(INPUT_POST, 'situation', FILTER_SANITIZE_NUMBER_INT);
} elseif (isset($_GET['situation'])) {
    $situation = filter_input(INPUT_GET, 'situation', FILTER_SANITIZE_NUMBER_INT);
} else {
    $situation = '';
}

if (isset($_POST['phone'])) {
    $phone = filter_input(INPUT_POST, 'phone', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
} elseif (isset($_GET['phone'])) {
    $phone = filter_input(INPUT_GET, 'phone', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
} else {
    $phone = '';
}
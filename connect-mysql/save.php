<?php

require 'connect_mysql.php';

function savePersonel($name, $surname, $email) {
    $conSave = connect();

    $ask = $conSave->prepare("INSERT INTO personel(name, surname, email) VALUES(?,?,?)");

    $ask->bind_param('sss', $name, $surname, $email);
    $ask->execute();

    if ($conSave->errno > 0) {
        die("<b>Sorgu Hatası:</b> " . $conSave->error);
        return "Kaydetme sırasında bir hata oluştu";
    }

    $ask->close();
    $conSave->close();
}

if (isset($_POST['name'], $_POST['surname'], $_POST['email'])) {

    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $surname = trim(filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    if (substr($name, 0, 1) == "a") {
        echo savePersonel("1$name", $surname, $email);
    } else {
        savePersonel("$name", $surname, $email);
    }

    header('location:index.php');
}
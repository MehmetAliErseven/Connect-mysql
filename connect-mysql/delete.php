<?php

function runQuery($query, $type, $var) {
    $connection = connect();
    $ask = $connection->prepare($query);

    $ask->bind_param($type, $var);
    $ask->execute();

    if ($connection->errno > 0) {
        die("<b>Sorgu Hatası:</b> " . $connection->error);
        return "Hata oluştu";
    }

    $ask->close();
    $connection->close();
}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    runQuery("DELETE from school.personel WHERE personal_id = ?", "i", $id);

    if ($id) {
        header('location:search_user.php');
    }
}
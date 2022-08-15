<?php

function connect () {
    $servername = "localhost";
    $username = "root";
    $password = "ma123456";
    $schema = "school";
    $port = "3306";

    $connect = new mysqli($servername, $username, $password, $schema, $port);

    if ($connect->connect_error) {
        die("Bağlantı hatası: " . $connect->connect_error);
    }

    $connect->set_charset("utf8mb4");

    return $connect;
}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        div {
            width: 60vw;
            display: flex;
            border: 1px solid lightgray;
            justify-content: flex-start;
        }
        .row {
            justify-content: center;
        }
    </style>
</head>
<body>
<form action="connect_mysql.php" method="post">
    Adınız:<br />
    <input type="text" name="name" required="required" /><br />
    Soyadınız:<br />
    <input type="text" name="surname" required="required" /><br />
    E-posta Adresiniz:<br />
    <input type="email" name="email" required="required" />
    <input type="submit" value="Send" />
</form>
<br>
<br>
<form action="connect_mysql.php" method="post">
    Ad:<br />
    <input type="text" name="nameSearch" required="required" /><br />
    Soyad:<br />
    <input type="text" name="surnameSearch" required="required" /><br />
    Id:<br />
    <input type="number" name="idSearch" required="required" />
    <input type="submit" value="Search" />
</form>

<?php

function connect () {
    $servername = "localhost";
    $username = "root";
    $password = "mali8179";
    $schema = "school";
    $port = "3306";

    $connect = new mysqli($servername, $username, $password, $schema, $port);

    if ($connect->connect_error) {
        die("Bağlantı hatası: " . $connect->connect_error);
    }

    $connect->set_charset("utf8mb4");

    return $connect;
}

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
    return "İşlem başarılı";

}

function savePersonel($name, $surname, $email) {
    $conSave = connect();

    $ask = $conSave->prepare("INSERT INTO personal(name, surname, email) VALUES(?,?,?)");

    $ask->bind_param('sss', $name, $surname, $email);
    $ask->execute();

    if ($conSave->errno > 0) {
        die("<b>Sorgu Hatası:</b> " . $conSave->error);
        return "Kaydetme sırasında bir hata oluştu";
    }


    $ask->close();
    $conSave->close();
    return "Başarıyla Kaydedildi";
}

function deletePersonel ($id) {
    runQuery("DELETE from personal WHERE personal_id = ?", "i", $id);
}

function searchPersonel ($nameSearch) {

    $connection = connect();

    $sql = "SELECT personal. personal_id, personal. name, personal. surname FROM school. personal WHERE personal. name = '$nameSearch'";

    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<div>
        <div class='row'>" . $row["personal_id"] . "</div>
        <div class='row'>" . $row["name"] . "</div>
        <div class='row'>" . $row["surname"] . "</div>
        </div>";
        }
    } else {
        echo "0 results";
    }
    $connection->close();
}

if (isset($_POST['name'], $_POST['surname'], $_POST['email'])) {

    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $surname = trim(filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    if (empty($name) || empty($surname) || empty($email)) {
        die("<p>Lütfen formu eksiksiz doldurun!</p>");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<p>Lütfen geçerli bir e-posta adresin girin!</p>");
    }

    if (substr($name, 0, 1) == "A") {
        echo savePersonel("1$name", $surname, $email);
    } else {
        savePersonel("$name", $surname, $email);
    }
}

if(isset($_POST['nameSearch'], $_POST['surnameSearch'], $_POST['idSearch'])) {
    $nameSearch = trim(filter_input(INPUT_POST, 'nameSearch', FILTER_SANITIZE_STRING));
    $surnameSearch = trim(filter_input(INPUT_POST, 'surnameSearch', FILTER_SANITIZE_STRING));
    $idSearch = trim(filter_input(INPUT_POST, 'idSearch', FILTER_SANITIZE_NUMBER_INT));

    if (empty($nameSearch) || empty($surnameSearch) || empty($idSearch)) {
        die("<p>Lütfen formu eksiksiz doldurun!</p>");
    } else {
        echo "<br>";
        echo "<br>";
        echo "<div>
        <div>Id</div>
        <div>Name</div>
        <div>Surname</div>
</div>";
        echo searchPersonel($nameSearch);
    }
}

?>

</body>
</html>
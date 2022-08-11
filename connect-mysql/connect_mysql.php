<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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

//deletePersonel ve savePersonel metodları içerisinde aynı şeyler kullanılmaktadır. Kod kalabalığı olmaması ve
// Clean code olması için bu metodların sadeleştirilmesi gerekiyor.
// runQuery adında bir  func olsun ve bu func query adında bir parametre alsın.
// bu parametreye göre veritabanı işlemini yapsın ve savePersonel ve deletePersonel funcları bu yeni
//yapılan runQuery funcunu kullanıın...

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
//ad veya soyad veya id parametresi girelim. bulduğu sonuçları ekranda listelesin.
// adı girince olsun sadece
// runqueryi kullan. searchPersonel isminde bir func olsun.
//ad, soyad, id parametreleri alsın ama şimdilik sadece ad ile sorgu yapsın.
// Trick : Select sorgusu yapacaksın.

function deletePersonel ($id) {
    runQuery("DELETE from personal WHERE personal_id = ?", "i", $id);
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
        echo savePersonel($name, $surname, $email);
    }
}

deletePersonel(3);

// Arif -> 1Arif
// Mali -> Mali
?>



</body>
</html>
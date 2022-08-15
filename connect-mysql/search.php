<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connect database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        table {
            margin-top: 5vh;
        }
    </style>
</head>
<body>
<table class="table text-center">
    <thead>
    <tr>
        <th scope="col">#Id</th>
        <th scope="col">Name</th>
        <th scope="col">Surname</th>
        <th scope="col">Email</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>

<?php
require 'connect_mysql.php';
require 'delete.php';

function searchPersonel($surnameSearch) {
    $connection = connect();
    $sql = "SELECT personel. personal_id, personel. name, personel. surname, personel. email FROM school. personel WHERE personel. surname = '$surnameSearch'";

    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row["personal_id"];
            $name = $row["name"];
            $surname = $row["surname"];
            $email = $row["email"];
            echo "<tr>
                    <th scope='row'>" . $id . "</th>
                    <td>" . $name . "</td>
                    <td>" . $surname . "</td>
                    <td>" . $email . "</td>
                    <td>
                        <a href='search.php?deleteid=" . $id . "' class='btn btn-primary btn-sm'>Delete</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr>
                <th scope='row'>0 Result!</th>
              </tr>";
    }
    $connection->close();
}

if(isset($_POST['nameSearch'], $_POST['surnameSearch'], $_POST['idSearch'])) {
    $nameSearch = trim(filter_input(INPUT_POST, 'nameSearch', FILTER_SANITIZE_STRING));
    $surnameSearch = trim(filter_input(INPUT_POST, 'surnameSearch', FILTER_SANITIZE_STRING));
    $idSearch = trim(filter_input(INPUT_POST, 'idSearch', FILTER_SANITIZE_NUMBER_INT));

    searchPersonel($surnameSearch);
}
?>
    </tbody>
</table>

</body>
</html>
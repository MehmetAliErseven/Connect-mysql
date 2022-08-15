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
        form {
            position: relative;
            top: 20vh;
        }
    </style>
</head>
<body>
<form method="post" action="save.php" class="container text-center">
    <div class="mb-3 col-3 mx-auto mt-5">
        <label for="exampleInputText1" class="form-label">Name</label>
        <input name="name" type="text" class="form-control" id="exampleInputText1" required="required">
    </div>
    <div class="mb-3 col-3 mx-auto">
        <label for="exampleInputText2" class="form-label">Surname</label>
        <input name="surname" type="text" class="form-control" id="exampleInputText2" required="required">
    </div>
    <div class="mb-4 col-3 mx-auto">
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required="required">
    </div>
    <button type="submit" class="btn btn-primary col-2">Save</button>
</form>
</body>
</html>
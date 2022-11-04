<?php
require("connect-db.php");
require("functions.php");

session_start();
if (isset($_COOKIE['user']))
{

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == 'Logout') {
        userLogout();
    }
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="login.css"> -->

    <title>Home</title>
    

</head>

<body>

    <div class="container">
        <h1> Welcome </h1>

        <form action="index.php" method="post">
             <input type = "submit" value="Logout" class = "btn btn-danger" name = "btnAction"
                      title="Logout(Placeholder)" />
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


<?php
} else {
    header('Location: login.php');
}
?>
</body>

</html>
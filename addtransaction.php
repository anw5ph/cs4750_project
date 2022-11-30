<?php
require("connect-db.php");
require("functions.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == 'Add Transaction') {
        addTransaction($_POST['userID'], $_POST['transID'], $_POST['name'], $_POST['description'], $_POST['flatAmount'], $_POST['period'], $_POST['numPayments'], $_POST['startDate']);
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

    <title>Add Transaction</title>
    

</head>

<body>

<div class="container">
    <div class="row align-items-center justify-content-center" style="min-height: 100vh">
        <div class="col-md-4">

            <form action="addtransaction.php" method="post">

                <h2 style="text-align: center; color: gray;">Add Transaction</h2>
                <br>

                <div class="form-outline mb-4">
                    <input type="number" step=1 name="userID" id="userID" class="form-control" placeholder="userID"/>
                </div>

                <div class="form-outline mb-4">
                    <input type="number" step=1 name="transID" id="transID" class="form-control" placeholder="transID"/>
                </div>
                
                <div class="form-outline mb-4">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name"/>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" name="description" id="description" class="form-control" placeholder="Description"/>
                </div>

                <div class="form-outline mb-4">
                    <input type="number" step=0.01 name="flatAmount" id="flatAmount" class="form-control" placeholder="Flat Amount"/>
                </div>
                
                <div class="form-outline mb-4">
                    <input type="number" step=1 name="period" id="period" class="form-control" placeholder="Period"/>
                </div>

                <div class="form-outline mb-4">
                    <input type="number" step=1 name="numPayments" id="numPayments" class="form-control" placeholder="Number of Payments"/>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" name="startDate" id="startDate" class="form-control" placeholder="Start Date"/>
                </div>

                <button type="submit" value = "Add Transaction" name="btnAction" class="btn btn-primary btn-block mb-4" style="background-color: #3b71ca; border-color: #3b71ca; width: 100%; box-shadow: 0 4px 9px -4px #3b71ca; hover-bg: #3b71ca; active-bg: #3b71ca;" >ADD TRANSACTION</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>

<?php
require("connect-db.php");
require("functions.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == 'Add Expense') {
        addExpense($_POST['userID'], $_POST['transID'], $_POST['name'], $_POST['description'], $_POST['flatAmount'], $_POST['period'], $_POST['numPayments'], $_POST['startDate']);
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

    <title>Add Expense</title>
    

</head>

<body>

<div class="container">
    <div class="row align-items-center justify-content-center" style="min-height: 100vh">
        <div class="col-md-4">

            <form action="home.php" method="post">

                <h2 style="text-align: center; color: gray;">Add Expense</h2>
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

                <div class="form-outline mb-4">
                        <select name='location'>
                            <option name="Debt Auto">Debt Auto</option>
                            <option name="Debt Credit">Debt Credit</option>
                            <option name="Debt Mortgage">Debt Mortgage</option>
                            <option name="Debt Other">Debt Other</option>
                            <option name="Debt Student">Debt Student</option>
                            <option name="Emergency Car">Emergency Car</option>
                            <option name="Emergency Home">Emergency Home</option>
                            <option name="Emergency Medical">Emergency Medical</option>
                            <option name="Emergency Other">Emergency Other</option>
                            <option name="Entertainment Concessions">Entertainment Concessions</option>
                            <option name="Entertainment Other">Entertainment Other</option>
                            <option name="Entertainment Purchases">Entertainment Purchases</option>
                            <option name="Entertainment Tickets">Entertainment Tickets</option>
                            <option name="Hobby Equipment">Hobby Equipment</option>
                            <option name="Hobby Fees">Hobby Fees</option>
                            <option name="Hobby Other">Hobby Other</option>
                            <option name="Housing Maintenance">Housing Maintenance</option>
                            <option name="Housing Other">Housing Other</option>
                            <option name="Housing Rent">Housing Rent</option>
                            <option name="Insurance Health">Insurance Health</option>
                            <option name="Insurance Life">Insurance Life</option>
                            <option name="Insurance Other">Insurance Other</option>
                            <option name="Insurance Property">Insurance Property</option>
                            <option name="Luxury Cosmetics">Luxury Cosmetics</option>
                            <option name="Luxury Fashion">Luxury Fashion</option>
                            <option name="Luxury Other">Luxury Other</option>
                            <option name="Luxury Restaurant">Luxury Restaurant</option>
                            <option name="Luxury Substances">Luxury Substances</option>
                            <option name="Misc. Products">Misc. Products</option>
                            <option name="Misc. Services">Misc. Services</option>
                            <option name="Misc. Payments">Misc. Payments</option>
                            <option name="Sustenance Clothing">Sustenance Clothing</option>
                            <option name="Sustenance Groceries">Sustenance Groceries</option>
                            <option name="Sustenance Hygiene">Sustenance Hygiene</option>
                            <option name="Sustenance Medications">Sustenance Medications</option>
                            <option name="Sustenance Other">Sustenance Other</option>
                            <option name="Taxes">Taxes</option>
                            <option name="Transit Fare">Transit Fare</option>
                            <option name="Transit Gasoline">Transit Gasoline</option>
                            <option name="Transit Other">Transit Other</option>
                            <option name="Transit Vehicle">Transit Vehicle</option>
                            <option name="Travel Accomodations">Travel Accomodations</option>
                            <option name="Travel Experiences">Travel Experiences</option>
                            <option name="Travel Other">Travel Other</option>
                            <option name="Travel Transport">Travel Transport</option>
                            <option name="Utility Cell">Utility Cell</option>
                            <option name="Utility Electricity">Utility Electricity</option>
                            <option name="Utility Gas">Utility Gas</option>
                            <option name="Utility Internet">Utility Internet</option>
                            <option name="Utility Other">Utility Other</option>
                            <option name="Utility Water">Utility Water</option>
                        </select>
                </div>
                <button type="submit" value = "Add Expense" name="btnAction" class="btn btn-primary btn-block mb-4" style="background-color: #3b71ca; border-color: #3b71ca; width: 100%; box-shadow: 0 4px 9px -4px #3b71ca; hover-bg: #3b71ca; active-bg: #3b71ca;" >ADD Expense</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>

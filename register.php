<?php
require("connect-db.php");
require("functions.php");

if (!isset($_COOKIE['user']))
{
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == 'Register') {
        addUser($_POST['firstName'], $_POST['middleName'], $_POST['lastName'], $_POST['email'], $_POST['location'], $_POST['password']);
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

    <title>Register</title>
    

</head>

<body>

    <div class="container">
        <div class="row align-items-center justify-content-center" style="min-height: 100vh">
            <div class="col-md-4">

                <form action="register.php" method="post">

                    <h2 style="text-align: center; color: gray;">Registration</h2>
                    <br>

                    <?php if (isset($_GET['error'])) { ?>

                        <p class="error"><?php echo $_GET['error']; ?></p>

                    <?php } ?>
                    <!-- First name input -->
                    <div class="form-outline mb-4">
                        <input type="text" name="firstName" id="firstNameInput" class="form-control" placeholder="First Name"/>
                    </div>

                    <!-- Middle name input -->
                    <div class="form-outline mb-4">
                        <input type="text" name="middleName" id="middleNameInput" class="form-control" placeholder="Middle Name"/>
                    </div>

                    <!-- Last name input -->
                    <div class="form-outline mb-4">
                        <input type="text" name="lastName" id="lastInput" class="form-control" placeholder="Last Name"/>
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" name="email" id="emailInput" class="form-control" placeholder="Email"/>
                    </div>

                    <!-- Location input -->
                    <div class="form-outline mb-4">
                        <select name='location'>
                            <option name="Australia">Australia</option>
                            <option name="Brazil">Brazil</option>
                            <option name="Canada">Canada</option>
                            <option name="China">China</option>
                            <option name="France">France</option>
                            <option name="Georgia">Georgia</option>
                            <option name="Germany">Germany</option>
                            <option name="India">India</option>
                            <option name="Indonesia">Indonesia</option>
                            <option name="Italy">Italy</option>
                            <option name="Japan">Japan</option>
                            <option name="Mexico">Mexico</option>
                            <option name="Netherlands">Netherlands</option>
                            <option name="Russia">Russia</option>
                            <option name="Saudi Arabia">Saudi Arabia</option>
                            <option name="South Korea">South Korea</option>
                            <option name="Span">Spain</option>
                            <option name="Switzerland">Switzerland</option>
                            <option name="Turkey">Turkey</option>
                            <option name="United Kingdom">United Kingdom</option>
                            <option name="United States" selected>United States</option>
                        </select>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Password"/>
                    </div>

                    <!-- Submit button -->
                        <button type="submit" value = "Register" name="btnAction" class="btn btn-primary btn-block mb-4" style="background-color: #3b71ca; border-color: #3b71ca; width: 100%; box-shadow: 0 4px 9px -4px #3b71ca; hover-bg: #3b71ca; active-bg: #3b71ca;" >REGISTER</button>

                    <!-- Register buttons -->
                    <div class="text-center">
                        <p>Already a member? <a href="login.php" style="color: #3b71ca;">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<?php
    } else {
        header('Location: index.php');
    }
?>
</body>

</html>
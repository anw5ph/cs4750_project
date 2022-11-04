<?php
require("connect-db.php");
require("functions.php");

if (!isset($_COOKIE['user']))
{

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == 'SIGN IN') {
        $curr_user = currentUser($_POST['email']);
        $_SESSION['curr_user']  = $curr_user;
        userLogIn($_POST['email'], $_POST['password']);
    }
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

    <header>  
      <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">            
          <a class="navbar-brand" href="#">Your-Logo</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link" href="#">Software</a>
              </li>            
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" role="button" data-bs-toggle="dropdown" aria-expanded="false">Research</a>
                <ul class="dropdown-menu" aria-labelledby="dropdown01">
                  <li><a class="dropdown-item" href="#">Design</a></li>
                  <li><a class="dropdown-item" href="#">Development</a></li>
                  <li><a class="dropdown-item" href="#">Testing</a></li>
                  <li><a class="dropdown-item" href="#">Maintenance</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Activity</a>
              </li>
              <li class="nav-item">
                <!-- <form action="index.php" method="post">
                    <input type = "submit" value="Logout" class = "btn btn-danger" name = "btnAction"
                      title="Logout(Placeholder)" />
                </form> -->
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <title>Login</title>
    

</head>

<body>
    <div class="container">
        <div class="row align-items-center justify-content-center" style="min-height: 100vh">
            <div class="col-md-4">

                <form action="login.php" method="post">

                    <h2 style="text-align: center; color: gray;">Login Portal</h2>
                    <br>

                    <?php if (isset($_GET['error'])) { ?>

                        <p class="error"><?php echo $_GET['error']; ?></p>

                    <?php }?>
                    <!-- Username input -->
                    <div class="form-outline mb-4">
                        <input type="email" name="email" id="email" class="form-control" required placeholder="Email"/>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Password"/>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" value="SIGN IN" name="btnAction" class="btn btn-primary btn-block mb-4" style="background-color: #3b71ca; border-color: #3b71ca; width: 100%; box-shadow: 0 4px 9px -4px #3b71ca; hover-bg: #3b71ca; active-bg: #3b71ca;" >SIGN IN</button>

                    <!-- Register buttons -->
                    <div class="text-center">
                        <p>Not a member? <a href="register.php" style="color: #3b71ca;">Register</a></p>
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
<?php
require('connect-db.php');
require("functions.php");

session_start();
if (isset($_COOKIE['user']))
{
$curr_user = $_SESSION['curr_user'];
$userInfo = getUser($curr_user);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="your name">
        <meta name="description" content="include some description about your page">  
            
        <title>My Account</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
        <link rel="stylesheet" type="text/css" href="my-account.css">
        
    </head>

    <body>
    <header>  
          <nav class="navbar navbar-expand-md navbar-dark navbar-custom" style="--bs-bg-opacity: 1;
    background-color: #232D4B;">
            <div class="container-fluid">            
            <a class="navbar-brand" href="#" style="pointer-events: none; cursor: default;">Welcome <?php echo $userInfo['firstName']; ?>!</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="my-account.php">My Account</a>
                  </li> 
                </ul>
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="addtransaction.php">Add Transaction</a>
                  </li>
                  <li class="nav-item">
                   <a href="#" class="nav-link" id="btn-nav" data-bs-toggle="modal" data-bs-target="#exampleModal">Logout</a>
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </header>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body text-center">
                <div class="mt-4 text-danger" style="height: 50px;">Are you sure you want to logout?</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <form action="home.php" method="post">
                    <input type = "submit" value="Logout" class = "btn btn-outline-danger btn-sm" name = "logOut"
                              title="Logout(Placeholder)" />
                </form>
              </div>
            </div>
          </div>
        </div>
    <br><br>
    <div class="container">
    <div class="row">
        <div class="col-12">
            <div class="fs-2 mb-3 text-center">
            <h2 style="text-align: center; color: gray;">My Account</h2>
                    <br>
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
    </svg>
            </div>
            <div class="fs-2 mb-3 text-center">
                <h3> <?php echo $userInfo['email']; ?></h3>
            </div>
            <div class="fs-2 mb-3 text-center">
                <h3> <?php echo $userInfo['firstName']; ?> <?php if ($userInfo['middleName'] != "Middle Name") echo $userInfo['middleName']; ?> <?php echo $userInfo['lastName']; ?></h3>
            </div>
            <div class="fs-2 mb-3 text-center">
                <h3> <?php echo $userInfo['location']; ?></h3>
            </div>
            <div class="fs-4 mb-5 text-center">
                <a href="update-profile.php" role="button" class="btn btn-block mb-4">Edit Profile </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" id="footer-container">
  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <div class="col-4-md d-flex align-items-center" style="padding-left: 6em;">
      <span class="mb-3 mb-md-8 text-muted">© 2022 Alexander Williams, Bryant Chow, Connor McCaffrey, and George Sun</span>
    </div>
    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex" style="padding-right: 6em;">
      <li class="ms-3">
        <a class="text-muted" href="https://github.com/anw5ph/cs4750_project/">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
          </svg>
        </a>
        
      </li>
    </ul>
  </footer>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <?php
} else {
    header('Location: login.php');
}
?>
    </body>
</html>
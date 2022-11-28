<?php
require('connect-db.php');
require("functions.php");

session_start();
if (isset($_COOKIE['user']))
{
$curr_user = $_SESSION['curr_user'];
$userInfo = getUser($curr_user);

$default_since = date("Y-m-d");
$default_until = date("Y-m-d");
$default_order = "startDate DESC";


$list_of_transactions = getTransactions($curr_user, $default_order);

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(!empty($_POST['btnAction']) && $_POST['btnAction'] == 'Filter') {
    //$day_filter = $_POST['days'];
    //$list_of_transactions = filterTransactions($curr_user, $_POST['days']);

    $default_since = $_POST['since'];
    $default_until = $_POST['until'];
    $default_order = $_POST['order'];
    $list_of_transactions = filterTransactions($curr_user, $_POST['since'], $_POST['until'], $_POST['order']);
  }
  elseif(!empty($_POST['logOut']) && $_POST['logOut'] == 'Logout') {
    userLogout();
  }
}

?>

<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  
  <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- 
  Bootstrap is designed to be responsive to mobile.
  Mobile-first styles are part of the core framework.
   
  width=device-width sets the width of the page to follow the screen-width
  initial-scale=1 sets the initial zoom level when the page is first loaded   
  -->
  
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
    
  <title>Home</title>
  
  <!-- 3. link bootstrap -->
  <!-- if you choose to use CDN for CSS bootstrap -->  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <!-- you may also use W3's formats -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- <link rel="stylesheet" href="home.css"> -->
  
  <!-- 
  Use a link tag to link an external resource.
  A rel (relationship) specifies relationship between the current document and the linked resource. 
  -->
  
  <!-- If you choose to use a favicon, specify the destination of the resource in href -->
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  
  <!-- if you choose to download bootstrap and host it locally -->
  <!-- <link rel="stylesheet" href="path-to-your-file/bootstrap.min.css" /> --> 
  
  <!-- include your CSS -->
  <!-- <link rel="stylesheet" href="custom.css" />  -->
       
</head>

<body>
<header>  
        <!-- <link rel="stylesheet" type="text/css" href="project-header.css"> -->
          <nav class="navbar navbar-expand-md navbar-dark navbar-custom" style="--bs-bg-opacity: 1;
    background-color: #232D4B;">
            <div class="container-fluid">            
              <a class="navbar-brand" href="#">Welcome <?php echo $userInfo['firstName']; ?>!</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link active" href="home.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="my-account.php">My Account</a>
                  </li> 
                  <li class="nav-item">
                    <a class="nav-link" href="#">Help</a>
                  </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="#">Enter A Transaction</a>
                  </li>
                  <li class="nav-item">
                    <!-- <input type="submit" value="Logout" name="logOut" class="btn btn-outline-danger btn-sm"></a> -->
                    <a href="#" class="nav-link" id="btn-nav" data-bs-toggle="modal" data-bs-target="#exampleModal">Logout</a>
                    <!-- <form action="project-header.php" method="post">
                      <button type="submit" value="Logout" name="logOut" class="nav-link btn btn-primary btn-block" style="background-color: #F84C1E; border-color: #F84C1E; width: 100%; box-shadow: 0 4px 9px -4px #F84C1E; hover-bg: #F84C1E; active-bg: #F84C1E;" >Logout</button> -->

                      <!-- <input class="nav-link" type="submit" value="Logout" name="logOut" title="Logout(Placeholder)"/> -->
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


<div class="container">
  <h3>Transaction Filters</h3>  

  <form name="mainForm" action="home.php" method="post">   

  <div class="row mb-3 mx-3">
    Since
    <input type="text" class="form-control" name="since" required
      value="<?php echo $default_since ?>"
    />            
  </div>  

  <div class="row mb-3 mx-3">
    Until
    <input type="text" class="form-control" name="until" required
      value="<?php echo $default_until ?>"
    />            
  </div> 

  <div class="row mb-3 mx-3">
    Order
    <label for="order"  class="form-control"  required>    
    <select name="order" id="order">
      <option value="startDate DESC">Newest</option>
      <option value="startDate ASC">Oldest</option>
      <option value="elapsed DESC">Largest</option>
    </select>        
  </div>   


  <!-- <div class="row mb-3 mx-3"> -->
  <div>    
    <input type="submit" value="Filter" name="btnAction" class="btn btn-dark" 
           title="Filter Transactions" />       
  </div>  

</form>  

<hr/>


<h3>List of Transactions</h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="20%"><b>Name</b></th>      
    <th width="10%"><b>Period Length (Days)</b></th> 
    <th width="10%"><b>Flat Amount ($)</b></th> 
    <th width="10%"><b>Elapsed Value ($)</b></th>   
    <th width="25%"><b>Start</b></th>  
    <th width="25%"><b>End</b></th>  
  </tr>
  </thead>
<?php foreach ($list_of_transactions as $trans_info): ?>
  <tr>
     <td><?php echo $trans_info['name']; ?></td>  
     <td><?php echo $trans_info['period']; ?></td>
     <td><?php echo $trans_info['flatAmount']; ?></td>         
     <td><?php echo $trans_info['elapsed']; ?></td>      
     <td><?php echo $trans_info['startDate']; ?></td>   
     <td><?php echo $trans_info['endDate']; ?></td>         
  </tr>
<?php endforeach; ?>
</table>
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


  
<!-- CDN for JS bootstrap -->
<!-- you may also use JS bootstrap to make the page dynamic -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!-- for local -->
<!-- <script src="your-js-file.js"></script> -->  
<?php
} else {
    header('Location: login.php');
}
?>
</body>
</html>
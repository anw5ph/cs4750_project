<?php
require('connect-db.php');
require("functions.php");

session_start();

$curr_user = $_SESSION['curr_user'];

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
    
  <title>DB Interfacing</title>
  
  <!-- 3. link bootstrap -->
  <!-- if you choose to use CDN for CSS bootstrap -->  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <!-- you may also use W3's formats -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  
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
<?php include('project-header.html') ?>


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
    <label for="order"  class="form-control"  required/>    
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

<?php include('project-footer.html') ?>
  
<!-- CDN for JS bootstrap -->
<!-- you may also use JS bootstrap to make the page dynamic -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!-- for local -->
<!-- <script src="your-js-file.js"></script> -->  

</body>
</html>
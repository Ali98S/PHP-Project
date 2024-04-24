<?php

session_start();

ini_set('show_errors', 'On');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$admin = false;
$login = false;

function __autoload($className){
    include_once  $className.'.php';
}


if(!empty($_SESSION['UserID']))
    {

    $id = $_SESSION['UserID'];
    $user = new Users();
    $user->initWithUid($id);
    $name = $user->getFname();
    $login = true;
    $welcome = 'Welcome '.$user->getFname().'!';

        if($user->getType() == 'Admin')
        {
            $admin = true;
        }
    }


?>

<html>
    <head>

         <link rel="stylesheet" href="Style.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>


        <div class="nav">
  <input type="checkbox" id="nav-check">
  <div class="nav-header">
    <div class="nav-title">
      <a href="#"><img src="Styling/Souq_Logo1.png" alt="descriptive text" width="75"></a>
      <a href="#"><img src="Styling/Souq_Logo2.png" alt="descriptive text" width="120"></a>
    </div>
  </div>
  <div class="nav-btn">
    <label for="nav-check">
      <span></span>
      <span></span>
      <span></span>
    </label>
  </div>

  <div class="nav-links">
    <a href= "Home.php">Home</a>
    <a href= "DisplayProducts.php">Products</a>
    <a href= "UserProfile.php">Profile</a>
    <a href= "ViewOrders.php">Orders</a>
    <a href= "Cart.php">Cart</a>
    <a href= "Wishlist.php">Wishlist</a>
    <?php if ($login){echo '<a href="logout.php">Logout</a>' ; } else {echo '<a href= "Login.php">Login</a>';}?>
    <?php if($admin){echo'<a href= "AdminConsole.php">Admin</a>';}?>
    <br>
    <?php if($login){echo '<h3 style="float: right;" id="Welcome">Welcome '.$name;}?>
  </div>
</div>

    </body>
</html>

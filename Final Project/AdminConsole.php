<?php
include 'header.php';
?>
<html>
    <head>
        
          <link rel="stylesheet" href="Style.css">
        <meta charset="UTF-8">
        <title>Admin Console</title>
      
    </head>
    <body>
        
        <?php
        
        if(!empty($_SESSION['UserID']))
         {

            $id = $_SESSION['UserID'];
            $user = new Users();
            $user->initWithUid($id);

                if($user->getType() != 'User')
                {

        
                    echo '

                    <div class="wrap">



                        <div class="nav-admin">

                            <div class="form-box-ad">

                                <h1 id="AdminText">Admin Console</h1>


                                <p class="admin-list"><a href="ManageProducts.php" target="_blank">Manage Products</a></p>
                                <p class="admin-list"><a href="ManageUsers.php" target="_blank">Manage Users</a></p>
                                <p class="admin-list"><a href="AdminViewOrder.php" target="_blank">View Orders</a></p>
                                <p class="admin-list"><a href="AddAdmin.php" target="_blank">Add Admin</a></p>
                                <p class="admin-list"><a href="ViewLogs.php" target="_blank">View Logs</a></p>
                                <p class="admin-list"><a href="ViewSales.php" target="_blank">View Analytics</a></p>


                            </div>

                </div>';
                    
                }
                
                else
                {
                   echo
                 '<div class ="wrap">'
                                .'<div class="form-box-login">'
                                .'<h1 id="LoginText">Login</h1>'
                                .'<form action="Login.php" method="post" class="input-login" id="Login">'
                                . '<h1 id="LoginText">Please Login with an admin account</h1> <br> <br>'

                                . ' <button type="submit" class="submit-btn" value="logout">Login</button>'
                                        .'<input type="hidden" name="submitted_Logout" value="1" />'
                                       . '</div>'
                                        . '</div>';
                }
                
                
                }
                
                
            else
            {
                      echo
                      '<div class ="wrap">'
                                .'<div class="form-box-login">'
                                .'<h1 id="LoginText">Login</h1>'
                                .'<form action="Login.php" method="post" class="input-login" id="Login">'
                                . '<h1 id="LoginText">Please Login with an admin account</h1> <br> <br>'

                                . ' <button type="submit" class="submit-btn" value="logout">Login</button>'
                                        .'<input type="hidden" name="submitted_Logout" value="1" />'
                                       . '</div>'
                                        . '</div>';
            }
        
        
        ?>
    </body>
</html>

<?php
include 'header.php';
?>
<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <meta charset="UTF-8">
        <title>Manage Products</title>
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

                                <h1 id="AdminText">Products Control Panel</h1>

                                <p class="admin-list"><a href="AddProduct.php" target="_blank">Add Product</a></p>
                                <p class="admin-list"><a href="ViewProductsAdmin.php" target="_blank">Update or Delete Products</a></p>
                               
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

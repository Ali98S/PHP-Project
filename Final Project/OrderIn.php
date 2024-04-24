<?php include 'header.php';?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Order Confirmation</title>
          <link rel="stylesheet" href="Style.css">
    </head>
    <body>
        <?php
        // put your code here
        echo
                 '<div class ="wrap">'
                                .'<div class="form-box-login">'
                                .'<form action="ViewOrders.php" method="post" class="input-login" id="Login">'
                                . '<h1 id="LoginText">Your Order is in! Expect the package within 5 Working Days.</h1> <br> <br>'

                                . ' <button type="submit" class="submit-btn" value="logout">My Orders</button>'
                                        .'<input type="hidden" name="submitted_Logout" value="1" />'
                                       . '</div>'
                                        . '</div>';
        ?>
    </body>
</html>

<?php include 'header.php';?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Account Required</title>
          <link rel="stylesheet" href="Style.css">
    </head>
    <body>
        <?php
        // put your code here
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
        ?>
    </body>
</html>

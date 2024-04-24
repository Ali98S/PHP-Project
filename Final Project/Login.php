<?php

include 'header.php';
//include 'header.html';
//include 'DB.php';

$status;
date_default_timezone_set('Asia/Bahrain');

if(isset($_POST['submitted_Login']))
{
    $uname = $_POST['username'];
    $user = new Users();
    $log = new Logs();
    
    $user->setUsername($_POST['username']);
    $user->setPassword($_POST['password']);
    
    $user->initWithUsername();
    
        if($user->getStatus() == 'Deactive')
        {
            $deactive= true;
        }
    
    if($user->Login())
    {
            if($user->getType() == 'User' && $user->getStatus() == 'Active')
                {
                    header('Location: DisplayProducts.php');
                }
                elseif($user->getType() == 'Admin' && $user->getStatus() == 'Active')
                {     
                    header('Location: AdminConsole.php');
                }

                //Assigns a cookie that expires after 3 months if the user ticks the checkbox
                if(!empty($_POST['RememberMe']))
                {
                    setcookie ("username",$_POST["username"],time()+ 7776000);
                    setcookie ("password",$_POST["password"],time()+ 7776000);
                }


                $status = 'Success';
                $log->addLog($uname, $status, date('Y-m-d'), date("h:i:sa"));
      
    }
    else
    {
        $error = 'Wrong username or password';
        $status = 'Failed';
        $log->addLog($uname, $status, date('Y-m-d'), date("h:i:sa"));
    }
    
}


 if(isset($_POST['submitted_Logout']))
{
    $user = new Users();
    $user->Logout();
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="Style.css">
    </head>
    
   
    <body>
        
        <?php 
    
        
        if(empty($_SESSION['UserID'])){
            
        echo'
        <div class ="wrap">
         
            <div class="form-box-login">
               
                <h1 id="LoginText">Login</h1>
            
            <form action="Login.php" method="post" class="input-login" id="Login">
                <div id="error">' . $error. ' </div>
             <input type="text" class="input-field" placeholder="Username" name="username" value = "'. $_COOKIE["username"].'" required>
             <input type="password" class="input-field" placeholder="Password" name="password" value = "'. $_COOKIE["password"].'" required>
             <input type="checkbox" class="chech-box" name="RememberMe"›<span>Remember Me</span>
             <button type="submit" class="submit-btn" value="login">Log in</button>
             <br>
             <br>
             <a href="register.php" id="nuser">Not a user?</a>
             <br>
             <br>
             <input type="hidden" name="submitted_Login" value="1" />
            </form>
            
            </div>
            
        
       </div>
        ';
            
        }
        
        elseif($user->getStatus() == 'Deactive')
        {
             echo 
            '<div class ="wrap">'
            .'<div class="form-box-login">'
            .'<h1 id="LoginText">Deactive</h1>'
            .'<form action="Login.php" method="post" class="input-login" id="Login">'
            . '<h1 id="DeactiveText">Your account is not active. Contact admin@souq.com</h1> <br> <br>'
                    
                    .'<input type="hidden" name="submitted_Logout" value="1" />'
                   . '</div>'
                    . '</div>';
             
             $user->Logout();
        }
  
        else
        {
            echo 
            '<div class ="wrap">'
            .'<div class="form-box-login">'
            .'<h1 id="LoginText">Logout</h1>'
            .'<form action="Login.php" method="post" class="input-login" id="Login">'
            . '<h1 id="LoginText">You already are logged in</h1> <br> <br>'
                    
            . ' <button type="submit" class="submit-btn" value="logout">Logout</button>'
                    .'<input type="hidden" name="submitted_Logout" value="1" />'
                   . '</div>'
                    . '</div>';
        }
        ?>

    </body>
</html>

<?php include 'footer.html';?>

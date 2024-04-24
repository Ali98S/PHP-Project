<?php
include 'header.php';
include 'DB.php';
//include 'header.html';


if(isset($_POST['submitted_Register']))
{

    $user = new Users();
    $user->setUsername($_POST['username']);
    
    
     $firstname = $_POST['fname'];
     $lastname = $_POST['lname'];
     $email = $_POST['email'];
     $username = $_POST['username'];
     $address = $_POST['address'];
     $password = $_POST['password'];
               
               
    if($user->initWithUsername())
    {
        if($user->emailCheckNewUser($_POST['email']))
        {
                $user->setFname($_POST['fname']);
                $user->setLname($_POST['lname']);
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);
                $user->setAddress($_POST['address']);
                
                 if(strlen($_POST['password']) < 8)
                {
                    $userExist = 'Password must be at least 8 characters';
                }

                elseif(empty($_POST['terms']))
                {
                    $userExist = 'You must agree to the terms and services';
                }
                 
                else
                {
                    if($user->RegisterUser())
                    {
                        $userAdded = 'Registered Succesfully';           
                    }
                }
        }
        
        else
        {
                $userExist = 'This Email is taken.';
        }
    }
    
    else
    {
        $userExist = 'This username is taken.';
    }
    
}


?>



<html>
    <head>
        <meta charset="UTF-8">
         <title>Register</title>
        <link rel="stylesheet" href="Style.css">
    </head>
    <body>
        
        <div class ="wrap">
            
            <div class="form-box-reg">
                
                <h1 id="LoginText">Register</h1>
                
            <form action="register.php" method="post" class="input-reg" id="Register">
                  <div id="error"> <?php echo $userExist?> </div>
                  <div id="added"> <?php echo $userAdded?> </div>
             <input type="text" class="input-field" placeholder="First Name" name="fname" value="<?php echo $firstname; ?>" required>   
             <input type="text" class="input-field" placeholder="Last Name" name="lname" value="<?php echo $lastname;?>" required>
             <input type="text" class="input-field" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
             <input type="email" class="input-field" placeholder="Email" name="email" value="<?php echo $email;?>" required>
             <input type="text" class="input-field" placeholder="Address" name="address" value="<?php echo $address;?>" required>
             <input type="password" id="MyPswd" class="input-field" placeholder="Password. (Min 8 Characters)" name="password" value="<?php echo $password;?>" required>
             <input type="checkbox" onclick="myFunction()"> <label id="profileLabel">Show Password</label>
             <br><input type="checkbox" class="chech-box" name="terms"  <span><a href="https://www.dlapiperdataprotection.com/index.html?t=collection-and-processing&c=BH" target="_blank">I agree to the terms and services</a></span>
             <button type="submit" class="submit-btn-reg" name="regBtn" value="register">Register</button>
             <br>
             <br>
             <a href="Login.php" id="nuser">Log in</a>
             <input type="hidden" name="submitted_Register" value="1" />
            </form>   
                
            </div>
        </div>
        
    </body>
    
    
    <script> 
    
    function myFunction() {
    var x = document.getElementById("MyPswd");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }

    
    
    </script>
</html>

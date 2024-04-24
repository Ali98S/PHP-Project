<?php include 'header.php';

    if(!empty($_SESSION['UserID']))
    {

            $id = $_SESSION['UserID'];
            $user = new Users();
            $user->initWithUid($id);

                    if($user->getType() != 'Admin')
                {
                     header('Location: NonAuthorizedAccess.php');
                }
    }
         
    else
    {
       header('Location: NonAuthorizedAccess.php');
    }
         


if(isset($_POST['submitted_Register_Admin']))
{

    
         $firstname = $_POST['fname'];
         $lastname = $_POST['lname'];
         $email = $_POST['email'];
         $username = $_POST['username'];
         $address = $_POST['address'];
         $password = $_POST['password'];
   
    
    //$user = new Users();
    $admin = new Admin();
    $admin->setUsername($_POST['username']);

    
    if($admin->initWithUsername())
    {
        if($admin->emailCheckNewUser($_POST['email']))
        {
                $admin->setFname($_POST['fname']);
                $admin->setLname($_POST['lname']);
                $admin->setEmail($_POST['email']);
                $admin->setPassword($_POST['password']);
                $admin->setAddress($_POST['address']);
                
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
                    
                    if($admin->AddAdmin())
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
        <title>Add Admin</title>
    </head>
    <body>
        
        <div class ="wrap">
            
            <div class="form-box-reg">
                
                <h1 id="LoginText">Add Admin</h1>
                
            <form action="AddAdmin.php" method="post" class="input-reg" id="Register">
                  <div id="error"> <?php echo $userExist?> </div>
                  <div id="added"> <?php echo $userAdded?> </div>
             <input type="text" class="input-field" placeholder="First Name" name="fname" value="<?php echo $firstname; ?>" required>   
             <input type="text" class="input-field" placeholder="Last Name" name="lname" value="<?php echo $lastname;?>" required>
             <input type="text" class="input-field" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
             <input type="email" class="input-field" placeholder="Email" name="email" value="<?php echo $email;?>" required>
             <input type="text" class="input-field" placeholder="Address" name="address" value="<?php echo $address;?>" required>
             <input type="password" id="MyPswd" class="input-field" placeholder="Password. (Min 8 Characters)" name="password" value="<?php echo $password;?>" required>
             <input type="checkbox" class="chech-box" name="terms"  <span>I agree to the terms and services</span>
             <button type="submit" class="submit-btn-reg" name="regBtn" value="register">Add Admin</button>

             <input type="hidden" name="submitted_Register_Admin" value="1" />
            </form>   
                
            </div>
        </div>
        
    </body>
</html>

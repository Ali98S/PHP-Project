<?php
include 'header.php';

if(empty($_SESSION['UserID']))
{
    header('Location: Login.php');
}

$uid = $_SESSION['UserID'];

$user = new Users();
$user->initWithUid($uid);

$firstname = $user->getFname();
$lastname = $user->getLname();
$username = $user->getUsername();
$email = $user->getEmail();
$address = $user->getAddress();
$pswd = $user->getPassword();




if(isset($_POST['UpdtUser']))
{
    if($user->checkUpdateUsername() && $user->checkUsername($_POST['username']))
    {
        if($user->checkUpdateEmail() && $user->checkEmail($_POST['email']))
        {
                $user->setFname($_POST['fname']);
                $user->setLname($_POST['lname']);
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);
                $user->setAddress($_POST['address']);
                $user->setUsername($_POST['username']);
                
                if(strlen($_POST['password']) < 8)
                {
                    $userExist = 'Password must be at least 8 characters'; 
                }
                 
                elseif($user->UpdateUser())
                {
                        $userAdded = 'Updated Succesfully';
                         //header("Location: UserProfile.php");
                } 
                else
                {
                  $userExist = 'Error. Try again';
                }

                   
        }
        
        else
        {
                $firstname = $_POST['fname'];
                $lastname = $_POST['lname'];
                
                $username = $_POST['username'];
                $pswd = $_POST['password'];
                $userExist = 'This Email is taken.';
        }
    }
    
    else
    {
        $firstname = $_POST['fname'];
        $lastname = $_POST['lname'];
        $email = $_POST['email'];
    
        $pswd = $_POST['password'];
        $userExist = 'This username is taken.';
        
    }
}

elseif(isset($_POST['DeleteAc'])) 
{
   if($user->deleteuser($uid))
   {
       $user->Logout();
       header('Location: Login.php');
   }
}

elseif(isset($_POST['DecteAc']))
{
    if($user->DeactivateUser($uid))
    {
      $user->Logout();
      header('Location: Login.php');
    }
}


?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Profile</title> 
        <link rel="stylesheet" href="Style.css">
        
    </head>
    
    <body>
        <div class="wrap">
            
            <div class="form-box-usr">
                
                <h1 id="LoginText-usr">My Profile</h1>
                
                 <form action="UserProfile.php" method="post" class="input-usr" id="Register">
                  <div id="error"> <?php echo $userExist?> </div>
                  <div id="added"> <?php echo $userAdded?> </div>
                   
                  <input type="text" class="input-field" placeholder="" name="fname" value="<?php echo $firstname; ?>" required> 
                    <label id="profileLabel">First Name</label>
                    
                 <input type="text" class="input-field" placeholder="" name="lname" value="<?php echo $lastname;?>" required>
                 <label id="profileLabel">Last Name</label> 
                 
             <input type="text" class="input-field" placeholder="" name="username" value="<?php echo $username; ?>" required>
             <label id="profileLabel">Username</label> 
             
             <input type="email" class="input-field" placeholder="" name="email" value="<?php echo $email;?>" required>
             <label id="profileLabel">Email</label> 
             
             <input type="text" class="input-field" placeholder="" name="address" value="<?php echo $address;?>" required>
             <label id="profileLabel">Address</label> 
             
             <input type="password" class="input-field" placeholder="" name="password" id="MyPswd" value="<?php echo $pswd;?>" required>
             
             <input type="checkbox" onclick="myFunction()"> <label id="profileLabel">Show Password</label>
             <br>
             <br>
             <br>
             <button type="submit" class="submit-btn-reg" name="UpdtUser" value="register">Update Info</button>
             <br>
             <button type="submit" class="submit-btn-dlt" name="DecteAc" value="register" onclick="return confirm('Are you sure you want to de-activate this account, your data will still remain in the system but you will need to contact us at admin@souq.com again to re-activate?')">De-Activate Account</button>
             <br>
            <button type="submit" class="submit-btn-dlt" name="DeleteAc" value="register" onclick="return confirm('Are you sure you want to delete this account? Deletion is permanent and will remove your information from the system. Some data can not be removed such as order history')">Delete Account</button>
            <input type="hidden" name="submitted_Register" value="1" />
            </form>   
                
            </div>
            
                       
            </div>
            
      
           
        </div>
        
    </body>
    
    
   
</html>

<script>

function myFunction() {
  var x = document.getElementById("MyPswd");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}


function DeletedAccount()
{
    alert("Account Deleted. You can register again at anytime :)");
}


function DeactivatedAccount()
{
    alert("Account De-activated. Please contact admin@souq.com to reactivate your account");
}



</script>

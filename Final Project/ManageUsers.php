<?php  

include 'header.php';

//Blocks any a account that is not an admin or non-accounts from accessing this feature
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
    
    $username = '';
    
    $admin = new Admin();
    
    if(isset($_GET['pageno']))
    {
        $start = $_GET['pageno'];
    }
    else 
    {
        $start = 1;
    }

    $end = 10;

   

    $number_of_result = $admin->UsersCount();

   //  echo $number_of_result;
    
    $number_of_page = ceil ($number_of_result / $end); 

    $page_first_result = ($start-1) * $end;  
     
    $users = $admin->getAllusers($page_first_result, $end);

    if(isset($_POST['DisplayAll']))
    {
        $users = $admin->getAllusers($page_first_result, $end);
    }
    
    
    if(isset($_POST['Reactivate']))
    {
        $uid = $_POST['Reactivate'];
        $admin->ReActivateUser($uid);
        header("Location: ManageUsers.php");
    }
    
    
    if(isset($_POST['Deactivate']))
    {
        $uid = $_POST['Deactivate'];
        $admin->DeactivateUser($uid);
        header("Location: ManageUsers.php");
    }
    
    if(isset($_POST['DeleteUser']))
    {
        $uid = $_POST['DeleteUser'];
        $admin->deleteuser($uid);
        header("Location: ManageUsers.php");
    }
    
    
    if(isset($_POST['Search']))
    {
        $username = $_POST['SearchBox'];
        $users = $admin->getSpecificUsers($username);
    }
    
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Manage Users</title>
        <style>
            
            
        .remove {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        
   
         .move {
            background-color: lightblue;
            color: black;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
            
        .search
        {
            float: right;
        }
        
        .query
        {
            font-size: 5px;
        }
              
        </style>
    </head>
    <body>
        <div class="wrap">
            <form action="ManageUsers.php" method="post">
                
                <div class="search"> 
                <input type="search" id="Search" class="query" name="SearchBox" placeholder="Search Username..." value="<?php echo $username; ?>">
                         <button type="submit" class="ApplySearch" name="Search" value="Search" >Search</button><br>
                         
                </div>
                
                <h1>Manage Users</h1>
                <button type="submit" class="ApplySearch" name="DisplayAll" value="Search" >View All</button><br>
        <?php
        if (!empty($users)) {
            echo '<br />';
            //display a table of results
            echo '<table align="center" cellspacing = "2" cellpadding = "4" width="100%">';
            echo '<tr bgcolor="#87CEEB">
                  <td><b>Change Status</b></td>
                  <td><b>Delete</b></td>
                  <td><b>User ID</b></td>
                  <td><b>Username</b></td>
                  <td><b>First Name</b></td>
                  <td><b>Last Name</b></td>
                  <td><b>Email</b></td>
                  <td><b>Address</b></td>
                  <td><b>Status</b></td>
                  <td><b>Type</b></td>
                  <td><b>View Orders</b></td>
                  </tr>';


        //above is the header
        //loop below adds the user details    
            //use the following to set alternate backgrounds 
            $bg = '#eeeeee';


                    foreach ($users as $data)
                     {
                        
                        if($data->Status === 'Active')
                        {
                            $btn = '<td><button type="submit" name="Deactivate" onclick="return confirm(\'Are you sure you want to Deactivate User: '.$data->Username.' ?\');" class="move" value="'.$data->UserID.'">Deactivate</button></td>';

                        }
                        else
                        {
                            $btn = '<td><button type="submit" name="Reactivate" onclick="return confirm(\'Are you sure you want to Reactivate User: '.$data->Username.' ?\');" class="move" value="'.$data->UserID.'">Reactivate</button></td>';
                        }
                        
                        
                        
                        
                        
                        $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');

                     echo '<tr bgcolor="' . $bg . '">
                          '.$btn.'
                         <td><button type="submit" name="DeleteUser" onclick="return confirm(\'Are you sure you want to Delete User: '.$data->Username.' ?\');" class="remove" value="'.$data->UserID.'">Delete User</button></td>  
                         <td>' . $data->UserID . '</td>
                         <td>' . $data->Username . '</td>    
                         <td>' . $data->Fname . '</td>
                         <td>' . $data->Lname . '</td>
                         <td>'. $data->Email . '</td>
                         <td>'. $data->Address . '</td>
                         <td>' . $data->Status . '</td>
                         <td>' . $data->Type . '</td>
                         <td><a href="AdminViewOrders.php?uid=' . $data->UserID . '" target="_blank">View Orders</a></td>
                       </tr>';
                     }


                     echo '<table align="center" cellspacing = "2" cellpadding = "4" width="75%"><tr><td>';
                     $pagination = new Pagination();
                     $pagination->totalRecords($number_of_result);
                     $pagination->setLimit($end);
                     $pagination->page($new, $old);
                     echo $pagination->firstBack();
                     echo $pagination->nextLast();
                     echo $pagination->where();
                     echo '</td></tr></table>';

                     }
            
            else
            {
                echo "<h1>No data found</h1>";
            }
        ?>
            </form>
            </div>
    </body>
</html>

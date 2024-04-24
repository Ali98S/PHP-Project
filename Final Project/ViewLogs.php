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







date_default_timezone_set('Asia/Bahrain');

$log = new Logs();


$admin = new Admin();

if(isset($_GET['pageno']))
{
    $start = $_GET['pageno'];
}
else 
{
    $start = 1;
}




$end = 25;

echo $number_of_result;

$number_of_result = $log->getLogsCount();

$number_of_page = ceil ($number_of_result / $end); 

 $page_first_result = ($start-1) * $end;  

 $Logs = $log->DisplaySpecificLogs($page_first_result, $end);
 


if(isset($_POST['RemoveLogs']))
{
    $log->clearLogs();
    header('Location: ViewLogs.php');
}



?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Logs</title>
    </head>
    
    <style> 
        
        .apply {
            background-color: lightblue;
            color: black;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .remove {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        </style>
    <body>
        
        <div class="wrap">
            
        <h1 class="ProductsLabel">Logs</h1>
        <br>
        <br>
        
        <form class="form" method="post" action="ViewLogs.php">
            
                <button type="submit" name="RemoveLogs" class="remove" onclick="return confirm('Are you sure you want to delete the logs?');">Clear Logs</button>
                   
                   </form>
        <?php
        // put your code here
      
        if(!empty($Logs))
        {
           
            
          echo '<table align="center" cellspacing = "2" cellpadding = "4" width="100%">';
          echo '<tr bgcolor="#87CEEB">
          <td><b>Username</b></td>
        <td><b>Status</b></td>
        <td><b>Date</b></td>
        <td><b>Time</b></td>
          </tr>';
           $bg = '#eeeeee';
          
          
           foreach ($Logs as $data)
            {
               $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');

            echo '<tr bgcolor="' . $bg . '">
                
                    
                <td>' . $data->username . '</td>
                <td>' . $data->status . '</td>
                    <td>' . $data->date . '</td>
                        <td>' . $data->time . '</td>
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
            echo '<h1 class="ProductsLabel">No Logs</h1><br>';
            echo $notfound;
        }
        
        ?>
        </div>
    </body>
</html>

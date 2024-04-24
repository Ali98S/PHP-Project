<?php

include 'header.php';

if(empty($_SESSION['UserID']))
{
    header('Location: Login.php');
}



if(isset($_GET['pageno']))
{
    $start = $_GET['pageno'];
}
else 
{
    $start = 1;
}

$uid = $_SESSION['UserID'];
$user = new Users();
$user->initWithUid($uid);

$end = 10;

$uid = $user->getUid();

$number_of_result  = $user->orderCount();


$number_of_page = ceil ($number_of_result / $end); 

 $page_first_result = ($start-1) * $end;  

$orders = $user->ViewOrder($page_first_result , $end, $uid);

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Orders</title>
        
        <style>
            
            table 
                {
	           border-collapse: collapse;
	           width: 100%;
		   font-family: monospace;
		   font-size: 25px;
                   text-align: left;	
                   border: none;
                }
		
                th 
                {
			background-color: #6f588c;
			color: black;
		}
		tr {background-color: white}
                
                td 
                {
                    border-bottom: 1px solid black;
                    padding: 10px;
                }
             
        </style>
    </head>
    <body>
        
         
        <div class="wrap">
            
            <h1 class="ProductsLabel">My Orders</h1>
        <br>

        <div class="form-box-order">
               
                
                <?php 
                    
                    if(!empty($orders))
                    {
                         echo
                            '
                              <table id="cart" class= "cart">
                                 <tr>
                                    <th>Order ID</th>
                                    <th>Items</th>
                                    <th>Order Date</th>
                                    <th>Total Price</th>
                                    <th>View Details</th>
                                </tr>';
                         foreach ($orders as $data)
                         {
                           $pname =  $user->ViewOrderDetails($data->OrderID);
                           $title = '';
                           
                           foreach($pname as $pn)
                           {
                               $title .= $pn->ProductName;
                               $title .= ', ';
                               
                           }
                           
                           $title = rtrim($title, ', ');
                      echo
                            '
                            <tr>

                                    <td>'.$data->OrderID.'</td>
                                    <td>'.$title.'</td>
                                    <td>'.$data->Date.'</td>
                                    <td>'.$data->TotalPrice.'</td>
                                    <td><a href="ViewOrderDetails.php?oid='.$data->OrderID.'" target="_blank">Details</a></td>
                                        
                            </tr>';
                         }
                         
                       
        
                    }
                    
                    else
                    {
                        echo '<div style="display: flex; justify-content: center; margin-top: 5%;">
                            <h1>No Orders Yet</h1>
                          </div>';
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
                ?>
            </div>
        </div>
    </body>
</html>

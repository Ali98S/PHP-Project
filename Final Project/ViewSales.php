<?php 
include 'header.php';

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
     
 
   $sales = new SalesDetails();
   
   $LifeTime = $sales->getTotalSales();
   $BestCat = $sales->bestSellingCat();
   
   foreach($BestCat as $data)
   {
       $MostCat = $data->Category;
       $MostCatSales = $data->TOTALSALES;
   }
   
   $MostMoney = $sales->mostMoneyCat();
   
     foreach($MostMoney as $data)
   {
       $MostMoneyGenerating = $data->Category;
       $MoneyGenerated = $data->TOTALPRICE;
   }
    
   
   $WorstCat = $sales->worstSellingCat();
   
    foreach($WorstCat as $data)
   {
       $LeastMoneyGenerating = $data->Category;
       $LeastMoneyGenerated = $data->TOTALSALES;
   }
   
   $usersCount = $sales->getUsersCount();
   $usersDeactive = $sales->getUsersCountDeactive();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>View Analytics</title>
    </head>
    <body>
 
        <div class="wrap">
                   <h1 class="ProductsLabel">Analytics</h1>
        <div class="grid-container">
            
                <div class="grid-item">
                    <b>Lifetime Sales</b><br><br>
                    <?php echo $LifeTime;?> BHD <br> <br>
                    Total amount of money generated so far.
                </div>

                <div class="grid-item">
                    <b>Most Selling Category</b><br><br>
                    <?php echo $MostCat; ?><br><br>
                    <?php echo $MostCatSales; ?> Units Sold<br><br>
                    Category with the most amount of products sold regardless of money generated.
                </div>

                 <div class="grid-item">
                    <b>Best Selling Category</b><br><br>
                    <?php echo $MostMoneyGenerating;?><br><br>
                    <?php echo $MoneyGenerated; ?> BHD<br><br>
                    Category with the most amount of money generated.
                </div>

                  <div class="grid-item">
                    <b>Worst Selling Category</b><br><br>
                    <?php echo $LeastMoneyGenerating;?><br><br>
                    <?php echo $LeastMoneyGenerated; ?> Units Sold<br><br>
                    Category with the least amount of products sold.
                </div>
            
             <div class="grid-item">
                    <b>Active Users</b><br><br>
                    <?php echo $usersCount ?> Active Users<br><br>
                    Total number of active registered users.
                </div>
            
            <div class="grid-item">
                    <b>Non-Active Users</b><br><br>
                    <?php echo $usersDeactive ?> Deactivated Users<br><br>
                    Total number of deactivated registered users.
                </div>
            
        </div>
        
        </div>
        
        
        
        
        
        <?php
        // put your code here
        ?>
    </body>
</html>

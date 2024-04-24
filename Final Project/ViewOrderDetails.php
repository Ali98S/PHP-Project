<?php 
include 'header.php';

if(empty($_SESSION['UserID']))
{
    header('Location: Login.php');
}

$oid = $_GET['oid'];

$user = new Users();

$details = $user->ViewOrderDetails($oid);
$order = $user->ViewSpecificOrder($oid);

?> 


<html>
<head>
  <meta charset="UTF-8">
  <title>Order Details</title>
  
  <style>
      
         .receipt 
         {
         margin-top: 5%;
        font-family: Arial, sans-serif;
        border: 1px solid #ccc;
        padding: 10px;
        font-size: 30px;
        background-color: white;
      }

      .header {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
         border-bottom: 1px solid black; 
      }

      .item {
        display: flex;
        justify-content: space-between;
      }

      .product {
        flex-basis: 60%;
      }

      .quantity,
      .price {
        flex-basis: 20%;
      }

      .total {
        margin-top: 10px;
      }

  </style>

</head>
<body>
    <div class="wrap">
        <div class="receipt">
            
          <div class="header">
              
            <div class="product">Products</div>
            <div class="quantity">Quantity</div>
            <div class="price">Price</div>
          <br>
           <br>
          </div>
          <?php foreach($details as $det) { ?>
            <div class="item">
              <div class="product"><?php echo $det->ProductName; ?></div>
              <div class="quantity"><?php echo $det->Quantity; ?></div>
              <div class="price"><?php echo $det->Price; ?> &nbsp; BHD</div>
            </div>
          <?php } ?>
          <div class="total">
             <br>
            <br>
              Shipped To: <?php echo $order->Username.'<br><br>' ?>
              Order Date: <?php echo $order->Date.'<br><br>' ?>
              Address: <?php echo $order->Address.'<br>' ?>
            Total: <?php echo $order->TotalPrice.' '.'&nbsp; BHD'?>
          </div>
        </div>

      
      </div>
  </div>
        
 </div>
</body>
</html>

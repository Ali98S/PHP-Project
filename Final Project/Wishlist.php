<?php 

include 'header.php';

if(empty($_SESSION['UserID']))
{
    header('Location: Login.php');
}

$error = "";

$uid = $_SESSION['UserID'];

$user = new Users();
$user->initWithUid($uid);

$wish = new WishlistClass();

$product = new Products();

$cart = new CartClass();

$wishItems = $wish->DisplayWishlit($uid);


if(isset($_POST['RemoveWish']))
{
    $pid = $_POST['RemoveWish'];
    $wish->removeWishlist($uid, $pid);
    header('Location: Wishlist.php');
}


if(isset($_POST['MoveWish']))
{
    $pid = $_POST['MoveWish'];
    
    $product->initWithPid($pid);
    
    if($product->getProductQuantity() > 0 )
    {
        if($cart->checkCart($uid, $pid))
        {
            $cart->addCart($pid, $uid);
            setcookie("Qty".$pid, 1, time()+ 7776000);
            $itemadded = 'Item added to your Cart.';
        }
        else
        {
            $error = 'This Item is already in your cart';
        }
        
    }
    else
    {
        $error = 'This Item is out of stock currently';
    }
}







?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Wishlist</title>
        
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
			background-color: #7daad1;
			color: Black;
		}
		tr {background-color: white}
        td {
            border-bottom: 1px solid black;
            padding: 10px;
        }
        
        .image {
            width: 100px;
            height: 100px;
        }
        

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
        
        
       
    
    
	</style>
  
        
        
    </head>
    <body>
        
        
           <div class="wrap">
            
            <form class="form" method="post" action="Wishlist.php">
                
            
            
        <h1 class="ProductsLabel">Wishlist</h1>
        <br>
        <br>
    <div id="error" style="font-size: 20px; font-weight: bold; float: right;"><?php echo $error?></div>
    <div id="added" style="font-size: 20px; font-weight: bold; float: right;"><?php echo $itemadded?></div>

        <?php 
  
        //Display the cart if it is not empty
        if(!empty($wishItems))
        {
            echo
                '
                    <table id="cart" class= "cart">
                     <tr>
                        
                        <th>Picture</th>
			<th>Product Name</th>
			<th>BHD</th>
                        <th>Status</th>
                        <th>Remove</th>
                        <th>Move</th>
                    </tr>';
                
            foreach ($wishItems as $data)
            {
                 //get the id of the product from the wishlist  
                $id = $data->ProductID;
               
                
                //Initialize the product with the id to access other related data such as name and picture
                $product->initWithPid($id);
                
               $Price = $product->getProductPrice();
               
               if($product->getProductQuantity() > 3)
               {
                   $status = 'Available';
               }
               elseif($product->getProductQuantity() <= 3 && $product->getProductQuantity() > 0)
               {
                   $status = 'Only 3 pieces or less are available';
               }
               else
               {
                   $status = 'Out of stock';
               }
               
              echo
                '
                 
		<tr>
                       
                        <td><img src="'.$product->getProductImage().'" alt="Product 1" class="image"></td>
			<td><a href="ViewProduct.php?pid='.$id.'" target="_blank">'.$product->getProductName().'</a></td>
			<td>'.$Price.'</td>
                        <td>'.$status.'</td>
			<td><button type="submit" name="RemoveWish" class="remove" value="'.$id.'">Remove Item</button></td>
                        <td><button type="submit" name="MoveWish" class="move" value="'.$id.'">Move to Cart</button></td>
                        
                        
                            
		</tr>';
                
                
                }
            }
        else
        {
            echo '<h1 class="ProductsLabel">Empty</h1>';
        }
        
        
        echo '</table>';
      
        ?>
          </form> 
            
        </div>
        

        
        <?php
        // put your code here
        ?>
    </body>
</html>

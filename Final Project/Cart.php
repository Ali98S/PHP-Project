<?php 

include 'header.php';

if(empty($_SESSION['UserID']))
{
    header('Location: Login.php');
}

$uid = $_SESSION['UserID'];
unset($_SESSION['Order']);
$user = new Users();
$user->initWithUid($uid);

$cart = new CartClass();

$product = new Products();

$cartItems = $cart->DisplayCart($uid);

//If an item is removed from the cart all of the related data is also removed including cookies and sessions
if(isset($_POST['RemoveCart']))
{
    $prid = $_POST['RemoveCart'];
    $cart->removeItem($uid, $prid);
    unset($_SESSION['cart'][$prid]['name']);
    unset($_SESSION['cart'][$prid]['quantity']);
    unset($_SESSION['cart'][$prid]['xQty']);
    unset($_SESSION['cart'][$prid]['xName']);
    
    setcookie("Qty".$prid, "", time() - 3600);
    header("Location: Cart.php");
}


if(isset($_POST['checkout']))
{
    //Loop through all the items in the cart
    foreach ($cartItems as $data) 
    {
        $id = $data->ProductID;
        $product->initWithPid($id);
        $name = $product->getProductName();
        $quantity = $_COOKIE["Qty".$id];

        //These variables are an alternate var of the ones above because they include html tags and will be displayed in the checkout page
        //The html tags cant be removed from the checkout page after a product is removed so they are included in these variables so that they can be removed from the session

        if($product->getProductQuantity() > 0)
        {
            $xQty = $quantity.'X<br>';
            $xName = $name.'&nbsp;&nbsp;';

            //Data is saved in a session array ['Cart'] is the name of the array ['id'] is the index and the last [] is the data
             $_SESSION['cart'][$id]['name'] = $name;
             $_SESSION['cart'][$id]['xQty'] = $xQty;
             $_SESSION['cart'][$id]['xName'] = $xName;
             $_SESSION['cart'][$id]['quantity'] = $quantity;
             $_SESSION['Order'] = $user->getUid()."order";
        }
        
    }
  
    //Total price is saved in a separate session variable that dynamically changes whenever the $_POST['checkout'] is set.
    $_SESSION['TotalPrice'] = $_POST['TotalPrice'];
    //This session is used to prevent users from accessing the checkout page if they dont have an item in the cart
   // $_SESSION['Order'] = $user->getUid()."order";
    
    header('Location: Checkout.php');
}





?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cart</title>
        
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
			background-color: #588c7e;
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
        
        .checkout {
            position:relative; 
            float:right; 
            margin-right: 2%;
            margin-bottom: 2%;
            margin-top: 2%;
        }
        .checkout button {
            width: 100%;
            padding: 10px 30px;
            cursor: pointer;
            display: block;
            background: green;
            border: 0;
            outline: none;
            border-radius: 30px;
            color: white;
        }
    
	</style>
    </head>
    <body onload="updateSubTotal()">
        
     
        
        <div class="wrap">
            
            <form class="form" method="post" action="Cart.php">
                
                
            <?php 
            
            $totalPrice= 0;
            
            
            if(!empty($cartItems))
            {
                echo ' <div class="checkout">
                   <h3 style="display: inline-block;">Total Price:</h3>
                        <p id="val" style="display: inline-block;">'.$totalPrice.'</p>&nbsp;<p style="display: inline-block;">BHD</p>
                        <button type="submit" class="submit-btn-chk" name="checkout" value="chck">Checkout</button>
                        <input type="hidden" id="TotalPrice" name="TotalPrice" value="" />
                    </div>';
                
            }
            ?>
            
            
        <h1 class="ProductsLabel">Cart</h1>
        <br>
        <br>
          
              
              
              <br>

        <?php 
        
        //This row variable will be used to access elements from the table in javascript to update price and quantity. it is incremented in the loop below
        $row = 0;  
        
        //Display the cart if it is not empty
        if(!empty($cartItems))
        {
            echo
                '
                    <table id="cart" class= "cart">
                     <tr>
                        
                        <th>Picture</th>
			<th>Product Name</th>
			<th>Price BHD</th>
			<th>Quantity</th>
                        <th>Remove</th>
                    </tr>';
                
            foreach ($cartItems as $data)
            {
                 //get the id of the product from the cart    
                $id = $data->ProductID;
             
                //if the quantity saved in teh cookie is empty assign 1 automatically
                if(empty($_COOKIE["Qty".$id]))
                {
                    $qty = 1;
                } 
                else
                {
                    $qty = $_COOKIE["Qty".$id]; 
                }
                
                //Initialize the product with the id to access other related data such as name and picture
                $product->initWithPid($id);
                
                if($product->getProductQuantity() > 0)
                {
                
                $Price = $product->getProductPrice()*$qty;
                
                 
              echo
                '
                 
		<tr>
                       
                        <td><img src="'.$product->getProductImage().'" alt="Product 1" class="image"></td>
			<td><a href="ViewProduct.php?pid='.$id.'" target="_blank">'.$product->getProductName().'</a></td>
			<td>'.$Price.'</td>
			<td><input type="number" name="quantity" onkeydown="return false;" onclick="updateSubTotal();" onkeydown="calcPrice('.$row.','.$Price.','.$id.');" onchange="calcPrice('.$row.','.$Price.','.$id.');" value="'.$qty.'"= min="1" max="'.$product->getProductQuantity().'"></td>
                        <td><button type="submit" name="RemoveCart" class="remove" value="'.$id.'">Remove Item</button></td>
                        
                            
		</tr>';
                
                $row++;
                
                }
            } 
        }
        
        else
        {
            echo '<h1 class="ProductsLabel">Empty</h1>';
            unset($_SESSION['Order']);
        }
        
        echo '</table>';
      
        ?>
          </form> 
            
        </div>
        

    </body>
    
    
    <script>
    
    //Calculate the price of indvidual items based on quantity
    //get the table element and access the specific row through the parameter defined in the loop above
    //The price is being passed thorugh the object because if it was accessed through the table it will return the updated price whil would lead to incorrect calculation
    
   function calcPrice(row, price, id)
    {
        var table = document.getElementById("cart");
        var qty = parseInt(document.getElementsByName("quantity")[row].value);
        var sumVal = price * qty;
        //add 1 to row because the first row is the columns name. 
        table.rows[row + 1].cells[2].innerHTML = sumVal;  
        
        //updates the cookie with the new value users chose from the quantity selector in the cart
        document.cookie = "Qty" + id + "=" + qty;
        //reloads the page to show the new value
        location.reload();
 
    }
    
    
    //loops through the 3rd column data starting from the 1st row and accessing the 3rd cell (price) for each of them
    //Adds the price and then show it on the top of the screen 
    
    function updateSubTotal() 
    {
      var table = document.getElementById("cart");
      var sumVal = 0;
     for (var i = 1; i < table.rows.length; i++) 
     {
       sumVal = sumVal + parseFloat(table.rows[i].cells[2].innerHTML);
     }

     document.getElementById("val").innerHTML =  sumVal;
     document.getElementById("TotalPrice").value = sumVal;

    }
    


    </script>
</html>

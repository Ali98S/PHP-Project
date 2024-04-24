<?php
include 'header.php';

if(empty($_SESSION['UserID']))
{
    header('Location: Login.php');
}
elseif(empty($_SESSION['Order']))
{
    header('Location: Cart.php');
}

$user = new Users();
$uid = $_SESSION['UserID'];
$user->initWithUid($uid);
$uname = $user->getUsername();
$uid = $user->getUid();
$cart = new CartClass();

$product = new Products();

foreach ($_SESSION['cart'] as $id => $item) 
{
    $name = $item['name'];
    $quantity = $item['quantity'];
}



if(isset($_POST['Purchase']))
{
    
    if (strlen($_POST['credit']) < 19)
    {
        $error = "Entrer a valid credit card number";
    }
    elseif(empty($_POST['cusname']))
    {
        $error = "Entrer the name on your card";
    }
    elseif(strlen($_POST['month']) < 5)
    {
        $error = "Entrer your card's expiration date";
    }
    elseif(strlen($_POST['cvv']) < 3)
    {
        $error = "Entrer your card's CVV";
    }
    
    else
    {
    
    //Returns the last auto generated id from DB after insert command
    $orderID = $product->InsertOrder($uname,$uid ,$_SESSION['TotalPrice'], $user->getAddress());
    
    foreach ($_SESSION['cart'] as $id => $item) 
    {
        $name = $item['name'];
        
        $quantity = $item['quantity'];
        
        $product->initWithPid($id);
        
        $cat = $product->getProductCategory();
        
        $price = $product->getProductPrice() * $quantity;
        
        $product->BuyProduct($id, $quantity);
       
        $product->InsertOrderDetails($orderID, $name, $quantity, $cat, $price);
        
        unset($_SESSION['cart'][$id]);
        unset($_SESSION['cart'][$id]['name']);
        unset($_SESSION['cart'][$id]['quantity']);
        unset($_SESSION['cart'][$id]['xQty']);
        unset($_SESSION['cart'][$id]['xName']);
        setcookie("Qty".$id, '', time() - 3600);
    }
       
    $cart->ClearCart($uid);
    unset($_SESSION['TotalPrice']);
    unset($_SESSION['Order']);
    
    header('Location: OrderIn.php');
}

}


?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Checkout</title>
        <link rel="stylesheet" href="Style.css">
    </head>
    <body>
        <div class="wrap">
            
            <div class="form-box-addprd">

                        <h1 id="LoginText">Checkout</h1>

                    <form action="Checkout.php" method="post" class="input-checkout" id="Register">
                          <div id="added"><?php echo $success ?></div>
                          <div id="error"><?php echo $error?></div>
                          <input type="text" class="input-field" name="fname" value="<?php echo $user->getFname().' '.$user->getLname();?>" disabled> 
                          <label id="profileLabel">Full Name</label>
                       
                          <input type="text" class="input-field"  name="uname" value="<?php echo $user->getAddress();?>" disabled> 
                          <label id="profileLabel">Address</label>
                          <input type="text" class="input-field" id="credit-card" name="credit" placeholder="Credit/Debit Card " value="<?php echo $_POST['credit']?>" minlength="24" maxlength = "24" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required> 
                          
                            <input type="text" class="input-field" name ="cusname" placeholder="Name on Card" value="<?php echo $_POST['cusname']?>" required>
                            <input type="text" id="exp" class="input-field" value="<?php echo $_POST['month']?>" name="month" placeholder="MM / YY" minlength="3" maxlength = "7" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required>
                            <input type="text" class="input-field" name="cvv" value="<?php echo $_POST['cvv']?>" placeholder="CVV" minlength="3" maxlength = "3" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  required>

                
                     <br>
                     <br>
                  
                     <?php 
                        
                            foreach($_SESSION['cart'] as $id => $item) 
                            {
                                $name = $item['xName'];
                                $quantity = $item['xQty'];

                                echo $name.$quantity;       
                            }
                      
                      ?>
                     <br>
                     
                     <h3><?php echo $_SESSION['TotalPrice'].'&nbsp; &nbsp;'.'BHD'?></h3>
                  
                     <button type="submit" class="submit-btn-purchase" name="Purchase" value="register">Purchase</button>
                     <input type="hidden" name="submitted_AddPr" value="1" />
                    </form>   

                    </div> 
            
            
            
            
            
            
            
        </div>
    </body>
    
    
    
    <script>
    
    //Adds space after every four characters
       const creditCardInput = document.getElementById('credit-card');
		creditCardInput.addEventListener('input', (event) => {
			const input = event.target.value.replace(/\D/g, '').substring(0,16);
			event.target.value = input.replace(/(.{4})/g, '$1 ').trim();
		});
                
    //Adds forward dash after the first two characters only
    const expInput = document.getElementById('exp');
            expInput.addEventListener('input', (event) => {
                    let input = event.target.value.replace(/\D/g, '').substring(0,4);
                    if (input.length > 2) {
                            input = input.substring(0,2) + '/' + input.substring(2);
                    }
                    event.target.value = input;
            });

    
    </script>
    
</html>

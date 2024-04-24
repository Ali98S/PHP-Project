<?php 

include 'header.php';

if (isset($_GET['pid'])) 
{
    $pid = $_GET['pid'];
} 
elseif (isset($_POST['pid'])) 
{
    $pid = $_POST['pid'];
}

$uid = $_SESSION['UserID'];

 $user = new Users();
 $user->initWithUid($uid);

$product = new Products();
$product->initWithPid($pid);

$addCart = "";
$inCart = "";

if(isset($_POST['addCart']))
{
    $cart = new CartClass();
    $qty = $_POST['Qty'];
    
    if(empty($_SESSION['UserID']))
    {
        header('Location: Login.php');
    }

    if($cart->checkCart($uid, $pid))
    {
        
     $cart->addCart($pid, $uid);
     $addCart = 'Added to cart';
     
     //Save the quantity selected in a cookie
     setcookie("Qty".$pid, $qty, time()+ 7776000);
     
    }
    else
    {
        $inCart = 'Product is already in your cart';
    }
    
   
}



if(isset($_POST['Wishlist']))
{
    if(empty($_SESSION['UserID']))
    {
        header('Location: Login.php');
    }
    
    $wishlist = new WishlistClass();
    
    if($wishlist->checkWishlist($uid, $pid))
    {
        $wishlist->addWishlist($pid, $uid);
        $addCart = 'Added to Wishlist';
    }
    else
    {
        $inCart = 'Product is already in your Wishlist';
    }
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $product->getProductName(); ?></title>
          <link rel="stylesheet" href="Style.css">
    </head>
    <body>
    <div class="wrap">
    <div class="ProductPage">
     <a href="DisplayProducts.php" style="float: Left;">Back</a>
        <form action="ViewProduct.php" method="post">
            <div class="row">
                <div class="column">
                    <img src="<?php echo $product->getProductImage();?>" alt="" width="300" height="350">
                </div>
                <div class="column">
                    <h1 name="productName"><?php echo $product->getProductName();?></h1>
                      <br>
                      <div id="error"> <?php echo $inCart?> </div>
                      <div id="added"> <?php echo $addCart?> </div>
                      <br>
                    <h2 id="productPrice" style="display: inline;" name="productPrice"><?php echo $product->getProductPrice(); ?></h2>&nbsp;<h2 style="display: inline;">BHD</h2><br>
                
                    <br>
                    <h3 style="display: inline;">Quantity: </h3>&nbsp;<input style="display: inline;" class="input-prd" onclick="calcPrice(<?php echo $product->getProductPrice();?>)" id ="qty"  type="number" name="Qty" value="1" min="1" onkeydown="return false;" max= "<?php echo $product->getProductQuantity(); ?>" required>
                    <br><br>
                    <h3 style="display: inline;">Quality: </h3>&nbsp;<h3 style="display: inline;"><?php echo $product->getProductQuality(); ?></h3>
                    <br><br>
                    <h3 style="display: inline;">Category: </h3>&nbsp;<h3 style="display: inline;"><?php echo $product->getProductCategory(); ?></h3>
                    <br><br>
                    <input type="number" name="hiddenPrice" id="hiddenPrice" value="<?php echo $product->getProductPrice(); ?>" hidden >
                    <h3>Description:</h3>
                    <br>
                    <p><?php echo $product->getProductDesc();?></p>
                    <br><br>
                    <button type="submit" class="submit-btn-prd" name="addCart" value="logout">Add to Cart</button><br>
                    <button type="submit" class="submit-btn-prd" name="Wishlist"  value="logout">Add to Wishlist</button>
                    <input type ="hidden" name="pid" value="<?php echo $product->getProductID(); ?>"/>
                </div>
            </div>
        </form>
    </div>   
</div>
       
    </body>
    
    
    <script>
    
    function calcPrice(pr)
    {
        var price = parseInt(pr);
        var quantity = parseInt(document.getElementById("qty").value);
        var total = price * quantity; 

         document.getElementById("productPrice").innerHTML =  total;
         document.getElementById("hiddenPrice").value =  total;
    }
    
    
    </script>
</html>

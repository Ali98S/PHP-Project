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
         

if (isset($_GET['pid'])) {
    $id = $_GET['pid'];
} elseif (isset($_POST['pid'])) {
    $id = $_POST['pid'];
}


$product = new Products();
$product->initWithPid($id);

$pic = $product->getProductImage();

if (isset($_POST['UpdatePr'])) {

    $product->setProductName($_POST['pname']);
    $product->setProductQuality($_POST['Quality']);
    $product->setProductQuantity($_POST['Qty']);
    $product->setProductDesc($_POST['pdesc']);
    $product->setProductCategory($_POST['Category']);
    $product->setProductPrice($_POST['pprice']);
    $product->setProductImage($product->getProductImage());

    if (empty($_FILES['ProductImageUpdate']['name'])) 
    {
       // echo 'Image not updated';
    } 
    else 
    {
        $upload = new Upload();
        $upload->setUploadDir('images/');
        $msg = $upload->upload('ProductImageUpdate');
        
        if (empty($msg)) 
        {
            unlink($product->getProductImage());
            $product->setProductImage('images/'.$upload->getFilepath());
        } 
        else 
        {
            foreach ($msg as $value) {
                echo $value;
            }
        }
    }


    if ($product->UpdateProduct($id)) {
        $success = 'Product Updated';
    }
}

elseif (isset($_POST['DeletePr'])) 
{
        
    unlink($product->getProductImage());
    
    if($product->DeleteProduct($id))
    {
         header('Location: ViewProductsAdmin.php');
    }
}


?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Update Product</title>
        <link rel="stylesheet" href="Style.css">
    </head>
    <body>
        
        
        
         <div class="wrap">

             
                        

                      <div class="form-box-addprd">
       <a href="ViewProductsAdmin.php" style="float: Left;">Back</a>
                        <h1 id="LoginText">Update or Delete Product</h1>
                          
                        <div id="added"><?php echo $success ?></div>

                    <form action="UpdateProduct.php" method="post" class="input-addprd" id="Register" enctype="multipart/form-data">
                          <div id="added"></div>
                          <div id="error"></div>
                          <input type="text" class="input-field" placeholder="Product Name" name="pname" value="<?php echo $product->getProductName();?>" required>   
                          <input type="number" class="input-field" placeholder="Product Quanitity" name="Qty" value="<?php echo $product->getProductQuantity();?>" required>
                          <input type="number" class="input-field" placeholder="Product Price BHD" name="pprice" value="<?php echo $product->getProductPrice();?>" required>  
                     <br>
                     <br>

                     <label id="qlty">Product Quality:</label>
                     <select name="Quality" id="qltydrp">
                         <option <?php if($product->getProductQuality()== 'Like New'){ echo "selected = 'selected'";}?>>Like New</option>
                            <option <?php if($product->getProductQuality()== 'Good'){ echo "selected = 'selected'";}?>>Good</option>
                            <option <?php if($product->getProductQuality()== 'Average'){ echo "selected = 'selected'";}?>>Average</option>
                      </select>

                     <label id="qlty">Product Category:</label>
                     <select name="Category" id="qltydrp">
                         <option <?php if($product->getProductCategory() == 'Furniture'){ echo "selected = 'selected'";}?>>Furniture</option>
                            <option <?php if($product->getProductCategory() == 'Electronics'){ echo "selected = 'selected'";}?>>Electronics</option>
                            <option <?php if($product->getProductCategory() == 'Tools & Hardware'){ echo "selected = 'selected'";} ?>>Tools & Hardware</option>
                            <option <?php if($product->getProductCategory() == 'Auto Parts'){ echo "selected = 'selected'";} ?>>Auto Parts</option>
                            <option <?php if($product->getProductCategory() == 'Books'){ echo "selected = 'selected'";} ?>>Books</option>
                            <option <?php if($product->getProductCategory() == 'Antiques'){ echo "selected = 'selected'";} ?>>Antiques </option>
                            <option <?php if($product->getProductCategory() == 'Other'){ echo "selected = 'selected'";} ?>>Other</option>
                      </select>
                     <br>
                     <br>

                     <textarea id="textarea" name="pdesc" rows="4" cols="50" placeholder="Product Description" required><?php echo $product->getProductDesc(); ?></textarea>
                     <br>
                     <br>
                    <label id="qlty">Product Picture:*</label>
                    <input type="file" name="ProductImageUpdate"/>
                     <br>
                     <br>
                     <button type="submit" class="submit-btn" name="UpdatePr" value="register">Update Product</button>
                     <br>
                      <button type="submit" class="submit-btn-dlt" name="DeletePr" value="register" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</button>
                     <input type="hidden" name="submitted_UpdatePr" value="1" />
                     <input type ="hidden" name="pid" value="<?php echo $product->getProductID(); ?>"/>

                     
            

                    </form>   
                        
                
                  
                        
                    </div>
                    
             
                    
             
                </div>
        
        <?php
        // put your code here
        ?>
    </body>
</html>

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
         


  if(isset($_POST['submitted_AddPr']))
    {
        
        $product = new Products();
        
        $product->setProductName($_POST['pname']);
        $product->setProductQuality($_POST['Quality']);
        $product->setProductQuantity($_POST['Qty']);
        $product->setProductDesc($_POST['pdesc']);
        $product->setProductCategory($_POST['Category']);
        $product->setProductPrice($_POST['pprice']);
        
       //Checks if an image is uploaded or not
        if(empty($_FILES['ProductImage']['name']))
        {
            $error = 'You must upload an image';
        }
        else
        {

                $upload = new Upload();
                $upload->setUploadDir('images/');
                $msg = $upload->upload('ProductImage');



                if(empty($msg))
                {
                      $product->setProductImage('images/'.$upload->getFilepath());
            
                        if($product->AddProduct())
                        {
                            $success= $product->getProductName().' '.'added successfully';
                        }
                        else
                        {
                            $error = 'An error has occured';
                        }

                }
                else
                {
                    foreach ($msg as $er) 
                  {
                    echo $er;
                  }
                
                  
                  }

          
        }
       

    }
    

 
if(!empty($_SESSION['UserID']))
    {

    $id = $_SESSION['UserID'];
    $user = new Users();
    $user->initWithUid($id);
    
        if($user->getType() != 'User')
        {
            echo
            '<html>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Add Product</title>
               <link rel="stylesheet" href="Style.css"> 

            </head>
            <body>

                <div class="wrap">



                      <div class="form-box-addprd">

                        <h1 id="LoginText">Add Product</h1>

                    <form action="AddProduct.php" method="post" class="input-addprd" id="Register" enctype="multipart/form-data">
                          <div id="added">'.$success.'</div>
                          <div id="error">'.$error.'</div>
                     <input type="text" class="input-field" placeholder="Product Name" name="pname" value="'.$_POST['pname'].'" required>   
                     <input type="number" class="input-field" placeholder="Product Quanitity" name="Qty" value="'.$_POST['Qty'].'" required>
                     <input type="number" class="input-field" placeholder="Product Price BHD" name="pprice" value="'.$_POST['pprice'].'"required>  
                     <br>
                     <br>

                     <label id="qlty">Product Quality:</label>
                     <select name="Quality" id="qltydrp">
                            <option>Like New</option>
                            <option>Good</option>
                            <option>Average</option>
                      </select>

                     <label id="qlty">Product Category:</label>
                     <select name="Category" id="qltydrp">
                            <option>Furniture</option>
                            <option>Electronics</option>
                            <option>Tools & Hardware</option>
                            <option>Auto Parts</option>
                            <option>Books</option>
                            <option>Antiques</option>
                            <option>Other</option>
                      </select>
                     <br>
                     <br>

                     <textarea id="textarea" name="pdesc" rows="4" cols="50" placeholder="Product Description" value="'.$_POST['pdesc'].'"required></textarea>
                     <br>
                     <br>
                    <label id="qlty">Product Picture:*</label>
                    <input type="file" name="ProductImage" value="" />
                     <br>
                     <br>
                     <button type="submit" class="submit-btn-reg" name="AddPr" value="register">Add Product</button>
                     <input type="hidden" name="submitted_AddPr" value="1" />
                    </form>   

                    </div>
                    
                </div>';
        }
        
        
        else
            {
                echo
                 '<div class ="wrap">'
                                .'<div class="form-box-login">'
                                .'<h1 id="LoginText">Login</h1>'
                                .'<form action="Login.php" method="post" class="input-login" id="Login">'
                                . '<h1 id="LoginText">Please Login with an admin account</h1> <br> <br>'

                                . ' <button type="submit" class="submit-btn" value="logout">Login</button>'
                                        .'<input type="hidden" name="submitted_Logout" value="1" />'
                                       . '</div>'
                                        . '</div>';
            }
      
    }
    
    else
    {
         echo
                 '<div class ="wrap">'
                                .'<div class="form-box-login">'
                                .'<h1 id="LoginText">Login</h1>'
                                .'<form action="Login.php" method="post" class="input-login" id="Login">'
                                . '<h1 id="LoginText">Please Login with an admin account</h1> <br> <br>'

                                . ' <button type="submit" class="submit-btn" value="logout">Login</button>'
                                        .'<input type="hidden" name="submitted_Logout" value="1" />'
                                       . '</div>'
                                        . '</div>';
    }
    
    
?>

    </body>
</html>

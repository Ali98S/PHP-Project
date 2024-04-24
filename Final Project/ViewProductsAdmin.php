<?php

include 'header.php';

$product = new Products();
$items = $product->getAllProducts();

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
         




if(isset($_POST['Sort']))
{
    
    $category = $_POST['CatBox'];
    $sort = $_POST['SortBox'];
    $qlty = $_POST['QualityBox'];

    $ViewBy = "Browsing: ".$category; 
    $SortBy = "Sort By: ".$sort;
    $DisplayQuality = "Items Quality: ".$qlty;
    
 
        
        $items = $product->getFilteredProducts($category, $sort, $qlty);
        
        if($items == null)
        {
           $noresults = ' <h1 class="ProductsLabel">No items found</h1>';
        }
        else
        {
            $noresults = "";
        }
    
}




if(isset($_POST['Search']))
{
    $query = $_POST['SearchBox'];
   
    $items = $product->SearchProduct($query);
    
    if($items == null)
        {
           $noresults = ' <h1 class="ProductsLabel">No items found</h1>';
        }
        else
        {
            $noresults = '<h1 class="ProductsLabel">Showing Results For ' . $query . '.</h1>';
        }
}


?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>View Products Admin</title>
        <link rel="stylesheet" href="Style.css">
        
    </head>
    <body>
        
        
        <div class="wrap">
            
            <form action="DisplayProducts.php" method="post">
             <div class="search">
                         <input type="search" id="Search" class="query" name="SearchBox" placeholder="Search..." value="<?php echo $query; ?>">
                         <button type="submit" class="ApplySearch" name="Search" value="Search">Search</button>
                         
                     </div>
                
            </form>
            
            
        <h1 class="ProductsLabel">Edit Products</h1>
            
            
                   
                <div class="Sort-Filter">
                    
                    
                    <form action="ViewProductsAdmin.php" method="post">
                        
                    <label id="CatText">Browse by category:</label>
                  <select name="CatBox" id="Category" value="<?php echo $category?>">
                        <option <?php if(isset($_POST['CatBox']) &&  $_POST['CatBox'] == 'All Categories') {echo "selected = 'selected'";}?> >All Categories</option>
                        <option <?php if(isset($_POST['CatBox']) && $_POST['CatBox'] == 'Antiques') {echo "selected = 'selected'";}?>>Antiques</option>
                        <option <?php if(isset($_POST['CatBox']) && $_POST['CatBox'] == 'Auto Parts') {echo "selected = 'selected'";}?>>Auto Parts</option>
                            <option <?php if(isset($_POST['CatBox']) && $_POST['CatBox'] == 'Books') {echo "selected = 'selected'";}?>>Books</option>
                             <option <?php if(isset($_POST['CatBox']) && $_POST['CatBox'] == 'Electronics') {echo "selected = 'selected'";}?>>Electronics</option>
                          <option <?php if(isset($_POST['CatBox']) && $_POST['CatBox'] == 'Furniture'){ echo "selected = 'selected'";}?>>Furniture</option>
                          <option <?php if(isset($_POST['CatBox']) && $_POST['CatBox'] == 'Tools & Hardware') {echo "selected = 'selected'";}?>>Tools & Hardware</option>
                           <option <?php if(isset($_POST['CatBox']) && $_POST['CatBox'] == 'Other') {echo "selected = 'selected'";}?>>Other</option>
                      </select>
                    
                    
                     <label id="CatText">Quality:</label>
                    <select name="QualityBox" id="Category" value="">
                         <option <?php if(isset($_POST['QualityBox']) &&  $_POST['QualityBox'] == 'Default') {echo "selected = 'selected'";}?>>Default</option>
                            <option <?php if(isset($_POST['QualityBox']) &&  $_POST['QualityBox'] == 'Like New') {echo "selected = 'selected'";}?>>Like New</option>
                            <option <?php if(isset($_POST['QualityBox']) &&  $_POST['QualityBox'] == 'Good') {echo "selected = 'selected'";}?>>Good</option>
                            <option <?php if(isset($_POST['QualityBox']) &&  $_POST['QualityBox'] == 'Average') {echo "selected = 'selected'";}?>>Average</option>
                      </select>
                    
                    

                     <label id="CatText">Sort By:</label>
                     <select name="SortBox" id="Sort" value="<?php echo $sort?>">
                            <option <?php if(isset($_POST['SortBox']) &&  $_POST['SortBox'] == 'Default') {echo "selected = 'selected'";}?> >Default</option>
                            <option <?php if(isset($_POST['SortBox']) &&  $_POST['SortBox'] == 'A-Z') {echo "selected = 'selected'";}?> >A-Z</option>
                            <option <?php if(isset($_POST['SortBox']) &&  $_POST['SortBox'] == 'Z-A') {echo "selected = 'selected'";}?> >Z-A</option>
                            <option <?php if(isset($_POST['SortBox']) &&  $_POST['SortBox'] == 'Price: High-Low') {echo "selected = 'selected'";}?> >Price: High-Low</option>
                            <option <?php if(isset($_POST['SortBox']) &&  $_POST['SortBox'] == 'Price: Low-High') {echo "selected = 'selected'";}?> >Price: Low-High</option>
                      </select>
                     
                     <button type="submit" class="Apply" name="Apply" value="apply">Apply</button>
                     
                     <input type="hidden" name="Sort" value="" />
                     
                     </form>
                    
                </div>
            
         
         <?php echo $noresults?>
            
       <div class="grid-container">
        <?php
        // put your code here
        
        
             if(is_array($items))
                {
                 
               
                    foreach ($items as $data)
                    {
                         $id = $data->ProductID;
                         $pname = $data->ProductName;
                         $cat = $data->ProductCategory;
                         $img = $data->ProductImage;
                         $qty = $data->ProductQuantity;
                   
                         if($qty == 0)
                         {
                            $OFS = '<p style="color:red;">Out of Stock <br>';
                            
                         }
                         else
                         {
                             $OFS = '';
                         }
                     
                     echo '<div class="grid-item">'
                         . '<img src="'.$img.'" alt="" width="250" height="300"> <br>'
                            .$pname.''
                             . '<br>Category: '.$cat.'<br>'
                             . 'ID: '.$id.'<br>'
                             . $OFS
                             . '<b><a href="UpdateProduct.php?pid='.$id.'" target="_blank"> Edit </a></b> </div>';   
                    }
                
                }
        
        
        ?>
            
            
           
            </div>
            
            </div>
    </body>
</html>

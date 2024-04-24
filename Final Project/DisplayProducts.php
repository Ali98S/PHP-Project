<?php

include 'header.php';
//include 'header.html';

$product = new Products();
$items = $product->getAllProducts();

$admin = new Admin();



if(isset($_POST['Sort']))
{
    
    $category = $_POST['CatBox'];
    $sort = $_POST['SortBox'];
    $qlty = $_POST['QualityBox'];
    
        
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
   
    if(isset($_POST['standardSearch']))
    {
       
        $items = $product->SearchProduct($query);
    
        if($items == null)
        {
           $noresults = ' <h1 class="ProductsLabel">No items found</h1>';
        }
        else
        {
            $noresults = '<h3 class="ProductsLabel">Showing Results For ' . $query . '</h3>';
        }
    }
    
    elseif(isset($_POST['advancedSearch']))
    {

        $items = $product->AdvancedSearchProduct($query);
    
        if($items == null)
        {
           $noresults = ' <h1 class="ProductsLabel">No items found</h1>';
        }
        else
        {
            $noresults = '<h3 class="ProductsLabel">Showing Results For ' . $query . '</h3>';
            $adv = true;
        }
    }
    
}


?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Products</title>
       <link rel="stylesheet" href="Style.css">
    </head>
    <body>
        
        
        <div class ="wrap">
            
            <form action="DisplayProducts.php" method="post">
                <div class="search" >
                         <input type="search" id="Search" class="query" name="SearchBox" placeholder="Search..." value="<?php echo $query; ?>">
                         <button type="submit" class="ApplySearch" name="Search" value="Search" >Search</button><br>
                         <input type="radio" id="std-search" name="standardSearch" value="standard" 
                             <?php if(!isset($_POST['Search'])){echo 'checked="chekced"';} elseif(isset($_POST['standardSearch'])){echo 'checked="checked"';} ?> >
                         <label for="html">Standard</label> &nbsp;
                         <input type="radio" id="adv-search" name="advancedSearch" value="advanced" <?php if(isset($_POST['advancedSearch'])){echo 'checked="checked"';} ?>>
                            <label for="css">Advanced</label><br>

                     </div>
                
            </form>
                   
            <h1 class="ProductsLabel">Products</h1>   
            
                   
                <div class="Sort-Filter">
                    
                    
                    <form action="DisplayProducts.php" method="post">
                        
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
                  
                if(is_array($items))
                {
                    foreach ($items as $data)
                    {
                        
                        $id = $data->ProductID;
                        $name = $data->ProductName;
                        $price = $data->ProductPrice;
                        $quality = $data->ProductQuality;
                        $category = $data->ProductCategory;
                        $quantity = $data->ProductQuantity;
                        
                        if($quantity > 0)
                        {
                        
                            echo '<div class="grid-item">'
                                .'<img src="'.$data->ProductImage.'" alt=""> <br> <b>'
                                .$name.'</b><br>'
                                .$price.' BHD <br> '
                                . 'Quality: '.$quality.'<br> Category: '.$category
                                .'<br>'
                                . 'Item ID: '.$id
                               .'<br> <a href="ViewProduct.php?pid='.$id.'" target="_blank">View Product</a>'
                                    . '</div>';
                        
                        }
                    } 
                }
                
                ?>
            
              
               
               
            </div>
          
        </div>
          

      
    </body>
    
    <script>
    
    var stdSearch = document.getElementById("std-search");
    var advSearch = document.getElementById("adv-search");

    stdSearch.addEventListener("click", function() 
    {
      if (stdSearch.checked) {
        advSearch.checked = false;
      }
    });

    advSearch.addEventListener("click", function() 
    {
      if (advSearch.checked) {
        stdSearch.checked = false;
      }
    });
    
    </script>

    
</html>

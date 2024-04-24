<?php

class Products {

    //put your code here

    private $ProductID;
    private $ProductName;
    private $ProductDesc;
    private $ProductPrice;
    private $ProductCategory;
    private $ProductQuality;
    private $ProductQuantity;
    private $ProductImage;

    function __construct() {
        $this->ProductID = null;
        $this->ProductName = null;
        $this->ProductDesc = null;
        $this->ProductPrice = null;
        $this->ProductCategory = null;
        $this->ProductQuality = null;
        $this->ProductQuantity = null;
        $this->ProductImage = null;
    }

    public function getProductID() {
        return $this->ProductID;
    }

    public function getProductName() {
        return $this->ProductName;
    }

    public function getProductDesc() {
        return $this->ProductDesc;
    }

    public function getProductPrice() {
        return $this->ProductPrice;
    }

    public function getProductCategory() {
        return $this->ProductCategory;
    }

    public function getProductQuality() {
        return $this->ProductQuality;
    }

    public function getProductQuantity() {
        return $this->ProductQuantity;
    }

    public function getProductImage() {
        return $this->ProductImage;
    }

    public function setProductID($ProductID): void {
        $this->ProductID = $ProductID;
    }

    public function setProductName($ProductName): void {
        $this->ProductName = $ProductName;
    }

    public function setProductDesc($ProductDesc): void {
        $this->ProductDesc = $ProductDesc;
    }

    public function setProductPrice($ProductPrice): void {
        $this->ProductPrice = $ProductPrice;
    }

    public function setProductCategory($ProductCategory): void {
        $this->ProductCategory = $ProductCategory;
    }

    public function setProductQuality($ProductQuality): void {
        $this->ProductQuality = $ProductQuality;
    }

    public function setProductQuantity($ProductQuantity): void {
        $this->ProductQuantity = $ProductQuantity;
    }

    public function setProductImage($ProductImage): void {
        $this->ProductImage = $ProductImage;
    }

    private function initWith($ProductID, $ProductName, $ProductDesc, $ProductPrice, $ProductCategory, $ProductQuality, $ProductQuantity, $ProductImage) {

        $this->ProductID = $ProductID;
        $this->ProductName = $ProductName;
        $this->ProductDesc = $ProductDesc;
        $this->ProductPrice = $ProductPrice;
        $this->ProductCategory = $ProductCategory;
        $this->ProductQuality = $ProductQuality;
        $this->ProductQuantity = $ProductQuantity;
        $this->ProductImage = $ProductImage;

    }

    function AddProduct() {
        try {
            $db = Database::getInstance();
            $q = "INSERT INTO Products_FP (ProductID, ProductName, ProductDesc, ProductPrice, ProductCategory, ProductQuality, ProductQuantity, ProductImage) "
                    . "VALUES (NULL, '$this->ProductName', '$this->ProductDesc', '$this->ProductPrice', '$this->ProductCategory', '$this->ProductQuality', '$this->ProductQuantity', '$this->ProductImage')";

            $data = $db->querySql($q);

            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    
    
    function DeleteProduct($id)
    {
        $db = Database::getInstance();
        $q = "Delete from Products_FP WHERE ProductID = ". $id;
        try
        {
            $data = $db->querySql($q);
            return true;
        }
        catch(Exception $e)
        {
            echo $e;
            return false;
        }
    }
    
    
    
    function SearchProduct($value)
    {
        $db = Database::getInstance();
        //$q = "Select * FROM Products_FP WHERE ProductName LIKE '%$value%' OR ProductDesc LIKE '%$value%'";
        $q = "Select * FROM Products_FP WHERE ProductName LIKE '%$value%'";
        $data = $db->multiFetch($q);
        return $data;
        
    }
    
      function AdvancedSearchProduct($value)
    {
        $db = Database::getInstance();
        $q = "Select * FROM Products_FP WHERE ProductName LIKE '%$value%' OR ProductDesc LIKE '%$value%'";
        $data = $db->multiFetch($q);
        return $data;
        
    }
    

    public function UpdateProduct($id) {
        $db = Database::getInstance();
        try {
            $q = "UPDATE Products_FP SET ProductName = '$this->ProductName', ProductDesc = '$this->ProductDesc', ProductPrice = '$this->ProductPrice', ProductCategory = '$this->ProductCategory', "
                    . "ProductQuality = '$this->ProductQuality', ProductQuantity = '$this->ProductQuantity', ProductImage = '$this->ProductImage' WHERE ProductID = ". $id;
           
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    public function initWithPid($id) {

        $db = Database::getInstance();
        $q = 'SELECT * FROM Products_FP WHERE ProductID = ' . $id;
        $data = $db->singleFetch($q);
       // echo $data->ProductID;
        $this->initWith($data->ProductID, $data->ProductName, $data->ProductDesc, $data->ProductPrice,
                $data->ProductCategory, $data->ProductQuality, $data->ProductQuantity, $data->ProductImage);
    }

    //Returns all products from the Database

    function getAllProducts() {
        $db = Database::getInstance();
        $data = $db->multiFetch('Select * from Products_FP');
        return $data;
    }

    //Returns products based on parameters set by the user

    function getFilteredProducts($category, $sort, $quality) {
        $db = Database::getInstance();

        $cat = false;

        $q = "Select * from Products_FP ";

        //Checks if the user selected specific category or not
        if ($category != 'All Categories') {
            //Searches for the specific item category if the user selected one
            //notes if the user selected a category in order to prepare the proper sql command in the quality section

            $q .= "WHERE ProductCategory = '$category'";
            $cat = true;
        }

        //Searches for items based on the quality
        //prepares the proper command based on if the user chose a category or not
        if ($quality != 'Default') {
            if ($cat) {

                $q .= " AND ProductQuality = '$quality'";
            } else {
                $q .= " WHERE ProductQuality = '$quality'";
            }
        }


        //Assign the sorting option if the user selected something other than the default
        if ($sort != 'Default') {
            if ($sort == 'A-Z') {
                $q .= " ORDER BY ProductName ASC";
            } elseif ($sort == 'Z-A') {
                $q .= " ORDER BY ProductName DESC";
            } elseif ($sort == 'Price: High-Low') {
                $q .= " ORDER BY ProductPrice DESC";
            } elseif ($sort == 'Price: Low-High') {
                $q .= " ORDER BY ProductPrice ASC";
            }
        }


        $data = $db->multiFetch($q);
        return $data;
    }
    
    
    
    
    function BuyProduct($pid, $qty)
    {
        $db = Database::getInstance();
        $q = "UPDATE Products_FP SET ProductQuantity = ProductQuantity - '$qty' WHERE ProductID = '$pid'";
        try
        {
           $data = $db->querySql($q);
            return true;
        }
        catch(Exception $e)
        {
            echo $e;
            return false;
        }

    }
    
    
    function InsertOrder($username, $uid, $price, $address)
    {
        $date = date('Y-m-d');
        
        $db = Database::getInstance();
        $q = "INSERT INTO Orders_FP (OrderID, Username, Date, TotalPrice, Address, UserID) VALUES (NULL,'$username','$date','$price','$address', '$uid')";
       
        try
        {
           $data = $db->querySql($q);
            return mysqli_insert_id($db->dblink);
        }
        catch(Exception $e)
        {
            echo $e;
            return false;
        }
    }
    
    function InsertOrderDetails($orderid, $pname, $quantity, $category, $price)
    {
       
        $db = Database::getInstance();
        $q = "INSERT INTO OrderDetails_FP(OrderDetailsID, OrderID, ProductName, Quantity, Category, Price) VALUES (NULL,'$orderid','$pname','$quantity', '$category', '$price')";
        
        try
        {
           $data = $db->querySql($q);
            return true;
        }
        catch(Exception $e)
        {
            echo $e;
            return false;
        }
    }
    

}

?>
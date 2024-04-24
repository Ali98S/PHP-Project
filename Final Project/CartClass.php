<?php

class CartClass 
{
    //put your code here
    
    private $CartID;
    private $UserID;
    private $ProductID;
    private $Quantity;
    
    
    function __construct() 
    {
        
     $this->CartID = null;
     $this->UserID = null;
     $this->ProductID = null;
     $this->Quantity = null;
          
    }

    public function getCartID() {
        return $this->CartID;
    }

    public function getUserID() {
        return $this->UserID;
    }

    public function getProductID() {
        return $this->ProductID;
    }

    public function getQuantity() {
        return $this->Quantity;
    }

    public function setCartID($CartID) {
        $this->CartID = $CartID;
    }

    public function setUserID($UserID) {
        $this->UserID = $UserID;
    }

    public function setProductID($ProductID) {
        $this->ProductID = $ProductID;
    }

    public function setQuantity($Quantity) {
        $this->Quantity = $Quantity;
    }

    
    function DisplayCart($uid)
    {
        $db = Database::getInstance();
        $q = "SELECT * FROM Cart_FP Where UserID = ".$uid; 
       // $q = "SELECT ProductImage, ProductName, Quantity FROM Products_FP JOIN Cart_FP ON Products_FP.ProductID = Cart_FP.ProductID WHERE Cart_FP.UserID = ".$uid ;
        $data = $db->multiFetch($q);
        return $data;
    }
  
    //Add new items to cart
    
    function addCart($pid, $uid)
    {
        try
        {
           $db = Database::getInstance();
            $q = "INSERT INTO Cart_FP(CartID, ProductID, UserID) VALUES (NULL, $pid, $uid)";
            $data = $db->querySql($q);
            return true;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            return false;
        }
        
    }
    
    //Checks if an item that a user selected is in the cart
   
    function checkCart($uid, $pid)
    {
        $db = Database::getInstance();
        $q = "SELECT ProductID FROM Cart_FP Where UserID = ".$uid." AND ProductID = ".$pid; 
        
        $data = $db->singleFetch($q);
        
        if(empty($data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    
    
    function removeItem($uid, $pid)
    {
        try
        {
            $db = Database::getInstance();
            $q = "Delete FROM Cart_FP Where UserID = ".$uid." AND ProductID = ".$pid;
            $data = $db->querySql($q);
            return true;  
        }
        catch(Exception $ex)
        {
            echo $ex;
            return false;
        }
    }
    
    
    
    function ClearCart($uid)
    {
        try
        {
            $db = Database::getInstance();
            $q = "Delete FROM Cart_FP Where UserID = ".$uid;
            $data = $db->querySql($q);
            return true;  
        }
        catch(Exception $ex)
        {
            echo $ex;
            return false;
        }
    }
    
    
}

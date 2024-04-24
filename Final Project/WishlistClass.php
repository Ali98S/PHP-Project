<?php

class WishlistClass {
    //put your code here
    
    private $WishID;
    private $UserID;
    private $ProductID;
    
    function __construct() 
    {
        
     $this->$WishID = null;
     $this->UserID = null;
     $this->ProductID = null;
          
    }
    
     function DisplayWishlit($uid)
    {
        $db = Database::getInstance();
        $q = "SELECT * FROM Wishlist_FP Where UserID = ".$uid; 
       // $q = "SELECT ProductImage, ProductName, Quantity FROM Products_FP JOIN Cart_FP ON Products_FP.ProductID = Cart_FP.ProductID WHERE Cart_FP.UserID = ".$uid ;
        $data = $db->multiFetch($q);
        return $data;
    }
  
    //Add new items to cart
    
    function addWishlist($pid, $uid)
    {
        try
        {
           $db = Database::getInstance();
            $q = "INSERT INTO Wishlist_FP(WishlistID, ProductID, UserID) VALUES (NULL, $pid, $uid)";
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
   
    function checkWishlist($uid, $pid)
    {
        $db = Database::getInstance();
        $q = "SELECT ProductID FROM Wishlist_FP Where UserID = ".$uid." AND ProductID = ".$pid; 
        
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
    
    
    
    function removeWishlist($uid, $pid)
    {
        try
        {
            $db = Database::getInstance();
            $q = "Delete FROM Wishlist_FP Where UserID = ".$uid." AND ProductID = ".$pid;
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

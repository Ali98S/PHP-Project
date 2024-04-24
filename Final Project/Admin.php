<?php

class Admin extends Users {
    //put your code here
     
    public function __construct() {
        parent::__construct();
    }
    
    function AddAdmin()
    {
        $fname = $this->getFname();
        $lname = $this->getLname();
        $username = $this->getUsername();
        $password = $this->getPassword();
        $email = $this->getEmail();
        $address = $this->getAddress();
        
          try 
            {
                $db = Database::getInstance();
                $q = "INSERT INTO Users_FP (UserID, Fname, Lname, Username, password, email, Address,Status, Type) "
                ."VALUES (NULL, '$fname', '$lname', '$username', '$password', '$email','$address','Active', 'Admin')";       
                
                $data = $db->querySql($q);
                return true;
            } 
            catch (Exception $e) 
            {
                echo 'Exception: ' . $e;
                return false;
            }
    }
    
    
     function UsersCount()
    {
        $db = Database::getInstance();
        $q = 'Select * from Users_FP'; 
        $data = $db->multiFetch($q);
        return COUNT($data);
    }
    
    
     function getAllusers($start, $end) 
     {
        $db = Database::getInstance();
        
        $q = 'Select * from Users_FP';
        $q .= ' limit ' . $start . ',' . $end;        
        $data = $db->multiFetch($q);
        return $data;

    }
    
    
    function ReActivateUser($uid)
    {
         $db = Database::getInstance();
         $q = "Update Users_FP SET Status = 'Active' WHERE UserID = ".$uid;
         
         //echo $q;
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
    
    
    
    function getSpecificUsers($username)
    {
        $db = Database::getInstance();
        
        $q = "Select * from Users_FP WHERE Username = '$username'";
   
      //  echo $q;
        
        $data = $db->multiFetch($q);
        return $data;
    }
    
    function OrderCount()
    {
        $db = Database::getInstance();
        $q = 'Select * from Orders_FP'; 
        $data = $db->multiFetch($q);
        return count($data);
    }
    
    function ViewOrder($start, $end)
    {
        $db = Database::getInstance();
        $q = 'Select * from Orders_FP ORDER BY OrderID DESC';
        $q.= " limit $start, $end"; 
        $data = $db->multiFetch($q);
        return $data;
    }
    
    
    
}

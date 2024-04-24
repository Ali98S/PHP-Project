<?php


class SalesDetails 
{
    //put your code here
     
    function getTotalSales() 
     {
        $db = Database::getInstance();
        $data = $db->SingleFetch('SELECT SUM(TotalPrice) AS TOTALSALES FROM Orders_FP');
        return $data->TOTALSALES;
    }
    
    
    function bestSellingCat()
    {
        $db = Database::getInstance();
        $data = $db->MultiFetch('SELECT Category, COUNT(*) AS TOTALSALES FROM OrderDetails_FP GROUP BY Category ORDER BY COUNT(*) DESC LIMIT 1');
        return $data;
    }
    
    function worstSellingCat()
    {
        $db = Database::getInstance();
        $q = 'SELECT Category, COUNT(*) AS TOTALSALES FROM OrderDetails_FP GROUP BY Category ORDER BY COUNT(*) ASC LIMIT 1';

        $data = $db->MultiFetch($q);
        return $data;
    }
    
    
    
    function mostMoneyCat()
    {
        $db = Database::getInstance();
        $data = $db->MultiFetch('SELECT Category, SUM(Price) AS TOTALPRICE FROM OrderDetails_FP GROUP BY Category ORDER BY SUM(Price) DESC LIMIT 1');
        return $data;
    }
    
    function getUsersCount()
    {
        $db = Database::getInstance();
        $data = $db->SingleFetch("Select COUNT(UserID) AS ActiveUsers from Users_FP WHERE Status = 'Active'");
        return $data->ActiveUsers;
    }
    
    function getUsersCountDeactive()
    {
        $db = Database::getInstance();
        $data = $db->SingleFetch("Select COUNT(UserID) AS DeactiveUsers from Users_FP WHERE Status = 'Deactive'");
        return $data->DeactiveUsers;
    }
}



?>
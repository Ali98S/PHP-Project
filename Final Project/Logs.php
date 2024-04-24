<?php

class Logs {
    //put your code here
    
    private $logID;
    private $date;
    private $status;
    private $username;
    
    
    public function getLogID() {
        return $this->logID;
    }

    public function getDate() {
        return $this->date;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setLogID($logID): void {
        $this->logID = $logID;
    }

    public function setDate($date): void {
        $this->date = $date;
    }

    public function setStatus($status): void {
        $this->status = $status;
    }

    public function setUsername($username): void {
        $this->username = $username;
    }


    
     function clearLogs() {
        try {
            $db = Database::getInstance();
            $data = $db->querySql("Delete from Logs_FP");
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    function addLog($uname, $status, $date, $time)
    {
        
        try 
        {
            $q = "Insert into Logs_FP (logID, username, status, date, time) values (NULL, '$uname', '$status', '$date', '$time')";
            $db = Database::getInstance();
            $data = $db->querySql($q);
            return true;
        } 
            
        catch (Exception $e) 
            
        {
            echo 'Exception: ' . $e;
            return false;
        }
        
    }
    
    function getLogsCount()
    {
        $db = Database::getInstance();
        $q = "SELECT * FROM Logs_FP"; 
        $data = $db->multiFetch($q);
        return COUNT($data);
    }
    
    
    
    function DisplayLogs()
    {
        $db = Database::getInstance();
        $q = "SELECT * FROM Logs_FP";
       
         
        $data = $db->multiFetch($q);
        return $data;
    }
    
     function DisplaySpecificLogs($lstart, $lend)
    {
  
        $db = Database::getInstance();
        $q = "SELECT * FROM Logs_FP ORDER BY logID DESC"; 
        
    
        
        $q .= ' limit ' . $lstart . ',' . $lend;
         
       // echo $q;
        
        $data = $db->multiFetch($q);
        return $data;
    }
    
    
    
    
    
}
?>
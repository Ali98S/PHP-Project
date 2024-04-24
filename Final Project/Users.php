<?php

class Users {
    //put your code here
    
    private $uid;
    private $username;
    private $fname;
    private $lname;
    private $type;
    private $status;
    private $email;
    private $password;
    private $address;

    function __construct() {
        $this->uid = null;
        $this->username = null;
        $this->fname = null;
        $this->lname = null;
        $this->status = null;
        $this->password = null;
        $this->email = null;
        $this->type = null;
        $this->address = null;
    }

    public function getUid() {
        return $this->uid;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getFname() {
        return $this->fname;
    }

    public function getLname() {
        return $this->lname;
    }

    public function getType() {
        return $this->type;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setUid($uid): void {
        $this->uid = $uid;
    }

    public function setUsername($username): void {
        $this->username = $username;
    }

    public function setFname($fname): void {
        $this->fname = $fname;
    }

    public function setLname($lname): void {
        $this->lname = $lname;
    }

    public function setType($type): void {
        $this->type = $type;
    }

    public function setStatus($status): void {
        $this->status = $status;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    
    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address): void {
        $this->address = $address;
    }

    
    public function initWithUid($uid) {

        $db = Database::getInstance();
        $q = 'SELECT * FROM Users_FP WHERE UserID = ' . $uid;

        $data = $db->singleFetch($q);
        $this->initWith($data->UserID, $data->Username, $data->Password, $data->Email, $data->Fname, $data->Lname, $data->Status, $data->Type, $data->Address);
    
        }
    
    
     function deleteuser($uid) {
        try {
            $db = Database::getInstance();
            $data = $db->querySql('Delete from Users_FP where UserID=' . $uid);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    
    function checkUser($username, $password) {
        $db = Database::getInstance();
        $q = 'SELECT * FROM Users_FP WHERE Username = \'' . $username . '\' AND Password = \'' . $password . '\''; 
 
        $data = $db->singleFetch($q);
        
        //Compares the password thst user supplied to the one in database to chaeck for case sensitivity
        $pswdComp = strcmp($data->Password, $password);
        
        //Return true if user data is available and if the user supplied password is matching (case sensitivity and value) to the one in the databse
        
        if($data != null && $pswdComp === 0)
        {
            $this->initWith($data->UserID, $data->Username, $data->Password, $data->Email, $data->Fname, $data->Lname, $data->Status, $data->Type, $data->Address);
            return true;
        }
        else
        {
            return false;
        }
    }
    
    
    
     function checkUsername($uname) 
     {

        $db = Database::getInstance();

        $q = "SELECT Username FROM Users_FP WHERE username = '$uname' AND UserID <> ".$this->getUid();
        
        $data = $db->singleFetch($q);
        if ($data != null) 
        {
            return false;
        }
        return true;
    }
    
    

     function initWithUsername() {

        $db = Database::getInstance();

        $q = 'SELECT * FROM Users_FP WHERE username = \'' . $this->username . '\'';
        
        
        $data = $db->singleFetch($q);
        if ($data != null) {
            return false;
        }
        return true;
    }
    
    
    
    //This function allow the user to submit the update function only if they are the owners of that particular username
    //Since the system checks for unique usernames. Users who may tryo to update something other than the Username may be prevented as there is a record of that Username in the database
    //This function will check if the Username submitted belongs to the user or not and will react accordingly
    
    function checkUpdateUsername()
    {
        $db = Database::getInstance();
        $q = 'Select Username from Users_FP WHERE UserID= '.$this->getUid();
        
        $data = $db->singleFetch($q);
        
       if($data->Username == $this->username)
       {
           return true;
       }
        return false;
    }
    
    
    //This function allow the user to submit the update function only if they are the owners of that particular Email
    //Since the system checks for unique emails. Users who may change something other than the Username may be prevented as there is a record of that email in the database
    //This function will check if the emails submitted belongs to the user or not and will react accordingly
    
    function checkUpdateEmail()
    {
        $db = Database::getInstance();
        $q = "SELECT Email FROM Users_FP WHERE UserID = ".$this->getUid();
        
        $data = $db->singleFetch($q);
        
        if ($data->Email == $this->email) 
        {
             return true;
        }
           return false;
    }
    
    
     //Check for emails where the user id does not belong to the user this is so that users can update the email. this function is used mainly for registered users and not new users 
     //Because it requires an userd it to be compared against. If it returns empty with no email associated then users can update their email to that in question
    
    function checkEmail($email)
    {
        $db = Database::getInstance();
        $q = "SELECT Email FROM Users_FP WHERE Email = '$email' AND UserID <> ".$this->getUid();
        
        
        $data = $db->singleFetch($q);
        if ($data == null) 
        {
             return true;
        }
        else
        {
             return false;
        }
          
    }
    
    
    //This function is used to check the email availabily for new users. it checks generally for a specific email that new users chose. 
    
    function emailCheckNewUser($email)
    {
        $db = Database::getInstance();
        $q = "SELECT Email FROM Users_FP WHERE Email = '$email'";
        
        $data = $db->singleFetch($q);
        if ($data == null) 
        {
             return true;
        }
        else
        {
             return false;
        }
    }
    
    
    
   
    function UpdateUser()
    {
        $db = Database::getInstance();
        $q = "UPDATE Users_FP SET Username = '$this->username', Fname = '$this->fname', Lname = '$this->lname', "
                . "Email = '$this->email', Password = '$this->password', Address = '$this->address' WHERE UserID = ".$this->uid;
        
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
    

    function DeactivateUser($uid)
    {
         $db = Database::getInstance();
         $q = "Update Users_FP SET Status = 'Deactive' WHERE UserID = ".$uid;
         
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
    
    
   
    
     private function initWith($uid, $username, $password, $email, $fname, $lname, $status, $type, $address) {
         
        $this->uid = $uid;
        $this->username = $username;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->status = $status;
        $this->password = $password;
        $this->email = $email;
        $this->type = $type;
        $this->address = $address;
    }
    
    
    function RegisterUser()
    {
        try {
                $db = Database::getInstance();
                $q = "INSERT INTO Users_FP (UserID, Fname, Lname, Username, password, email, address, Status, Type) "
                . "VALUES (NULL, '$this->fname', '$this->lname', '$this->username', '$this->password', '$this->email', '$this->address', 'Active', 'User')";        
                $data = $db->querySql($q);
                return true;
            } 
            catch (Exception $e) 
            {
                echo 'Exception: ' . $e;
                return false;
            }
    }
    
    
    //If the user credetials exist and are correct grant access to the system and save some data in the session varable in order to know if user is looged in or not
    function Login()
    {
        $this->checkUser($this->getUsername(), $this->getPassword());
        
        if ($this->getUid() != null) 
        {
            $_SESSION['UserID'] = $this->getUid();
            $_SESSION['Username'] = $this->getUsername();
  
             
            return true;
        }
        
        else
        {
            return false;
        }
        
        
    }
    
    function orderCount()
    {
        $db = Database::getInstance();
        $q = 'Select * from Orders_FP WHERE UserID = '.$this->uid; 
        $data = $db->multiFetch($q);
        return count($data);
    }


    function ViewOrder($start, $end, $uid)
    {
        $db = Database::getInstance();
        $q = 'Select * from Orders_FP WHERE UserID = '.$uid.' order by OrderID DESC';
        $q.= " limit $start, $end"; 
        $data = $db->multiFetch($q);
        return $data;
    }
    
    
      function ViewSpecificOrder($oid)
    {
        $db = Database::getInstance();
        $data = $db->singleFetch("Select * from Orders_FP WHERE OrderID = $oid");
        

        return $data;
    }
    
    
    function ViewOrderDetails($orderid)
    {
        $db = Database::getInstance();
        $q = "Select * from OrderDetails_FP WHERE OrderID = $orderid";
        $data = $db->multiFetch($q);
        return $data;
    }
    
   
    function Logout()
    {
        $_SESSION['UserID'] = '';
        $_SESSION['Username'] = '';
        session_destroy();
    }
    
     
}
?>
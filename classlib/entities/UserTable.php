<?php
/**
* This file contains the UserTable Class
* 
*/

/**
 * 
 * ChatMsgTable entity class implements the table entity class for the 'user' table in the database. 
 * 
 * @author Gerry Guinane
 * 
 */

class UserTable extends TableEntity {

    /**
     * Constructor for the UserTable Class
     * 
     * @param MySQLi $databaseConnection  The database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'user');  //the name of the table is passed to the parent constructor
    }

   

    /**
     * Performs validation of user login credentials
     * 
     * @param string $userID
     * @param string $password
     * @param boolean $encryptPW True if Password is hashed
     * @return boolean Returns TRUE if validation is successful. FALSE for invalid credentials.
     */
    public function validate_login($userID,$password,$encryptPW){  
        
        //encrypt the password if required
        if($encryptPW){//encrypt the password
        $password = hash('ripemd160', $password);       
        }     
        
        //construct the SQL
        $this->SQL="SELECT * FROM user WHERE userID='$userID' AND PassWord='$password'";


        //execute the query and validate user
        try {
                $rs=$this->db->query($this->SQL);  //execute the query

                if($rs){ //one or more records returned by query
                    
                    //complete checking of the credentials
                    if ($rs->num_rows===1){  //a valid username and password combination entered and a single record has been returned.            
                            //check if the user login is enabled. 
                            $row=$rs->fetch_assoc();
                            if($row['userEnabled']){
                                return TRUE;  //user is enabled and so is valid 
                            }
                            else {
                                return FALSE;  //user login is not permitted, login is disabled
                            }
                        }
                        else{
                            return FALSE; //empty resultset - no query result has been returned
                        }                    
                }
                else {
                     return FALSE;  //query did not return a single record result
                }
        } catch (Exception $ex) {
            //an exception has occurred - get the details for diagnostic purposes
            $this->MySQLiErrorNr=$ex->getCode(); //get the exception number
            $this->MySQLiErrorMsg=$ex->getMessage(); //get the exception error message
            return false;
        }       
    }

    
    

    /**
     * Validates and implements password change for specified user.  
     * 
     * @param array $postArray containing data to be inserted
        * $postArray['pass1'] String New Password copy 1 
        * $postArray['pass2'] String New Password copy 2
        * $postArray['email'] String user ID/email address 
        * $postArray['password'] String user old Password
     * @param User $user The current user.
     * 
     * @return boolean TRUE if password is changes, else FALSE
     * 
     * 
     */   
    public function changePassword($postArray,$user){
        
        //get the values entered in the registration form contained in the $postArray argument      
        extract($postArray);
    
        //add escape to special characters      
        $pass1= addslashes($pass1);  //the new password from the POST array
        $pass2= addslashes($pass2);  //second copy of the new password
        
        //check the new passwords match
        if(!$pass1===$pass2){return FALSE; }  //passwords dont match
        
        $password= addslashes($password);  //this is the old password required for validation
        $userID=$user->getUserID();

        //check old password is valid before changing
        if($this->validate_login($userID, $password, $user->getPWEncrypted())){
                         
            //encrypt the password if required
            if($user->getPWEncrypted()){
                $pass1 = hash('ripemd160', $pass1);       
            }  
            
            //construct the UPDATE SQL 
            $this->SQL="UPDATE user SET PassWord='$pass1' WHERE userID='$userID'";   
            
            //execute the UPDATE query
            try {
                $rs=$this->db->query($this->SQL);
            } catch (Exception $ex) {
                //an exception has occurred - get the details for diagnostic purposes
                $this->MySQLiErrorNr=$ex->getCode(); //get the exception number
                $this->MySQLiErrorMsg=$ex->getMessage(); //get the exception error message
                return false;
            }


            //check the update query was successful
            if ($this->db->affected_rows===1 && $rs){return TRUE;}else{return FALSE;}

        }
        else{return FALSE;}  //user did not provide valid old password
    }

    

    /**
     * Returns a resultset record (FirstName and LastName only by ID
     * 
     * @param string $userID
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */ 
    public function getRecordByID($userID){ 
        
        //build the SQL Query
        $this->SQL="SELECT u.userID,u.FirstName,u.LastName,u.email,u.mobile,u.idcounty,ut.userTypeNr,ut.userTypeDescr,u.userEnabled ";
        $this->SQL.=" FROM user u,usertype ut";
        $this->SQL.=" WHERE u.userID = '$userID' AND u.userTypeNr = ut.userTypeNr";
        
        //execute the query using a try catch 
        try{
            $rs=$this->db->query($this->SQL);  //execute the query
            
            if($rs){
                if($rs->num_rows===1){  //this query should only return 1 record
                    return $rs;  //the resultset can be returned as it contains ONLY one record
                }
                else{
                    //no records returned for this query 
                    return false;
                }
            }
            else{
                //the query has not executed successfully
                return false;
            }
            
        } catch (Exception $ex) {
            //an exception has occurred - get the details for diagnostic purposes
            $this->MySQLiErrorNr=$ex->getCode(); //get the exception number
            $this->MySQLiErrorMsg=$ex->getMessage(); //get the exception error message
            return false;
        }        
 
    }

    
    
    

     /**
     * Performs a DELETE query for a single record ($userID).  Verifies the
     * record exists before attempting to delete
     * 
     * @param $userID  String containing ID of user record to be deleted
     * 
     * @return boolean Returns FALSE on failure. For successful DELETE returns TRUE
     */
    public function deleteRecordbyID($userID){
        
        if($this->getRecordByID($userID)){ //confirm the record exists before deletig
            $this->SQL = "DELETE FROM user WHERE userID='$userID'";
            
            try {
                $rs=$this->db->query($this->SQL);
                return true;
            } catch (mysqli_sql_exception $ex) { //catch the exception 
                //an exception has occurred - get the details for diagnostic purposes
                $this->MySQLiErrorNr=$ex->getCode(); //get the exception number
                $this->MySQLiErrorMsg=$ex->getMessage(); //get the exception error message
                return false;            }
        }
        else{
            return false;  //no record exists with the selected $userID
        }       
    }

   

    /**
     * Performs a SELECT query to returns all records from the table. 
     * ID,Firstname and Lastname columns only.
     *
     * @param $userType  String containing user type to be selected, Default is wildcard
     * 
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getAllRecords($userType=0){
        
        if($userType){ //select data for the specified user type
           $this->SQL = "SELECT userID,FirstName,LastName, ut.userTypeDescr AS UserType, userEnabled AS LoginEnabled FROM user u,usertype ut where u.userTypeNr=ut.userTypeNr and u.userTypeNr=$userType ORDER BY userTypeDescr";
        } 
        else{  //select data for all user types
           $this->SQL = "SELECT userID,FirstName,LastName, ut.userTypeDescr AS UserType, userEnabled AS LoginEnabled FROM user u,usertype ut where u.userTypeNr=ut.userTypeNr ORDER BY userTypeDescr";

        }

        //execute the query using a try catch 
        try{
            $rs=$this->db->query($this->SQL);  //execute the query
            
            if($rs){
                if($rs->num_rows){  //this query should return at least 1 record
                    return $rs;  //the resultset can be returned as it contains ONLY one record
                }
                else{
                    //no records returned for this query 
                    return false;
                }
            }
            else{
                //the query has not executed successfully
                return false;
            }
            
        } catch (Exception $ex) {
            //an exception has occurred - get the details for diagnostic purposes
            $this->MySQLiErrorNr=$ex->getCode(); //get the exception number
            $this->MySQLiErrorMsg=$ex->getMessage(); //get the exception error message
            return false;
        }        
        
    }   

    /**
     * 
     * Adds a new record to the database table - user.
     * 
     * @param array $postArray Copy of $_POST array containing data to be inserted
     * @param boolean $encryptPW  TRUE if the password will be hashed in the database record
     * @param string $userType The current user type 
     * @return boolean
     */
    public function addRecord($postArray,$encryptPW){
        
        // use extract() toget the values entered in the registration form contained in the $postArray argument
        extract($postArray);

        //add escape to special characters      
        $firstName= addslashes($firstName);//
        $lastName= addslashes($lastName);//
        $email=addslashes($email);//
        $userID=$email; //  default is email for userID
        $mobile=addslashes($mobile); //
        $idCounty=(integer) $idCounty;  //idcounty is an integer value only
        $userTypeNr=(integer) $userTypeNr;  //usertype is integer value only
        $userEnabled=(integer) $userEnabled;  //userEnabled is (boolean/integer) value only     
        
        //check is password encryption is required
        if($encryptPW){//encrypt the password
        $password = hash('ripemd160', $pass1); //encrypt the password  
        }
        else{
            $password = $pass1;  //dont encrypt the password 
        }
        
        //construct the INSERT SQL
        $this->SQL="INSERT INTO user (userID,FirstName,LastName,PassWord,email,mobile,idcounty,userTypeNr,userEnabled) VALUES ('$userID','$firstName','$lastName','$password','$email','$mobile',$idCounty,$userTypeNr,1)";   
        
          //execute the query using a try catch 
        try{
            $rs=$this->db->query($this->SQL);  //execute the query
            
            if($rs){
                return true; 
            }
            else{
                //the query has not executed successfully
                return false;
            }
            
        } catch (Exception $ex) {
            //an exception has occurred - get the details for diagnostic purposes
            $this->MySQLiErrorNr=$ex->getCode(); //get the exception number
            $this->MySQLiErrorMsg=$ex->getMessage(); //get the exception error message
            return false;
        }
        

        
    }
  
    

    /**
     * Updates an existing record by ID. Does not change password or user type.  
     * 
     * @param array $postArray containing data to be inserted
         * $postArray['userID'] string StudentID
         * $postArray['firstName'] string FirstName
         * $postArray['lastName'] string LastName
         * $postArray['mobile'] string mobile
         * $postArray['county'] integer idcounty
         * $postArray['userTypeNr'] integer userTypeNr
         * $postArray['userEnabled'] integer userEnabled
         * @return boolean
     * 
     * 
     */   
    public function updateRecord($postArray){
        
        //get the values entered in the registration form contained in the $postArray argument      
        extract($postArray);
    
        //add escape to special characters      
        $firstName= addslashes($firstName);//
        $lastName= addslashes($lastName);//
        $email=addslashes($email);//
        $userID=$email; // //email by default
        $mobile=addslashes($mobile); //
        $idCounty=(integer) $idCounty;  //idcounty is an integer value only
        $userTypeNr=(integer) $userTypeNr;  //usertype is integer value only
        $userEnabled=(integer) $userEnabled;  //userEnabled is (boolean/integer) value only        
        
        
        //verify a valid userID has been entered 
        if(!$this->getRecordByID($userID)){return FALSE; }//userID is invalid
       
        //userID is valid - construct the INSERT SQL                    
        $this->SQL="UPDATE user SET FirstName='$firstName',LastName='$lastName',mobile='$mobile',idcounty=$idCounty, userTypeNr=$userTypeNr,userEnabled=$userEnabled,email='$email' WHERE userID='$userID'";   
               
        //execute the UPDATE query
        try {
            $rs=$this->db->query($this->SQL);
        } catch (Exception $ex) {
            //an exception has occurred - get the details for diagnostic purposes
            $this->MySQLiErrorNr=$ex->getCode(); //get the exception number
            $this->MySQLiErrorMsg=$ex->getMessage(); //get the exception error message
            return false;
        }
            
        //check the update query was successful and only one recorded updated
            if ($this->db->affected_rows===1 && $rs){return TRUE;}else{return FALSE;}
    }

   
    
}


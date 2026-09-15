<?php
/**
* This file contains the CountyTable Class
* 
*/

/**
 * 
 * ChatMsgTable entity class implements the table entity class for the 'CountyTable' table in the database. 
 * 
 * @author Gerry Guinane
 * 
 */

class CountyTable extends TableEntity {

    /**
     * Constructor for the CountyTable Class
     * 
     * @param MySQLi $databaseConnection  The database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'county');  //the name of the table is passed to the parent constructor
    }
    //END METHOD: Construct
   
    
    

    /**
     * Returns a partial record (countyName only by ID)
     * 
     * @param string $idcounty
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */ 
    public function getRecordByID($idcounty){
        $this->SQL="SELECT countyName FROM county WHERE idcounty='$idcounty'";
        
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
     * Performs a DELETE query for a single record ($idcounty).  Verifies the
     * record exists before attempting to delete
     * 
     * @param $idcounty  String containing ID of county record to be deleted
     * 
     * @return boolean Returns FALSE on failure. For successful DELETE returns TRUE
     */
    public function deleteRecordbyID($idcounty){
               
        if($this->getRecordByID($idcounty)){ //confirm the record exists before deletig
             $this->SQL = "DELETE FROM county WHERE idcounty='$idcounty'";       
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
     * idcounty,countyName columns only.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getAllRecords(){
 
        $this->SQL = 'SELECT idcounty,countyName FROM county';
        
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
     * Inserts a new record in the table. 
     * 
     * @param array $postArray containing data to be inserted
         * $postArray['county'] string County Name
     * 
     * @return boolean
     * 
     * 
     */   
    public function addRecord($postArray){
        
        //get the values entered in the registration form contained in the $postArray argument      
        extract($postArray);
        
        //add escape to special characters
        $countyName= addslashes($county);
        
        
        //construct the INSERT SQL
        $this->SQL="INSERT INTO county (countyName) VALUES ('$countyName')";   
       
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
 

   
    
}


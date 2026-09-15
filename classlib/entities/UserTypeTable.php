<?php
/**
* This file contains the UserTypeTable Class
* 
*/

/**
 * 
 * UserTypeTable entity class implements the table entity class for the 'usertype' table in the database. 
 * 
 * @author Gerry Guinane
 * 
 */

class UserTypeTable extends TableEntity {

    /**
     * Constructor for the UserTypeTable Class
     * 
     * @param MySQLi $databaseConnection  The database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'usertype');  //the name of the table is passed to the parent constructor
    }
    //END METHOD: Construct
   
    
    

    /**
     * Returns the usertype from the usertype table
     * 
     * @param int $userTypeNr The user type reference number
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */ 
    public function getRecordByID($userTypeNr){
        $this->SQL="SELECT userTypeDescr FROM usertype WHERE userTypeNr=$userTypeNr";
        
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
     * Performs a SELECT query to returns all records from the table. 
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getAllRecords(){
        $this->SQL = 'SELECT * FROM usertype';  //set up the SQL 
        
        //execute the query using a try catch 
        try{
            $rs=$this->db->query($this->SQL);  //execute the query
            
            if($rs){
                if($rs->num_rows){
                    return $rs;  //the resultset can be returned as it contains at leat one record
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

   
    
}


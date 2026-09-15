<?php
/**
* This file contains the TableEntity Base Class
* 
*/

/**
 * 
 * Base class for Table Entities
 * 
  * The purpose of this abstract base class is to implement <em><b>basic property initialization and retrieval and diagnostic functions</b></em>  for database tables.  
 * 
 * @author Gerry Guinane
 * 
 */


class TableEntity {


    /**
     * 
     * @var MySQLi $db The database connection object
     */    
    protected $db;


    /**
     * 
     * @var String $tableName Name of the table entity in the database
     */ 
    protected $tableName;
    
    
    /**
     * 
     * @var int $MySQLiErrorNr MySQLi Error Number
     */ 
    protected $MySQLiErrorNr;
  
    
    /**
     * 
     * @var String $MySQLiErrorMsg MySQLi Error Message
     */ 
    protected $MySQLiErrorMsg;    
    
    
    /**
     * 
     * @var String $SQL - the most recently constructed/executed SQL string
     */ 
    protected $SQL;   
    
    
    /**
     * Constructor Method
     * 
     * This is the constructor for the TableEntity class. The TableEntity class is the parent class for all table entities. 
     * 
     * @param MySQLi $databaseConnection The database connection handle
     * @param String $tableName Name of the table entity in the database
     */
    function __construct ($databaseConnection,$tableName){
        $this->tableName=$tableName;
        $this->db=$databaseConnection;
        $this->MySQLiErrorNr=0000;
        $this->MySQLiErrorMsg='No MySQLi Error';
        $this->SQL='No SQL String Available';
    }    

    //table entity methods

    /**
     * 
     * Selects all records from the table entity. 
     * 
     * @return mysqli_result if TRUE or boolean FALSE
     * 
     */
    public function select_all(){
        $this->SQL = "SELECT * FROM  $this->tableName";  //valid query
        
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


    //getters
    /**
     * 
     * Returns the entity table name
     * 
     * @return string $this->tableName name of this table entity
     * 
     */
    public function get_table_name(){
        return $this->tableName;
    }    



    /**
     * Provides diagnostic information in HTML format relating to the class properties
     * 
     * @return string $diagnostic  Diagnostic information in HTML format relating to the class properties
     */
     public function getDiagnosticInfo(){      
            $diagnostic = '<!-- TABLE ENTITY CLASS PROPERTY SECTION  -->';
            $diagnostic .= '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV
                $diagnostic .= '<h3>TABLE ENTITY CLASS (CLASS): '.$this->tableName.'</h3>';
                $diagnostic .= '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
                $diagnostic .= '<tr><th>PROPERTY</th><th>VALUE</th></tr>';                        
                $diagnostic .= "<tr><td>Entity Table Name</td>   <td>$this->tableName</td></tr>";
                $diagnostic .= "<tr><td>MySQLi Error Nr</td>   <td>$this->MySQLiErrorNr</td></tr>";
                $diagnostic .= "<tr><td>MySQLi Error Message</td>   <td>$this->MySQLiErrorMsg</td></tr>";
                $diagnostic .= "<tr><td>Most Recent SQL String</td>   <td>$this->SQL</td></tr>";            
                $diagnostic .= '</table>';
                $diagnostic .= '<p><hr>';
            $diagnostic .= '</div>';            
            $diagnostic .= '<!-- END TABLE ENTITY CLASS PROPERTY SECTION  -->';
            return $diagnostic;

    }   
    //END METHOD: getDiagnosticInfo()

    
}

<?php
/**
* This file contains the Installer Class
* 
*/

/**
 * The Installer class provides the static installation methods. 
 * 
 * This class is responsible for providing the following functions:
 * 
    * MySQL Database installation
 *
 * @author Gerry Guinane 
 * 
 */


class Installer {
  
    
    
/**
 * 
 * Installs the MySQL database for this app
 * 
 * @param string $DBServer String containing address of the MySQL server
 * @param string $DBUser   String containing MySQL user ID 
 * @param string $DBPass   String containing MySQL user password
 * @param string $SQLscript String containing path to SQL script for database creation
 * @return string String containing description of result of database installation. 
 * 
 */    
public static function installDB($DBServer, $DBUser, $DBPass,$SQLscript){

//TODO Installer - add try catches and throws exception. Function needs to be integrated to the function call. 
    
    $msg= '<h3>Database installation</h3>';
    $dbConn=new mysqli($DBServer, $DBUser, $DBPass);
    
    if($dbConn->connect_errno){
        $msg.= '<br>**installation FAIL Due to database connection error - DB Server may be down**<br> ERROR NR:'.$db->connect_errno.'<br>';
        $dbConn->close();
        return $msg;
        }
        else{
            //read the database SQL file
            $sql = file_get_contents($SQLscript);
            
        //execute the query using a try catch 
        try{
            $rs=$dbConn->multi_query($sql);  //execute the query
            
            if($rs){
				$msg.= '<br>**Database installation SUCCESSFUL<br>';
                return $msg;
            }
            else{
				$msg.= '<br>**Database installation NOT SUCCESSFUL - cause unknown<br>';
                return $msg;
            }
            
        } catch (Exception $ex) {
            //an exception has occurred - get the details for diagnostic purposes
			$msg.= '<br>**Database installation NOT SUCCESSFUL<br>';
			$msg.= '<br>The following error information may help:<br>';
            $msg.='<br>Exception Code: '.$ex->getCode(); //get the exception number
           $msg.='<br>Exception Message: '.$ex->getMessage(); //get the exception error message
            return $msg;
        }
        }
    }
}





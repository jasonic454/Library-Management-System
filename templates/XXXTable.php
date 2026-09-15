<?php
/**
* This file contains the XXXTable Class Template
* 
*/

 /**
 * 
 * The purpose of this XXXTable [template] class is to implement the table entity class for the 'XXXTable' table in the database. 
 * 
 * 
 * To use this TEMPLATE - change 'XXXTable' to the required table everywhere it appears 
 *  
 * eg: if you want to define a table entity class  for a database table called 'suppliers'
 * <ul>
 * <li>Rename this file - replace the 'XXXTable' with 'SupplierTable' in the file name </li>
 * <li>Rename class  - replace the 'XXXTable' with 'SupplierTable' as the class name </li>
 * <li>Edit this file to REPLACE 'XXX' in the class constructor with the table name 'supplier' [lower case]</li>
 * <li>Move this file to its correct folder in the project eg /classlib/entities/ </li> 
 * <li>Finally include this file in the index.php </li>
 * </ul>
 * 
 * 
 * 
 * @author Gerry Guinane
 * 
 */

class XXXTable extends TableEntity {

    /**
     * Constructor for the XXXTable Class
     * 
     * @param MySQLi $databaseConnection  The database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'table_name');  //the name of the table is passed to the parent constructor
    }
    //END METHOD: Construct
   
    
   
    
}


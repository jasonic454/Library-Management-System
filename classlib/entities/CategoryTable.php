<?php
/**
 * This file contains the CategoryTable Class
 */

/**
 * CategoryTable entity class implements the table entity class for the 'category' table in the database.
 *
 * @author K00267870
 */
class CategoryTable extends TableEntity {

    /**
     * Constructor for the CategoryTable Class
     *
     * @param MySQLi $db The database connection object.
     */
    function __construct($db) {
        parent::__construct($db, 'category');
    }
    //END METHOD: Construct


    /**
     * Returns all category records from the category table.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object.
     */
    public function getAllRecords() {

        //construct the SQL query
        $this->SQL = "SELECT * FROM category ORDER BY category_name";

        //execute the query using a try catch
        try {
            $rs = $this->db->query($this->SQL);
            if ($rs) {
                if ($rs->num_rows) {
                    return $rs; //return the recordset
                } else {
                    return false; //no records found
                }
            } else {
                return false; //query failed
            }
        } catch (mysqli_sql_exception $e) { //catch the exception
            $this->MySQLiErrorNr = $e->getCode();
            $this->MySQLiErrorMsg = $e->getMessage();
            return false; //the query failed for some reason
        }
    }
    //END METHOD: getAllRecords()

}

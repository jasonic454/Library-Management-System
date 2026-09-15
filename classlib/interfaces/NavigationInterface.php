<?php
/**
* This file contains the NavigationInterface Class
 * 
*/


/**
 * Interface class defining the getter and setter methods that are 
 * required to support a html navigation bar.  
 * 
 * 
 * @author Gerry Guinane
 * 
 */
interface NavigationInterface {
   
    /**
     * Set the menu items depending on the users selected page ID. The page ID is accessed via the $_GET Superglobal. 
     */
    public function setmenuNav();//set the menu items depending on the users selected page ID
    
     /**
      * 
      * Set the menu items depending on the users selected page ID
      * 
      * @return String Containing HTML formatted menu items for selected Page ID.
      * 
      */
    public function getMenuNav(); //returns the menu bar for a view
    
     /**
      * Get the diagnostic info for this class.
      * 
      * @return String Containing HTML formatted dump of class properties. 
      */ 
    public function getDiagnosticInfo(); //returns a HTML string for diagnostic/debug purposes
    
}

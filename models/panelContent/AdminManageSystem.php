<?php
/**
* This file contains the AdminManageSystem Class
* 
*/


/**
 * ManageSystem is an extended PanelModel Class
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for an <em><b>ADMINISTRATOR user system management</b></em>  page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * @author gerry.guinane
 * 
 */
class AdminManageSystem extends PanelModel {
   
    
    /**
     * Constructor Method
     * 
     * This is the constructor for the ManageSystems class. The ManageSystems class provides the 
     * panel content for up to 3 page panels.
     * 
     * @param User $user  The current user
     * @param MySQLi $db The database connection handle
     * @param Array $postArray Copy of the $_POST array
     * @param String $pageTitle The page Title
     * @param String $pageHead The Page Heading
     * @param String $pageID The currently selected Page ID
     */
    function __construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID){  
        $this->modelType='AdminManageSystem';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 

    /**
     * Set the Panel 1 heading
     */
    public function setPanelHead_1(){//set the panel 1 heading
            $this->panelHead_1='<h3>System Management</h3>';      
    }//end METHOD - //set the panel 1 heading
    
    /**
     * Set the Panel 1 text content
     */
    public function setPanelContent_1(){//set the panel 1 content
            $this->panelContent_1="Use the links provided to manage thisSystem";
    }//end METHOD - //set the panel 1 content        

    
    /**
     * Set the Panel 2 heading
     */
    public function setPanelHead_2(){ //set the panel 2 heading    
            $this->panelHead_2='<h3>System Management</h3>'; 

    }//end METHOD - //set the panel 2 heading   
    
    /**
     * Set the Panel 2 text content
     */
    public function setPanelContent_2(){//set the panel 2 content
            $this->panelContent_2="Use the links provided to manage this System";

    }//end METHOD - //set the panel 2 content  


    /**
     * Set the Panel 3 heading
     */
    public function setPanelHead_3(){ //set the panel 3 heading  
            $this->panelHead_3='<h3>Panel 3</h3>'; 
    } //end METHOD - //set the panel 3 heading
    
    /**
     * Set the Panel 3 text content
     */
    public function setPanelContent_3(){ //set the panel 2 content{        
            $this->panelContent_3="Panel 3 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged OFF state.";;
    }  //end METHOD - //set the panel 3 content        

       
}//end class
        
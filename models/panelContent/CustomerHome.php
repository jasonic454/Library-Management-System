<?php
/**
* This file contains the CustomerHome Class
* 
*/


/**
 * CustomerHome is an extended PanelModel Class
 * 
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for a <em><b>CUSTOMER user home</b></em>  page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * @author gerry.guinane
 * 
 */


class CustomerHome extends PanelModel{


    /**
    * Constructor Method
    * 
    * The constructor for the PanelModel class. The ManageSystems class provides the 
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
        $this->modelType='CustomerHome';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 



    /**
     * Set the Panel 1 heading 
     */
    public function setPanelHead_1(){
            $this->panelHead_1='<h3>Web Application Framework</h3>';
    }
    
    /**
    * Set the Panel 1 text content 
    */   
    public function setPanelContent_1(){
        $this->panelContent_1.='You are currently logged in as a CUSTOMER. '; 
    }       

    /**
     * Set the Panel 2 heading 
     */
    public function setPanelHead_2(){
        $this->panelHead_2='<h3>Welcome to your Customer Home Page</h3>';
    }

    
     /**
     * Set the Panel 2 text content 
     */       
    public function setPanelContent_2(){
        //set the Middle panel content
         $this->panelContent_2='Thank you <b>'.$this->user->getUserFirstName().' '.$this->user->getUserLastName() .'</b> for logging in successfully as a CUSTOMER to the sample Web Application Framework. Please use the links above to manage your account and send/receive messages. <br><br>Don\'t forget to logout when you are done.';
    } 

    /**
     * Set the Panel 3 heading 
     */
    public function setPanelHead_3(){ 
        $this->panelHead_3='<h3>Application Setup</h3>';
    } 

     /**
     * Set the Panel 3 text content 
     */       
    public function setPanelContent_3(){ 
             $this->panelContent_3="<p>To ! set up this application read the following <a href='readme/installation.php' target='_blank' >SETUP INSTRUCTIONS</a></p>";   
    }         


     
        
}
        
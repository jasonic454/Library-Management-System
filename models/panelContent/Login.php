<?php
/**
* This file contains the Login Class
* 
*/


/**
 * Login is an extended PanelModel Class
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for an  <em><b>not logged in user login</b></em> page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * @author gerry.guinane
 * 
 */


class Login extends PanelModel {
    
        
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
        $this->modelType='Login';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 


    /**
     * Set the Panel 1 heading 
     */
    public function setPanelHead_1(){
        $this->panelHead_1='<h3>Login Form</h3>';     
    }
    
    /**
    * Set the Panel 1 text content 
    */         
    public function setPanelContent_1(){
        $this->panelContent_1 = Form::form_login('login');  //this reads an external form file into the string 
    }        

    /**
     * Set the Panel 2 heading 
     */
    public function setPanelHead_2(){ 
        $this->panelHead_2='<h3>Instructions</h3>'; 
    }  
    
    /**
    * Set the Panel 2 text content 
    */     
    public function setPanelContent_2(){ 
        //process the login details from the login form if the button has been pressed
        if(isset($this->postArray['btnLogin'])){  //check that the login button is pressed

            //all user ID emails must be set to lower case only
            $userID=strtolower($this->postArray['userID']);

            //process the login credentials that were entered in then login form
            $this->loggedin=$this->user->login($userID, $this->postArray['password']);  
            

            
            //if login has failed then set the panel 2 contents
            if(!$this->loggedin){  //if login is not successful keep track of login attempts
                $this->user->setLoginAttempts($this->user->getLoginAttempts()+1); //add 1 to current login attempts

                $this->panelContent_2='Your login attempt has not been successful. <b>Check your ID and password and try again</b>. <br><br> Number of login attempts from this browser = '.$this->user->getLoginAttempts();                
   $this->panelContent_2.= '<br>'.$userID.'   '.$this->postArray['password'];
            }
        }
        else{

            $this->panelContent_2='Please enter your login details. Login attempts='.$this->user->getLoginAttempts();
        }                 
    } 

    /**
     * Set the Panel 3 heading 
     */
    public function setPanelHead_3(){ 
        $this->panelHead_3='<h3>Panel 3</h3>'; 
    } 
    
    /**
    * Set the Panel 3 text content 
    */     
    public function setPanelContent_3(){ 
        $this->panelContent_3 ='Panel 3 content';
    }



        
}
        
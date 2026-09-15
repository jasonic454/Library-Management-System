<?php
/**
* This file contains the AccountAdminCustomer Class
* 
*/


/**
 * AccountAdminCustomer is an extended PanelModel Class
 * 
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for a <em><b>CUSTOMER user account administration</b></em>  page.  The content generated is intended for 3 panel
 * view layouts. 
 *
 * @author gerry.guinane
 * 
 */



class AccountAdminCustomer extends PanelModel {
    

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
        $this->modelType='AccountAdminCustomer';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 


    /**
     * Set the Panel 1 heading 
     */
    public function setPanelHead_1(){
            $this->panelHead_1='<h3>Customer Registration Form</h3>'; 
    }
    
     /**
     * Set the Panel 1 text content 
     */   
    public function setPanelContent_1(){
        $countyTable=new CountyTable($this->db);
        $this->panelContent_1 = Form::form_register($countyTable,'registerCustomer');           
    }        

    /**
     * Set the Panel 2 heading 
     */
    public function setPanelHead_2(){ 
        if (isset($this->postArray['btnRegister'])){  //check the button is pressed
            $this->panelHead_2='<h3>Customer Registration Result</h3>'; 
        }
        else{
            $this->panelHead_2='<h3>Customer Registration Instructions</h3>'; 
        }
    }  
    
     /**
     * Set the Panel 2 text content 
     */   
    public function setPanelContent_2(){
        //process the registration button
        if (isset($this->postArray['btnRegister'])){  //check the button is pressed

            if ($this->postArray['pass1']===$this->postArray['pass2']){  //verify passwords match
                //process the registration data
                $this->panelContent_2='Passwords Match<br>';
                $this->panelContent_2.='UserID (email): '.strtolower($this->postArray['email']).'<br>'; //all emails must be lowercase
                $this->panelContent_2.='Firstname : '.$this->postArray['firstName'].'<br>';
                $this->panelContent_2.='Lastname  : '.$this->postArray['lastName'].'<br>';
                $this->panelContent_2.='Password1 : '.$this->postArray['pass1'].'<br>';
                $this->panelContent_2.='Password2 : '.$this->postArray['pass2'].'<br>';


                $userTable=new UserTable($this->db);
                if ($userTable->addRecord($this->postArray,$this->user->getPWEncrypted(),'CUSTOMER')){  //call the user::registration() method.                    
                    $this->panelContent_2='CUSTOMER REGISTRATION SUCCESSFUL - please log in<br>';
                    }
                else{     
                    if($userTable->getRecordByID($this->postArray['email'])){ //check if the email is already registered
                        $this->panelContent_2='CUSTOMER REGISTRATION IS NOT SUCCESSFUL - This email <b>'.$this->postArray['email'].'</b> is already registered<br>Please login or use a different email address to register.';
                    }
                    else{  //something else went wrong with the registration
                        $this->panelContent_2='CUSTOMER REGISTRATION IS NOT SUCCESSFUL<br>';
                    }

                    }   
                    array_push($this->panelModelObjects,$userTable); #for diagnostic purposes
            }
            else{
                $this->panelContent_2='Passwords DONT Match<br>';
                $this->panelContent_2.='UserID (email): '.$this->postArray['email'].'<br>';
                $this->panelContent_2.='Firstname : '.$this->postArray['firstName'].'<br>';
                $this->panelContent_2.='Lastname  : '.$this->postArray['lastName'].'<br>';
                $this->panelContent_2.='Password1 : '.$this->postArray['pass1'].'<br>';
                $this->panelContent_2.='Password2 : '.$this->postArray['pass2'].'<br>';                    
            }
        }
        else{
            $this->panelContent_2='Please enter details in the form to register a CUSTOMER';
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
            $this->panelContent_3='Panel 3 content - under construction';
    }        


        
}
        
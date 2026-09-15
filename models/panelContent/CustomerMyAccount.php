<?php
/**
* This file contains the CustomerMyAccount Class
* 
*/


/**
 * CustomerMyAccount is an extended PanelModel Class
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for an  <em><b>CUSTOMER user account management </b></em>  page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * @author gerry.guinane
 * 
 */


class CustomerMyAccount extends PanelModel{
    
    
    

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
        $this->modelType='CustomerMyAccount';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 



    /**
     * Set the Panel 1 heading 
     */
    public function setPanelHead_1(){
        switch ($this->pageID) {
            case "myAccount":
                $this->panelHead_1='<h3>Manage My Account</h3>'; 
                break;
            case "editAccount":
                $this->panelHead_1='<h3>Edit My Account</h3>'; 
                break;
            case "changePassword":
                $this->panelHead_1='<h3>Change My Password</h3>'; 
                break;
            default:
                $this->panelHead_1='<h3>Manage My Account</h3>'; 
                break;
            }//end switch       
    }
    
    /**
    * Set the Panel 1 text content 
    */     
   public function setPanelContent_1(){

    $this->panelContent_1 = '<p><strong>Name:</strong> '
        . htmlspecialchars($this->user->getUserFirstName().' '.$this->user->getUserLastName())
        . '</p>'
        . '<p><strong>Email:</strong> '
        . htmlspecialchars($this->user->getUserID())
        . '</p>'
        . '<p>Use the links above to manage and make changes to your registered account.</p>';
}      

    /**
     * Set the Panel 2 heading 
     */
    public function setPanelHead_2(){ 
        switch ($this->pageID) {
            case "myAccount":
                $this->panelHead_2='<h3>Manage My Account</h3>'; 
                break;
            case "editAccount":

                $this->panelHead_2='<h3>Edit Account Result</h3>'; 
                break;
            case "changePassword":
                $this->panelHead_2='<h3>Password Change Result</h3>'; 
                break;
            default:
                $this->panelHead_2='<h3>Manage My Account</h3>'; 
                break;
            }//end switch
    }    
    
    /**
    * Set the Panel 2 text content 
    */     
    public function setPanelContent_2(){
        switch ($this->pageID) {

            case "myAccount":
                $this->panelContent_2='myAccount'; 
                break;
            case "editAccount":
                if (isset($this->postArray['btnUpdateAccount'])){
                    $userTable=new UserTable($this->db);  
                    if($userTable->updateRecord($this->postArray)){
                        $this->panelContent_2='Record Updated';
                        $this->setPanelContent_1();  //refresh panel 1 data after change
                    }
                    else{
                        $this->panelContent_2='Unable to update record or no new values entered';
                    }
                    array_push($this->panelModelObjects,$userTable); #for diagnostic purposes
                }
                else{
                    $this->panelContent_2='Use the form on the left to edit your account details. <br><br> Note that it is <b> not possible to edit the email field as this is used as your unique userID </b>.';  
                }               
                break;
            case "changePassword":
                if (isset($this->postArray['btnChangePW'])){
                    //check both new passwords match 
                    if($this->postArray['pass1']===$this->postArray['pass2']){
                        $userTable=new UserTable($this->db);              
                        if($userTable->changePassword($this->postArray,$this->user)){
                            $this->panelContent_2='Password changed - next time you log in use the new password';
                        }
                        else{
                            $this->panelContent_2='Unable to change password - check you have entered the correct OLD password';
                        }                        
                        array_push($this->panelModelObjects,$userTable); #for diagnostic purposes
                    }
                    else{
                        $this->panelContent_2="OLD Passwords entered DON'T match - please retry.";
                    }
                }
                else{
                    $this->panelContent_2='To change your password - enter the new password TWICE along with your OLD password for authorisation.';  
                }
                break;
            default:
                $this->panelContent_2='myAccount'; 
                break;
            }//end switch
    } 

    /**
     * Set the Panel 3 heading 
     */
    public function setPanelHead_3(){ 
        if($this->loggedin){
            $this->panelHead_3='<h3>Panel 3</h3>';   
        }
        else{        
            $this->panelHead_3='<h3>Panel 3</h3>'; 
        }
    } 
    
    /**
    * Set the Panel 3 text content 
    */     
    public function setPanelContent_3(){ //set the panel 2 content
        $this->panelContent_3="Panel 3 content for <b>$this->pageHeading</b> menu item is under construction/not in use.";;
    }         


        
        
}
        
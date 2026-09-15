<?php
/**
* This file contains the ManagerMyAccount Class
* 
*/


/**
 * ManagerMyAccount is an extended PanelModel Class
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for a <em><b>MANAGER user account management</b></em> page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * @author gerry.guinane
 * 
 */

class ManagerMyAccount extends PanelModel{


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
        $this->modelType='ManagerMyAccount';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 


    /**
     * Set the Panel 1 heading 
     */
    public function setPanelHead_1(){//set the panel 1 heading
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
        switch ($this->pageID) {
            case "myAccount":
                $this->panelContent_1='Use the links above to manage and make changes to your registered account'; 
                break;
            case "editAccount":
                $countyTable=new CountyTable($this->db);
                $userTable=new UserTable($this->db);
                $thisUserRecord=$userTable->getRecordByID($this->user->getUserID());
                $this->panelContent_1=Form::form_edit_account($countyTable,$thisUserRecord,$this->pageID); 
                array_push($this->panelModelObjects,$userTable); #for diagnostic purposes
                break;
            case "changePassword":
                $this->panelContent_1=Form::form_password_change($this->pageID); 
                break;
            default:
                $this->panelContent_1='Manage My Account'; 
                break;
            }//end switch  
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
                if(isset($this->postArray['btnCancelUpdateAccount'])){
                    $this->panelContent_2='Account Edit Cancelled - No changes have been saved. ';
                }
                else if (isset($this->postArray['btnUpdateAccount'])){
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
                if(isset($this->postArray['btnCancelUpdatePW'])){
                    $this->panelContent_2='Changes cancelled';
                }
                else if (isset($this->postArray['btnChangePW'])){
                    
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
                        $this->panelContent_2='Passwords DON\'T match - Please make sure that you enter the new password twice.';
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
        $this->panelHead_3='<h3>Panel 3</h3>';  
    } 
    
    /**
    * Set the Panel 3 text content 
    */ 
    public function setPanelContent_3(){ //set the panel 2 content
        $this->panelContent_3="Panel 3 content for <b>$this->pageHeading</b> menu item is under construction.";
    }        


        
        
}
        
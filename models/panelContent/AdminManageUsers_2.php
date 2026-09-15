<?php
/**
* This file contains the AdminManageUsers Class
* 
*/


/**
 * ManageUsers is an extended PanelModel Class
 * 
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for an <em><b>ADMINISTRATOR user - user management</b></em> page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * @author gerry.guinane
 * 
 */

class AdminManageUsers extends PanelModel{

  
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
        $this->modelType='ManageUsers';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 

    /**
     * Set the Panel 1 heading 
     */    
    public function setPanelHead_1(){
         
        switch ($this->pageID) {
            case "manageUsers":
                $this->panelHead_1='<h3>Manage Users</h3>';  
                break;
            case "registerUsers":
                $this->panelHead_1='<h3>Register Users</h3>';  
                break;
            case "registerManager":
                $this->panelHead_1='<h3>Manager Registration Form</h3>'; 
                break;            
            case "registerCustomer":
                $this->panelHead_1='<h3>Customer Registration Form</h3>';  
                break;            
            case "viewUsers":
                $this->panelHead_1='<h3>View Users Data</h3>';  
                break;               
            case "editUsers":
                $this->panelHead_1='<h3>Edit Users Data</h3>';  
                break;                
            case "deleteUsers":
                $this->panelHead_1='<h3>Delete Users Data</h3>';  
                break;               
            default:
                $this->panelHead_1='<h3>Manage Users</h3>';  
                break;
            }//end switch     
        
    }

    /**
    * Set the Panel 1 text content 
    */ 
    public function setPanelContent_1(){
             
            
        switch ($this->pageID) {
            case "manageUsers":
                $this->panelContent_1="Use the links provided to manage users "; 
                break;
            case "registerUsers":
                $countyTable=new CountyTable($this->db);
                $userTypeTable=new UserTypeTable($this->db);
                $this->panelContent_1 = Form::form_register($countyTable,$userTypeTable,$this->pageID);  
                break;  
            case "registerManager":
                $countyTable=new CountyTable($this->db);
                $userTypeTable=new UserTypeTable($this->db);
                $this->panelContent_1 = Form::form_register($countyTable,$userTypeTable,$this->pageID);  
                break;            
            case "registerCustomer":
                $countyTable=new CountyTable($this->db);
                $userTypeTable=new UserTypeTable($this->db);
                $this->panelContent_1 = Form::form_register($countyTable,$userTypeTable,$this->pageID);    
                break;            
            case "viewUsers":
                $this->panelContent_1="Viewing users data "; 
                break;               
            case "editUsers":
                $this->panelContent_1="Editing users data ";   
                break;                
            case "deleteUsers":
                $this->panelContent_1="Deleting users data  ";  
                break;               
            default:
                $this->panelContent_1="Use the links provided to manage users ";  
                break;
            }//end switch                
            
    }       

    /**
     * Set the Panel 2 heading 
     */
    public function setPanelHead_2(){ 
        
        switch ($this->pageID) {
            case "manageUsers":
                $this->panelHead_2='<h3>Manage Users</h3>';  
                break;
            case "registerUsers":
                $this->panelHead_2='<h3>Register Users</h3>';  
                break;
            case "registerManager":
                $this->panelHead_2='<h3>Register Manager Result</h3>';  
                break;            
            case "registerCustomer":
                $this->panelHead_2='<h3>Register Customer Result</h3>';  
                break;            
            case "viewUsers":
                $this->panelHead_2='<h3>View Users Data</h3>';  
                break;               
            case "editUsers":
                $this->panelHead_2='<h3>Edit Users Data</h3>';  
                break;                
            case "deleteUsers":
                $this->panelHead_2='<h3>Delete Users Data</h3>';  
                break;               
            default:
                $this->panelHead_2='<h3>Manage Users</h3>';  
                break;
            }//end switch    
    }   

    /**
    * Set the Panel 1 text content 
    */ 
    public function setPanelContent_2(){
        
        switch ($this->pageID) {
            case "manageUsers":
                $this->panelContent_2="Use the links provided to manage users "; 
                break;
            case "registerUsers":
                $this->panelContent_2="Use the links provided to register users "; 
                break;
            case "registerManager":
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
                            
                            
                            if ($userTable->addRecord($this->postArray,$this->user->getPWEncrypted(),'MANAGER')){  //call the user::registration() method.                    
                                $this->panelContent_2='NEW MANAGER REGISTRATION SUCCESSFUL<br>';
                                }
                            else{     
                                if($userTable->getRecordByID($this->postArray['email'])){ //check if the email is already registered
                                    $this->panelContent_2='MANAGER REGISTRATION IS NOT SUCCESSFUL - This email <b>'.$this->postArray['email'].'</b> is already registered<br>Please login or use a different email address to register.';
                                }
                                else{  //something else went wrong with the registration
                                    $this->panelContent_2='MANAGER REGISTRATION IS NOT SUCCESSFUL<br>';
                                }

                                }   
                                array_push($this->panelModelObjects,$userTable); #for diagnostic purposes
                        }
                    }
                    else{
                        $this->panelContent_2='Please enter details in the form to register a MANAGER';
                    }        
                break;            
            case "registerCustomer":

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
                                $this->panelContent_2='CUSTOMER REGISTRATION SUCCESSFUL<br>';
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
                break;            
            case "viewUsers":
                $this->panelContent_2="Viewing users data "; 
                break;               
            case "editUsers":
                $this->panelContent_2="Editing users data ";   
                break;                
            case "deleteUsers":
                $this->panelContent_2="Deleting users data  ";  
                break;               
            default:
                $this->panelContent_2="Use the links provided to manage users ";  
                break;
            }//end switch    
    } 

    /**
     * Set the Panel 3 heading 
     */
    public function setPanelHead_3(){ 
        switch ($this->pageID) {
            case "manageUsers":
                $this->panelHead_3='<h3>Manage Users</h3>';  
                break;
            case "registerUsers":
                $this->panelHead_3='<h3>Register Users</h3>';  
                break;
            case "registerManager":
                $this->panelHead_3='<h3>Register Manager</h3>';  
                break;            
            case "registerCustomer":
                $this->panelHead_3='<h3>Register Customer</h3>';  
                break;            
            case "viewUsers":
                $this->panelHead_3='<h3>View Users Data</h3>';  
                break;               
            case "editUsers":
                $this->panelHead_3='<h3>Edit Users Data</h3>';  
                break;                
            case "deleteUsers":
                $this->panelHead_3='<h3>Delete Users Data</h3>';  
                break;               
            default:
                $this->panelHead_3='<h3>Manage Users</h3>';  
                break;
            }//end switch    
    } 
    
    /**
    * Set the Panel 3 text content 
    */ 
    public function setPanelContent_3(){    
        
        switch ($this->pageID) {
            case "manageUsers":
                $this->panelContent_3="Use the links provided to manage users "; 
                break;
            case "registerUsers":
                $this->panelContent_3="Use the links provided to register users "; 
                break;
            case "registerManager":
                $this->panelContent_3="Register a Manager "; 
                break;            
            case "registerCustomer":
                $this->panelContent_3="Register a customer "; 
                break;            
            case "viewUsers":
                $this->panelContent_3="Viewing users data "; 
                break;               
            case "editUsers":
                $this->panelContent_3="Editing users data ";   
                break;                
            case "deleteUsers":
                $this->panelContent_3="Deleting users data  ";  
                break;               
            default:
                $this->panelContent_3="Use the links provided to manage users ";  
                break;
            }//end switch  
    }         

        
        
}
        
<?php
/**
* This file contains the AdminManageUsers Class
* 
*/


/**
 * AdminManageUsers is an extended PanelModel Class
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
                $this->panelHead_1='<h3>Select User For Editing</h3>';  
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
            
            
            
            case "viewUsers":
                $userTable=new UserTable($this->db);
                $rs=$userTable->getAllRecords();                
                if ($rs){                   
                    $this->panelContent_1=HelperHTML::generateTABLE($rs); 
                }
                else{
                    $this->panelContent_1="No users data available "; 
                }
                break;               
            case "editUsers":
                $this->panelContent_1=Form::form_select_user($this->pageID);   
                break;                
            case "deleteUsers":
                $this->panelContent_1=Form::form_select_user($this->pageID);   
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
            case "viewUsers":
                $this->panelHead_2='<h3>Result View Users Data</h3>';  
                break;               
            case "editUsers":
                $this->panelHead_2='<h3>Editing Users Data</h3>';  
                break;                
            case "deleteUsers":
                $this->panelHead_2='<h3>Result - Delete Users Data</h3>';
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
                if(isset($this->postArray['btnRegister'])){   //check if the user register button is pressed             
                    if($this->postArray['pass1']===$this->postArray['pass1']){//check 2 passwords entered match                 
                        $userTable=new UserTable($this->db);
                        if($userTable->addRecord($this->postArray, ENCRYPT_PW)){ //try to add new record
                           $this->panelContent_2='Registration Processed Successfully'; 
                        }
                        else{ //unable to add new record - may already exist
                            $this->panelContent_2='Unable to Add new user - check details - user may already be registered';
                        }
                        
                    }
                    else{//passwords do not match
                         $this->panelContent_2='Passwords must match exactly - please re-enter form details';
                    }
                }
                else{ //the register user button has not been pressed yet
                    $this->panelContent_2='Please enter user registration details in form';
                }
                break;         
            case "viewUsers":
                $this->panelContent_2="View users data  ";  
                break;                  
            case "editUsers":
                if(isset($this->postArray['btnUserSelect'])){                     
                     $userID=strtolower($this->postArray['userID']);
                     $countyTable=new CountyTable($this->db);
                     $userTable=new UserTable($this->db);
                     $userTypeTable=new UserTypeTable($this->db);
                     $userRecord=$userTable->getRecordByID($userID);
                     
                     if($userRecord){  //record found - generate an edit form
                         $this->panelContent_2.=Form::form_administrator_edit_account($countyTable,$userTypeTable, $userRecord, $this->pageID);
                     }
                     else{ //no record for this ID
                         $this->panelContent_2='No record found with the following user ID : '.$userID;
                     }
                }
                elseif(isset($this->postArray['btnUpdateAccount'])){ 
                        
                        $userTable=new UserTable($this->db);
                        if($userTable->updateRecord($this->postArray)){
                             $this->panelContent_2='Updated user account successfully';
                        }
                        else{
                             $this->panelContent_2='Unable to update user account';
                        }
                            
                        
                        
                    }
                else{   
                    $this->panelContent_2='Select a user record to edit using the form on the left side';
                }     
                break;                
            case "deleteUsers":
                $userTable=new UserTable($this->db); //create a user table entity object
                
                if(isset($this->postArray['btnUserSelect'])){        //The Select user button has been pressed   
                    //check if the user ID is valid
                    if($rs=$userTable->getRecordByID($this->postArray['userID'])){ //a valid user ID is entered    
                        $row=$rs->fetch_assoc(); //get the user record as an associative array
                        $this->panelContent_2= HelperHTML::generateVerticalRecordTable($row); //display selected record for deletion
                        $this->panelContent_2.=Form::form_confirm($this->pageID, 'Confirm Record Deletion',$this->postArray['userID']); //ask user to confirm or cancel
                    }
                    else{ //user ID entered is not a valid ID in the user table
                        $this->panelContent_2='The user ID entered  is not valid, no such record exists in the User table';
                    }
                }
                elseif(isset($this->postArray['btnConfirm'])){
                        $this->panelContent_2='The confirm button is pressed -'.$this->postArray['btnConfirm'];
                        //try to delete the record and confirm if successful
                        if($userTable->deleteRecordbyID($this->postArray['btnConfirm'])){  
                            $this->panelContent_2='User record deleted';  //record successfully deleted
                            }
                            else{
                                $this->panelContent_2='Unable to delete user record'; //Unable to delete user record - there may be some dependencies
                            }     
                }
                else{
                    $this->panelContent_2='Enter a user ID for deletion'; //A user ID has not yet been entered for deletion
                }
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
        
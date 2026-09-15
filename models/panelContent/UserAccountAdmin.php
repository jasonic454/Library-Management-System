<?php
/**
* This file contains the UserAccountAdmin Class
* 
*/


/**
 * UserAccountAdmin is an extended PanelModel Class
 * 
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for an <em><b>All users - user account self administration</b></em> page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * @author gerry.guinane
 * 
 */

class UserAccountAdmin extends PanelModel{

  
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
        $this->modelType='UserAccountAdmin';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 

    /**
     * Set the Panel 1 heading 
     */    
    public function setPanelHead_1(){
         
        switch ($this->pageID) {          
            case "registerCustomer":
                $this->panelHead_1='<h3>Customer Registration Form</h3>';  
                break;                         
            default:
                $this->panelHead_1='<h3>Customer Registration Form</h3>';  
                break;
            }//end switch     
        
    }

    /**
    * Set the Panel 1 text content 
    */ 
    public function setPanelContent_1(){
             
            
        switch ($this->pageID) {           
            case "registerCustomer":
                $countyTable=new CountyTable($this->db);
                $this->panelContent_1 = Form::form_register_customer($countyTable,$this->pageID);    
                break;                          
            default:
                $countyTable=new CountyTable($this->db);
                $this->panelContent_1 = Form::form_register_customer($countyTable,$this->pageID);    
                break; 
                break;
            }//end switch                
            
    }       

    /**
     * Set the Panel 2 heading 
     */
    public function setPanelHead_2(){ 
        
        switch ($this->pageID) {          
            case "registerCustomer":
                $this->panelHead_2='<h3>Register Customer Result</h3>';  
                break;                        
            default:
            case "registerCustomer":
                $this->panelHead_2='<h3>Register Customer Result</h3>';  
                break;  
            }//end switch    
    }   

    /**
    * Set the Panel 1 text content 
    */ 
    public function setPanelContent_2(){
        
        switch ($this->pageID) {          
            case "registerCustomer":

                    //process the registration button
                    if (isset($this->postArray['btnRegister'])){  //check the button is pressed

                        if ($this->postArray['pass1']===$this->postArray['pass2']){  //verify passwords match
                            //process the registration data
                            $userTable=new UserTable($this->db);
                            $userType=3;  //default to user type 3 = CUSTOMER 
                            if ($userTable->addRecord($this->postArray,$this->user->getPWEncrypted(),$userType)){  //call the user::addRecord() method.                    
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
                            $this->panelContent_2='Passwords DONT Match - Please re-enter registration details';
                    
                        }
                    }
                    else{
                        $this->panelContent_2='Please enter details in the form to register a CUSTOMER';
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
            case "registerCustomer":
                $this->panelHead_3='<h3>Register Customer</h3>';  
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
          
            case "registerCustomer":
                $this->panelContent_3="Register a customer "; 
                break;            
             
            default:
                $this->panelContent_3="Register a customer "; 
                break;  
            }//end switch  
    }         

        
        
}
        
<?php
/**
* This file contains the User Class
* 
*/

/**
 * The user class represents the end user of the application. 
 * 
 * This class is responsible for providing the following functions:
 * 
 * <ul>
 * <li>User registration</li>
 * <li>User Login</li>
 * <li>User Logout</li>
 * <li>Persisting user session data by keeping the $_SESSION array up to date</li>
 *</ul>
 * 
 * @author Gerry Guinane 
 * 
 */


class User {

    /**
     *
     * @var Session Object   $session The current Session
     */
    protected $session;       
    
    /**
     *
     * @var MySQLi Object $db the database connection 
     */
    protected $db;            
    
    /**
     *
     * @var String $userID containing User ID
     */
    protected $userID;        
    
    /**
     *
     * @var String $userFirstName  User first name 
     */
    protected $userFirstName;
    
    /**
     *
     * @var String userLastName  User Last Name
     */
    protected $userLastName;  
    
    /**
     *
     * @var String $userType;      User type 
     */
    protected $userType;      
    
    /**
     *
     * @var Array $postArray;     Copy of $_POST array
     */
    protected $postArray;    
    
    /**
     *
     * @var boolean $chatEnabled  TRUE if AJAX chat is enabled for this session
     */
    protected $chatEnabled;   
    
    /**
     *
     * @var boolean $loggedin  TRUE if user is logged in
     */
    protected $loggedin;
    
    /**
     *
     * @var boolean $encryptPW  TRUE if passwords are hash encrypted in DB
     */
    protected $encryptPW; 

    /**
     *
     * @var  UserTable User Table Entity Class. 
     */
    protected $userTable;
    
    
    /**
     *
     * @var  String $userTableDiagnostics User Table Entity Class diagnostic information string. 
     */
    protected $userTableDiagnostics;
    

    /**
     * Class constructor
     * 
     * @param Session Object $session
     * @param MySQLi Object $database
     * @param boolean $encryptPW  TRUE if passwords are hash encrypted in DB
     * 
     * 
     */
    function __construct($session,$database,$encryptPW) {   
        $this->loggedin=$session->getLoggedinState();
        $this->db=$database;
        $this->session=$session;
        
        //get properties from the session object
        $this->userID=$session->getUserID();
        $this->userFirstName=$session->getUserFirstName();
        $this->userLastName=$session->getUserLastName();
        $this->userType=$session->getUserType();
        $this->chatEnabled=$session->getChatEnabledState();
        $this->encryptPW=$encryptPW;
        $this->postArray=array();
        $this->userTableDiagnostics='No User Table Entity Class diagnostic information available';
    }



    /**
     * Login method. Validates the user credentials provided and returns TRUE 
     * if they match credentials stored in the user table in the database. 
     * 
     * @param String $userID
     * @param String $password
     * 
     * @return boolean TRUE if login is successful
     * 
     */
    public function login($userID, $password) {
        //This login function checks both the student and lecturer tables for valid login credentials

        $this->userTable=new UserTable($this->db);
        if($this->userTable->validate_login($userID, $password, $this->encryptPW)){  //check if the login details match an ADMIN       
                //query the table for that specific user
                $rs=$this->userTable->getRecordByID($userID);
                

                
                $row=$rs->fetch_assoc(); //get the users record from the query result  

                //then set the session array property values
                $this->session->setUserID($row['userID']);
                $this->session->setUserFirstName($row['FirstName']);
                $this->session->setUserLastName($row['LastName']);
                $this->session->setUserType($row['userTypeDescr']); 
                $this->session->setLoggedinState(TRUE);

                //update the User class properties
                $this->userID=$userID;
                $this->userFirstName=$row['FirstName'];
                $this->userLastName=$row['LastName'];
                $this->userType=$row['userTypeDescr'];
                
                
                $this->userTableDiagnostics=$this->userTable->getDiagnosticInfo();
                return TRUE;
            }
            else{
                $this->session->setLoggedinState(FALSE);
                $this->userFirstName=NULL;
                $this->userLastName=NULL;
                $this->userType='UNKNOWN';
                $this->loggedin=FALSE;
                
                $this->userTableDiagnostics=$this->userTable->getDiagnosticInfo();
                return FALSE;
            }
        
    }


    /**
     * Unconditionally logs out the current user. 
     *  
     * @return boolean TRUE if logout is completed
     * 
     */
    public function logout(){
        //
        if($this->session->logout()){return true;}else{return false;}
    }


        
    /**
     * Sets the number of login attempts. 
     * 
     * @param integer $num The number of login attempts.
     */
    public function setLoginAttempts($num){$this->session->setLoginAttempts($num);}
    
    /**
     * Sets the chat enabled state
     * 
     * @param boolean $state The desired chat enabled state
     */
    public function setChatEnabledState($state){$this->session->setChatEnabledState($state);}
    
    /**
     * Sets the logged in state.
     * 
     * @param boolean $loggedinState The logged in state. 
     */
    public function setLoggedInState($loggedinState){ $this->loggedin=$loggedinState;}//end METHOD - getLoggedInState  
    
    /**
     * Returns the current user's  logged in state.
     *  
     * @return boolean
     */
    public function getLoggedInState(){return $this->session->getLoggedinState();}//end METHOD - getLoggedInState        

     /**
     * Returns the current user's  ID
     *  
     * @return string
     */
    public function getUserID(){return $this->userID;}

     /**
     * Returns the current user's  first name
     *  
     * @return string
     */
    public function getUserFirstName(){return $this->userFirstName;}

     /**
     * Returns the current user's  last name
     *  
     * @return string
     */    
    public function getUserLastName(){return $this->userLastName;}

     /**
     * Returns the current user's  user type
     *  
     * @return string
     */
    public function getUserType(){return $this->userType;}

     /**
     * Returns the state of the encryptPW property. TRUE if password encryption is set. 
     *  
     * @return boolean
     */    
    public function getPWEncrypted(){return $this->encryptPW;}

     /**
     * Returns the current sessions number of login attempts
     *  
     * @return integer
     */    
    public function getLoginAttempts(){return $this->session->getLoginAttempts();}  

     /**
     * Returns the state of the chatEnabled property. TRUE if chatEnabled is set. 
     *  
     * @return boolean
     */     
    public function getChatEnabledState(){return $this->chatEnabled;}
    
    
    /**
     * Provides diagnostic information in HTML format relating to the User class properties
     * 
     * @return string $diagnostic  Diagnostic information in HTML format relating to the User class properties
     */
    public function getDiagnosticInfo(){
        
        
        
        $diagnostic = '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV
            $diagnostic .=  '<h3>USER (CLASS)  properties</h3>';
            $diagnostic .=  '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
            $diagnostic .=  '<tr><th>PROPERTY</th><th>VALUE</th></tr>';
            $diagnostic .=  "<tr><td>userID  </td><td>$this->userID       </td></tr>";
            $diagnostic .=  "<tr><td>userFirstName  </td><td>$this->userFirstName     </td></tr>";
            $diagnostic .=  "<tr><td>userLastName  </td><td>$this->userLastName         </td></tr>";
            $diagnostic .=  "<tr><td>userType  </td><td>$this->userType         </td></tr>";
            $diagnostic .=  "<tr><td>chatEnabled  </td><td>$this->chatEnabled         </td></tr>";
            $diagnostic .=  "<tr><td>loggedin  </td><td> $this->loggedin        </td></tr>";
            $diagnostic .=  "<tr><td>Password Encryption  </td><td> $this->encryptPW        </td></tr>";
            $diagnostic .=  "<tr><td>User Table Entity Diagnostics  </td><td>$this->userTableDiagnostics       </td></tr>";
            $diagnostic .=  "<tr><td>  </td><td>         </td></tr>";
            $diagnostic .=  "<tr><td>  </td><td>         </td></tr>";            
            $diagnostic .=  '</table>';
            $diagnostic .=  '<p><hr>';
        $diagnostic .=  '</div>';
        return $diagnostic;
    }

}

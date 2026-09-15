<?php
/**
* This file contains the Controller Abstract Class
* 
*/

/**
 * 
 * Abstract Base class for Controllers. 
 * 
 * The main functions of a Controller are to get user inputs and to update the View. The purpose of this abstract base class is to implement <em><b>the ControllerInterface</b></em>  for all controllers.  
 * 
 * @author Gerry Guinane
 * 
 */


abstract class Controller implements ControllerInterface{

    /**
     *
     * @var boolean $userLoggedIn  - user logged in state 
     */
    protected $userLoggedIn; 
    
    /**
     *
     * @var string $controllerType  - identifies the type of controller object
     */
    protected $controllerType; 
    
    /**
     *
     * @var Array  $postArray A copy of the content of the $_POST superglobal array
     */
    protected $postArray;   
    
    /**
     *
     * @var Array  $getArray A copy of the content of the $_GET superglobal array
     */
    protected $getArray;   
    
    /**
     *
     * @var Array  $viewData Array containing page content generated using models
     */
    protected $viewData;        
    
    /**
     *
     * @var Array  $controllerObjects Array containing models used by the controller - to facilitate debug/diagnostic mode
     */
    protected $controllerObjects;          
    
    /**
     *
     * @var User  $user The current user
     */
    protected $user; 
    
    /**
     *
     * @var MySQLi  $db The database connection object
     */
    protected $db;
    
    /**
     *
     * @var String  $pageTitle The web page title 
     */
    protected $pageTitle;    
    
    /**
     * Constructor Method
     * 
     * The constructor for the Controller class. The Controller class is the parent class for all Controllers.
     * 
     * @param User $user  The current user
     * @param MySQLi  $db The database connection object
     * @param String  $pageTitle The web page title 
     */
    function __construct($user,$db, $pageTitle) {  //constructor  
        //initialise the model
        $this->user=$user;
        $this->userLoggedIn=$this->user->getLoggedInState();
        
        //initialise all the class properties
        $this->postArray = array();
        $this->getArray = array();
        $this->viewData=array();
        $this->controllerObjects=array();
        $this->db=$db;
        $this->pageTitle=$pageTitle;       
    } 
        

    /**
     * Getter to return an associative array of strings corresponding to the headings and panel content of a 3 panel view 
     * 
     * @param Model $contentMod Content Model
     * @param Model $navMod Navigation Model
     * @return Array $data An array of Strings corresponding to the headings and panel content of a 3 panel view 
     * 
     */
    protected function getPageContent($contentMod,$navMod) {
        //get the content from the navigation model - put into the $data array for the view:
        $data['menuNav'] = $navMod->getMenuNav();       // an array of menu items and associated URLS
        //get the content from the page content model  - put into the $data array for the view:
        $data['pageTitle'] = $contentMod->getPageTitle();
        $data['pageHeading'] = $contentMod->getPageHeading();
        $data['panelHead_1'] = $contentMod->getPanelHead_1(); // A string containing the LHS panel heading/title
        $data['panelHead_2'] = $contentMod->getPanelHead_2();
        $data['panelHead_3'] = $contentMod->getPanelHead_3(); // A string containing the RHS panel heading/title
        $data['panelContent_1'] = $contentMod->getPanelContent_1();     // A string intended of the Left Hand Side of the page
        $data['panelContent_2'] = $contentMod->getPanelContent_2();     // A string intended of the Left Hand Side of the page
        $data['panelContent_3'] = $contentMod->getPanelContent_3();     // A string intended of the Right Hand Side of the page
        return $data;
        
    }

        
    
    /**
     * The controller run method gets the user inputs and updates the page/panel contents . 
     * 
     */
    public function run() {
        //run the controller
        $this->getUserInputs();
        $this->updateView();
    }
    

    /**
     * Gets the user inputs from the $_POST and $_GET arrays
     * 
     */
    public function getUserInputs() { //get and process the user's inputs and choices
        //
        //This method is the main interface between the user and the controller.
        //
        //Get the $_GET array values
        $this->getArray = filter_input_array(INPUT_GET) ; //used for PAGE navigation
        
        //Get the $_POST array values
        $this->postArray = filter_input_array(INPUT_POST);  //used for form data entry and buttons
        
    }
     

    /**
     * Updates the view. This is an abstract method that must be implemented in the child classes. 
     */
    abstract public function updateView(); //select appropriate models and construct updated view content
          
    /**
     * Dumps diagnostic information in HTML format relating to the class properties
     */
    public function getDiagnostic() {   //Diagnostics/debug information - dump the application variables if DEBUG mode is on

        echo '<!--CONTROLLER CLASS PROPERTY SECTION  -->';
            echo '<div class="container-fluid"   style="background-color: #22AAAA">'; //outer DIV green blue

            echo '<h2>'.strtoupper($this->controllerType).'  - Controller Class - Diagnostic information</h2><br>';

            //SECTION 1
            echo '<section style="background-color: #AABBCC">'; //light blue
                echo '<h3>'.strtoupper($this->controllerType).' Controller (CLASS) properties</h3>';
                
                
                echo '<h4>User Logged in Status:</h4>';
                if ($this->userLoggedIn) {
                    echo 'User Logged In state is TRUE ($loggedin) <br>';
                } else {
                    echo 'User Logged In state is FALSE ($loggedin) <br>';
                }

                echo '<h4>$postArray Values (user input - values entered in any form)</h4>';
                echo '<pre>';
                if(!empty($this->postArray)){
                    echo '<table border=1>';
                    echo '<tr><th>KEY</th><th>VALUE</th></tr>';
                    foreach($this->postArray as $key=>$value){
                        echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
                    }
                    echo '</table>';                    
                }
                else{ echo '$_POST Array is empty';}

                echo '</pre>';
                echo '<br>';

                echo '<h4>$getArray Values (user input - page selected)</h4>';
                echo '<pre>';
                if(!empty($this->getArray)){
                    echo '<table border=1>';
                    echo '<tr><th>KEY</th><th>VALUE</th></tr>';
                    foreach($this->getArray as $key=>$value){
                        echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
                    }                
                    echo '</table>';
                }
                else{ echo '$_GET Array is empty';}
                
                echo '</pre>';
                echo '<br>';

                echo '<h4>$data Array Values (Array of Values passed to view)</h4>';
                echo '<pre>';
                echo '<table border=1>';
                echo '<tr><th>KEY</th><th>VALUE</th></tr>';
                foreach($this->viewData as $key=>$value){
                    echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
                }                
                echo '</table>';                
                echo '</pre>';
                echo '<br>';

            echo '</section>';

            //SECTION 2
            echo '<section style="background-color: #AABBCC">'; //light blue
                echo '<h4>Controller - Class Objects</h4>';
                echo '<pre>';
                foreach($this->controllerObjects as $object){echo $object->getDiagnosticInfo();}
                echo '</pre>';
            echo '</section>';
                       
            echo '</div>';  //END outer DIV
            echo '<!-- END CONTROLLER CLASS PROPERTY SECTION  -->';
        
    }

    
    
} //end CLASS
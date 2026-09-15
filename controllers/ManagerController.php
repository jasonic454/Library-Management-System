<?php
/**
* This file contains the ManagerController Class
* 
*/


/**
 * Controller for logged in - MANAGER user type
 *
 * @author gerry.guinane
 * 
 */




class ManagerController extends Controller  {


    /**
     * Constructor Method
     * 
     * The constructor for the Controller class. The Controller class is the parent class for all Controllers.
     * 
     * @param User $user  The current user
     * @param MySQLi  $db The database connection object
     * @param String  $pageTitle The web page title 
     */ 
    function __construct($user,$db, $pageTitle) { 
        $this->controllerType='MANAGER';
        parent::__construct($user,$db, $pageTitle);
    }




    /**
     * Method to update the selected view depending on the currently selected page ID. 
     * 
     * This method implements handlers for each page ID.  It loads the page content and navigation models 
     * as required by the page ID and prepares the $data content array to pass to the view. 
     * It selects and loads the required view. 
     * 
     */
    public function updateView() { //update the VIEW based on the users page selection
        if (isset($this->getArray['pageID'])) { //check if a page id is contained in the URL
            switch ($this->getArray['pageID']) {
                
                //home handlers
                case "home":
                    //create objects to generate view content
                    $contentModel = new ManagerHome($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationManager($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_3_panel.php'; //load the view                     
                    break;  
                
                case "menuitem1":
                    //create objects to generate view content
                    $contentModel = new UnderConstruction($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationManager($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view                      
                    break; 
                
                case "logout":                    
                    //Change the login state to false
                    $this->user->logout();
                    $this->userLoggedIn=FALSE;

                    //create objects to generate view content
                    $contentModel = new GeneralHome($this->user, $this->db, $this->postArray,$this->pageTitle, 'HOME', 'home');
                    $navigationModel = new NavigationGeneral($this->user, 'home');
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_3_panel.php'; //load the view                  
                    break;  

                
                //my account handlers
                case "myAccount":
                    //create objects to generate view content
                    $contentModel = new ManagerMyAccount($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationManager($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_1_panel.php';  //load the view   
                    break;
                case "editAccount":
                    //create objects to generate view content
                    $contentModel = new ManagerMyAccount($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationManager($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view   
                    break;
                case "changePassword":
                    //create objects to generate view content
                    $contentModel = new ManagerMyAccount($this->user, $this->db, $this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']), $this->getArray['pageID']);
                    $navigationModel = new NavigationManager($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view   
                    break;
                                               
                default:
                    //no valid $pageID selected by user - default loads HOME page
                    //create objects to generate view content
                    $contentModel = new ManagerHome($this->user, $this->db, $this->postArray,$this->pageTitle, 'HOME', 'home');
                    $navigationModel = new NavigationManager($this->user, 'home');
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_3_panel.php';
                    break;
            }
        } 
        else {//no page selected and NO page ID passed in the URL 
            //no page selected - default loads HOME page
            //create objects to generate view content
            $contentModel = new ManagerHome($this->user, $this->db, $this->postArray,$this->pageTitle, 'HOME', 'home');
            $navigationModel = new NavigationManager($this->user, 'home');
            array_push($this->controllerObjects,$navigationModel,$contentModel);
            $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
            $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
            //update the view
            include_once 'views/view_navbar_3_panel.php';  //load the view
        }
    }

       
     
}



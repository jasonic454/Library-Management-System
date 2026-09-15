<?php
/**
* This file contains the CustomerController Class
* 
*/


/**
 * Controller for logged in - CUSTOMER user type
 *
 * @author gerry.guinane
 * 
 */


class CustomerController extends Controller  {


    /**
     * Constructor Method
     * 
     * The constructor for the Controller class. The Controller class is the parent class for all Controllers.
     * 
     * @param User $user  The current user
     * @param MySQLi  $db The database connection object
     * @param String  $pageTitle The web page title 
     */  
    function __construct($user,$db,$pageTitle) { 
        $this->controllerType='CUSTOMER';
        parent::__construct($user,$db,$pageTitle);
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
                case "home":
                    //create objects to generate view content
                    $contentModel = new CustomerHome($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view                      
                    break;      
                case "newMenuItem": 
                    //create objects to generate view content
                    $contentModel = new UnderConstruction($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php'; //load the view                  
                    break; 

                
                //My Account 
                case "myAccount":
                    //create objects to generate view content
                    $contentModel = new CustomerMyAccount($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_1_panel.php';  //load the view   
                    break;
                case "editAccount":
                    //create objects to generate view content
                    $contentModel = new CustomerMyAccount($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view   
                    break;
                case "changePassword":
                    //create objects to generate view content
                    $contentModel = new CustomerMyAccount($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
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
                    $contentModel = new GeneralHome($this->user,$this->db, $this->postArray ,$this->pageTitle, 'HOME','home');
                    $navigationModel = new NavigationGeneral($this->user, 'home');
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_3_panel.php'; //load the view                  
                    break;  
                
                //Messages
                case "chat":
                    //this handler is called by AJAX partial page updater
                    //it doesnt return content to a view
                    //it is used to respond to the AJAX request from the chat script that is embedded in the view
                    $msgTable=new ChatMsgTable($this->db);
                    array_push($this->controllerObjects,$msgTable);
                    $rs=$msgTable->getLatestUserMessages($this->user->getUserID(),10);
                    echo HelperHTML::generateCHAT($rs,$this->user->getUserID());

                    break;
                  break;
                
                 case "messages":
                    //create objects to generate view content
                    $contentModel = new CustomerMessages($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_1_panel.php';  //load the view   
                    break;
                case "livechat":
                    //create objects to generate view content
                    $contentModel = new CustomerMessages($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view   
                    break;
                case "viewMsgs":
                    //create objects to generate view content
                    $contentModel = new CustomerMessages($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_1_panel.php';  //load the view   
                    break;
                case "sendMsg":
                    //create objects to generate view content
                    $contentModel = new CustomerMessages($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';  //load the view   
                    break;                
                case "deleteMsg":
                    //create objects to generate view content
                    $contentModel = new CustomerMessages($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                    $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_1_panel.php';  //load the view   
                    break;   
                
                case "viewBooks":
                //create objects to generate view content
                $contentModel = new CustomerBooks($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                array_push($this->controllerObjects,$navigationModel,$contentModel);
                $data = $this->getPageContent($contentModel,$navigationModel);
                $this->viewData = $data;
                include_once 'views/view_navbar_3_panel.php';
                break;

                case "borrowHistory":
                $contentModel = new CustomerBorrowHistory($this->user,$this->db, $this->postArray ,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->getArray['pageID']);
                $navigationModel = new NavigationCustomer($this->user, $this->getArray['pageID']);
                array_push($this->controllerObjects,$navigationModel,$contentModel);
                $data = $this->getPageContent($contentModel,$navigationModel);
                $this->viewData = $data;
                include_once 'views/view_navbar_2_panel.php';
                break;

                
                default:
                    //no valid pageID selected by user - default loads HOME page
                    //create objects to generate view content
                    $contentModel = new CustomerHome($this->user,$this->db, $this->postArray ,$this->pageTitle, 'HOME','home');
                    $navigationModel = new NavigationCustomer($this->user, 'home');
                    array_push($this->controllerObjects,$navigationModel,$contentModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_2_panel.php';
                    break;
            }
        } 
        else {//no page selected and NO page ID passed in the URL 
            //no page selected - default loads HOME page
            //create objects to generate view content
            $contentModel = new CustomerHome($this->user,$this->db, $this->postArray ,$this->pageTitle, 'HOME','home');
            $navigationModel = new NavigationCustomer($this->user, 'home');
            array_push($this->controllerObjects,$navigationModel,$contentModel);
            $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
            $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
            //update the view
            include_once 'views/view_navbar_2_panel.php';  //load the view
        }
    }

       
     
}


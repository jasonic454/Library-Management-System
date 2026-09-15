<?php
/**
 * This file contains the PanelModel Abstract Class
 * 
 */
/**
 * 
 * PanelModel Abstract Class. 
 * 
 * The PanelModel class is the parent abstract class for page content classes that provide up to 3 page panels content. 
 * 
 * The purpose of this abstract base class is to implement <em><b>the PanelModelInterface</b></em>  for all panel models.  
 * 
 * 
 * 
 */
abstract class PanelModel implements PanelModelInterface {
    
    /**
     * 
     * @var boolean $loggedin;  - user logged in state
     */
    protected $loggedin; 
    
    /**
     * 
     * @var User $user  - the current user object
     */
    protected $user; 
    
    /**
     * 
     * @var string $modelType  - identifies the type of model (eg USER, ADMINISTRATOR) 
     */
    protected $modelType; 
    
        /**
     *
     * @var Array  $panelModelObjects Array containing models used by the PanelModel class - to facilitate debug/diagnostic mode
     */
    protected $panelModelObjects;       
    
    /**
     * 
     * @var Array $postArray Containing copy of $_POST array
     */
    protected $postArray; 
    
    /**
     *
     * @var String Containing the currently selected page ID 
     */
    protected $pageID; 
    
    /**
     * 
     * @var MySQLi $db The database connection 
     */
    protected $db;                
    
    /**
     *
     * @var String $pageTitle containing page title 
     */
    protected $pageTitle;         
    
    /**
     *
     * @var String $pageHeading Containing Page Heading 
     */
    protected $pageHeading;    
    
    /**
     *
     * @var String $panelHead_1 Panel 1 Heading 
     */
    protected $panelHead_1;    
    
    /**
     *
     * @var String $panelHead_2 Panel 2 Heading 
     */
    protected $panelHead_2;   
    
    /**
     *
     * @var String $panelHead_3 Panel 3 Heading 
     */
    protected $panelHead_3;      
    
    /**
     *
     * @var String $panelContent_1 Panel 1 Content 
     */
    protected $panelContent_1;  
    
    /**
     *
     * @var String $panelContent_2 Panel 2 Content    
     */
    protected $panelContent_2;  
    
    /**
     *
     * @var String $panelContent_3 Panel 3 Content 
     */
    protected $panelContent_3;   
	

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
    function __construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID) {  //constructor  
        //initialise the model
        $this->user=$user;
        $this->loggedin=$this->user->getLoggedInState();
        $this->db=$db;
        $this->postArray=$postArray;
        $this->pageID=$pageID;
        $this->panelModelObjects=array();
        
        //set the PAGE title
        $this->setPageTitle($pageTitle);

        //set the PAGE heading
        $this->setPageHeading($pageHead);

        //set the SECOND panel content BEFORE Panel 1
        $this->setPanelHead_2();
        $this->setPanelContent_2();          
        
        //set the FIRST panel content
        $this->setPanelHead_1();
        $this->setPanelContent_1();


        //set the THIRD panel content
        $this->setPanelHead_3();
        $this->setPanelContent_3();
    
    } //end METHOD - constructor

    //Headings METHODS
    /**
     * Set the page title
     * 
     * @param String $pageTitle The page title
     * 
     */
    public function setPageTitle($pageTitle){ //set the page title    
            $this->pageTitle=$pageTitle;
    }  //end METHOD -   set the page title   

    /**
     * Set the page heading
     * 
     * @param String $pageHead The page heading
     * 
     */
    public function setPageHeading($pageHead){ //set the page heading  
            $this->pageHeading=$pageHead;
    }  //end METHOD -   set the page heading
    

    //Abstract Methods
    /**
     * Set the Panel 1 heading (abstract method)
     */
    abstract public function setPanelHead_1();//set the panel 1 heading
     /**
     * Set the Panel 1 text content  (abstract method)
     */
    abstract public function setPanelContent_1();//set the panel 1 content      
     /**
     * Set the Panel 2 heading (abstract method)
     */
    abstract public function setPanelHead_2(); //set the panel 2 heading   
     /**
     * Set the Panel 2 text content  (abstract method)
     */
    abstract public function setPanelContent_2();//set the panel 2 content
    /**
     * Set the Panel 3 heading (abstract method)
     */
    abstract public function setPanelHead_3(); //set the panel 3 heading  
     /**
     * Set the Panel 3 text content  (abstract method)
     */
    abstract public function setPanelContent_3(); //set the panel 2 content     
 
    
    //GETTER METHODS
    
    /**
     * Returns the page title
     * 
     * @return string
     */
    public function getPageTitle(){return $this->pageTitle;}
    
    /**
     * Returns the page heading
     * 
     * @return string
     */    
    public function getPageHeading(){return $this->pageHeading;}
    
    /**
     * Returns the panel 1 heading
     * 
     * @return string
     */
    public function getPanelHead_1(){return $this->panelHead_1;}
 
    /**
     * Returns the panel 1 content
     * 
     * @return string
     */    
    public function getPanelContent_1(){return $this->panelContent_1;}
 
    /**
     * Returns the panel 2 heading
     * 
     * @return string
     */
    public function getPanelHead_2(){return $this->panelHead_2;}
    
    /**
     * Returns the panel 2 content
     * 
     * @return string
     */     
    public function getPanelContent_2(){return $this->panelContent_2;}

    /**
     * Returns the panel 3 heading
     * 
     * @return string
     */    
    public function getPanelHead_3(){return $this->panelHead_3;}

    /**
     * Returns the panel 3 content
     * 
     * @return string
     */     
    public function getPanelContent_3(){return $this->panelContent_3;}
    
    
    /**
     * Provides diagnostic information in HTML format relating to the class properties
     * 
     * @return string $diagnostic Diagnostic information in HTML format relating to the class properties
     */
    public function getDiagnosticInfo(){
        $diagnostic = '<div class="container-fluid"   style="background-color: #AAAAC0">'; //outer DIV
            $diagnostic .= '<h3>PANEL MODEL CLASS: '.$this->modelType.' - properties</h3>';
            $diagnostic .= '<table border=1 border-style: dashed; style="background-color: #EEEEE0" >';
            $diagnostic .= '<tr><th>PROPERTY</th><th>VALUE</th></tr>';
            $diagnostic .= "<tr><td>pageTitle</td>    <td>".$this->pageTitle."</td></tr>";
            $diagnostic .= "<tr><td>pageHeading</td>  <td>".$this->pageHeading."</td></tr>";
            $diagnostic .= "<tr><td>panelHead_1</td>  <td>$this->panelHead_1</td></tr>";
            $diagnostic .= "<tr><td>panelContent_1</td><td>$this->panelContent_1</td></tr>";
            $diagnostic .= "<tr><td>panelHead_2</td>  <td>$this->panelHead_2</td></tr>";
            $diagnostic .= "<tr><td>panelContent_2</td><td>$this->panelContent_2</td></tr>";
            $diagnostic .= "<tr><td>panelHead_3</td>  <td>$this->panelHead_3</td></tr>";
            $diagnostic .= "<tr><td>panelContent_3</td><td>$this->panelContent_3</td></tr>";
            $diagnostic .= "<tr><td></td><td>         </td></tr>";
            $diagnostic .= "<tr><td></td><td>         </td></tr>";
            $diagnostic .= '</table>';
            $diagnostic .= '<p><hr>';
            
            //panel model classes diagnostic
            $diagnostic .=  '<section style="background-color: #EEEEE0">'; //light blue
                $diagnostic .=  '<h4>PANEL MODEL CLASS - Class Objects</h4>';
                $diagnostic .=  '<pre>';
                foreach($this->panelModelObjects as $object){$diagnostic .=  $object->getDiagnosticInfo();}
                $diagnostic .=  '</pre>';
            $diagnostic .=  '</section>';
            
            
        $diagnostic .= '</div>';
        return $diagnostic;
    }
}


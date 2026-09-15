<?php
/**
* This file contains the UnderConstruction Class
* 
*/


/**
 * UnderConstruction is an extended PanelModel Class
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for an <em><b>UNDER CONSTRUCTION</b></em>  page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * This class is intended as a PLACEHOLDER during Development - Use the XXXPanelContent class to implement 
 * its replacement. 
 *
 * @author gerry.guinane
 * 
 */

class UnderConstruction extends PanelModel {
  
    /**
    * Constructor Method
    * 
    * The constructor for the PanelModel class. The UnderConstruction class provides the 
    * panel content for up to 3 page panels.
    * 
    * @param User $user  The current user
    * @param MySQLi $db The database connection handle
    * @param Array $postArray Copy of the $_POST array
    * @param String $pageTitle The page Title
    * @param String $pageHead The Page Heading
    * @param String $pageID The currently selected Page ID
    * 
    */  
    function __construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID){  
        $this->modelType='UnderConstruction';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 

    
    /**
     * Set the Panel 1 heading 
     */
    public function setPanelHead_1(){
        
        switch ($this->pageID) {
            case "menuItem1":  //sample menu item handler
                $this->panelHead_1='<h3>Menu Item 1</h3>';
                break;
            case "menuItem2":  //sample menu item handler
                $this->panelHead_1='<h3>Menu Item 2</h3>';
                break;
            default:  //sample DEFAULT menu item handler
                $this->panelHead_1='<h3>Menu Item</h3>';
                break;
            }//end switch   
        
    }
    
    /**
    * Set the Panel 1 text content 
    */ 
    public function setPanelContent_1(){
        
        switch ($this->pageID) {
            case "menuItem1":  //sample menu item handler
                $this->panelContent_1="Panel 1 content for \$pageID <b>$this->pageID</b> menu item is under construction.";
                break;
            case "menuItem2":  //sample menu item handler
                $this->panelContent_1="Panel 1 content for \$pageID <b>$this->pageID</b> menu item is under construction.";
                break;
            default:  //sample DEFAULT menu item handler
                $this->panelContent_1="Panel 1 content for \$pageID <b>$this->pageID</b> menu item is under construction.";
                break;
            }//end switch   
        
    }        

    /**
     * Set the Panel 2 heading 
     */
    public function setPanelHead_2(){ 
        switch ($this->pageID) {
            case "menuItem1":  //sample menu item handler
                $this->panelHead_2='<h3>Menu Item 1</h3>';
                break;
            case "menuItem2":  //sample menu item handler
                $this->panelHead_2='<h3>Menu Item 2</h3>';
                break;
            default:  //sample DEFAULT menu item handler
                $this->panelHead_2='<h3>Menu Item</h3>';
                break;
            }//end switch   
    }  
    
    /**
    * Set the Panel 2 text content 
    */ 
    public function setPanelContent_2(){
        switch ($this->pageID) {
            case "menuItem1":  //sample menu item handler
                $this->panelContent_2="Panel 2 content for \$pageID <b>$this->pageID</b> menu item is under construction.";
                break;
            case "menuItem2":  //sample menu item handler
                $this->panelContent_2="Panel 2 content for \$pageID <b>$this->pageID</b> menu item is under construction.";
                break;
            default:  //sample DEFAULT menu item handler
                $this->panelContent_2="Panel 2 content for \$pageID <b>DEFAULT</b> menu item is under construction.";
                break;
            }//end switch   
    }

    /**
     * Set the Panel 3 heading 
     */
    public function setPanelHead_3(){ 
        switch ($this->pageID) {
            case "menuItem1":  //sample menu item handler
                $this->panelHead_3='<h3>Menu Item 1</h3>';
                break;
            case "menuItem2":  //sample menu item handler
                $this->panelHead_3='<h3>Menu Item 2</h3>';
                break;
            default:  //sample DEFAULT menu item handler
                $this->panelHead_3='<h3>Menu Item</h3>';
                break;
            }//end switch   
    } 
    
    /**
    * Set the Panel 3 text content 
    */ 
    public function setPanelContent_3(){
        switch ($this->pageID) {
            case "menuItem1":  //sample menu item handler
                $this->panelContent_3="Panel 3 content for \$pageID <b>$this->pageID</b> menu item is under construction.";
                break;
            case "menuItem2":  //sample menu item handler
                $this->panelContent_3="Panel 3 content for \$pageID <b>$this->pageID</b> menu item is under construction.";
                break;
            default:  //sample DEFAULT menu item handler
                $this->panelContent_3="Panel 3 content for \$pageID <b>DEFAULT</b> menu item is under construction.";
                break;
            }//end switch   
    }        

        
        
}
        
<?php
/**
* This file contains the PanelModelInterface Class
 * 
*/


/**
 * Interface class defining the getter and setter methods that are 
 * required to support a 3 panel view. 
 * 
 * Content and headings for each of the the 3 panels can be set and 
 * returned. Page heading and title can also be set and returned. 
 * 
 * @author Gerry Guinane
 * 
 */
interface PanelModelInterface {


    //Page Title and heading
    /** 
     * Setter for Page Title
     * @param String  $pageTitle  String value containing the page title   */
    public function setPageTitle($pageTitle); //set the page title 
    /** 
     * Setter for Page Heading
     * @param String  $pageHead  String value containing the page heading     */
    public function setPageHeading($pageHead); //set the page heading
    
    //Panel 1
    /** Setter for the Panel 1 Heading */
    public function setPanelHead_1();
    /** Setter for Panel 1 Content */
    public function setPanelContent_1();
    
    //Panel2
    /** Setter for the Panel 2 Heading */
    public function setPanelHead_2(); 
    /** Setter for the Panel 3 Content */
    public function setPanelContent_2();
    
    //Panel 3
    /** Setter the Panel 3 Heading */
    public function setPanelHead_3(); 
    /** Setter the Panel 3 Content */
    public function setPanelContent_3(); 
    
    //Getters

    /**
     * Getter for the Page Title 
     * @return String Containing the Page Title */
    public function getPageTitle();
    /** 
     * Getter for the Page Heading
     * @return String Containing the Page Heading */
    public function getPageHeading();
    /** 
     * Getter for the Panel 1 Heading
     * @return String Containing the Panel 1 Heading */
    public function getPanelHead_1();
    /** 
     * Getter for the Panel 1 Content
     * @return String Containing the Panel 1 Content*/
    public function getPanelContent_1();
    /** 
     * Getter for the Panel 2 Heading
     * @return String Containing the Panel 2 Heading */
    public function getPanelHead_2();
    /** 
     * Getter for the Panel 2 Content
     * @return String Containing the Panel 2 Content*/
    public function getPanelContent_2();
    /**
     * Getter for the Panel 3 Heading
     * @return String Containing the Panel 3 Heading */
    public function getPanelHead_3();
    /**
     * Getter for the Panel 3 Content
     * @return String Containing the Panel 3 Content*/
    public function getPanelContent_3();
    
    
}

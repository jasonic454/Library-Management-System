<?php
/**
* This file contains the CustomerMessages Class
* 
*/


/**
 * CustomerMessages is an extended PanelModel Class
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for a <em><b>CUSTOMER user messages</b></em>  page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * @author gerry.guinane
 * 
 */



class CustomerMessages extends PanelModel{


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
        $this->modelType='CustomerMessages';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 



    /**
     * Set the Panel 1 heading 
     */
    public function setPanelHead_1(){
        switch ($this->pageID) {

            case "messages":
                $this->panelHead_1='<h3>Messages</h3>';
                break;
            case "livechat":
                $this->panelHead_1='<h3>Live Chat</h3>';
                break;
            case "deleteMsg":
                $this->panelHead_1='<h3>Delete - My Messages</h3>';
                break;
            case "viewMsgs":
                $this->panelHead_1='<h3>View Messages Addressed to Me or to All other users</h3>';
                break;
            case "sendMsg":
                $this->panelHead_1='<h3>Send Messages</h3>';
                break;
            default:
                $this->panelHead_1='<h3>Messages</h3>';
                break;
            }//end switch       
    }
    
    /**
    * Set the Panel 1 text content 
    */      
    public function setPanelContent_1(){
        switch ($this->pageID) {
            case "messages":
                $this->panelContent_1='This messages sub-menu illustrates a number of different implementations of messaging between users - including live chat which utilises AJAX';
                break;
            case "livechat":
                $this->panelContent_1= Form::form_add_msg($this->pageID);
                break;
            case "viewMsgs":
                $table=new ChatMsgTable($this->db);
                $rs=$table->getUserMessages($this->user->getUserID());
                $this->panelContent_1= HelperHTML::generateTABLE($rs);
                array_push($this->panelModelObjects,$table); #for diagnostic purposes
                break;
            case "deleteMsg":
                $this->panelContent_1='';

                if (isset($this->postArray['btnRecordSelected'])){
                    $table=new ChatMsgTable($this->db);
                    if($table->deleteRecordbyID($this->postArray['recordSelected'])){
                        $this->panelContent_1.='Message (msgID='.$this->postArray['recordSelected'].') has been deleted';

                    }
                    else{
                        $this->panelContent_1.='Unable to delete selected record';
                    }
                    array_push($this->panelModelObjects,$table); #for diagnostic purposes
                }
                else{
                    $this->panelContent_1.='Select a message to delete'; 
                }                
                $this->panelContent_1.='<hr>';

                $table=new ChatMsgTable($this->db);
                $rs=$table->getUserAuthoredMessages($this->user->getUserID());
                $this->panelContent_1.= HelperHTML::generateSelectTABLE($rs,'msgID',$this->pageID,'Delete');
                array_push($this->panelModelObjects,$table); #for diagnostic purposes
                break;                
            case "sendMsg":
                $this->panelContent_1= Form::form_add_msg($this->pageID);
                break;
            default:
                $this->panelContent_1='Messages';
                break;            
            }//end switch  
    }        

    /**
     * Set the Panel 2 heading 
     */
    public function setPanelHead_2(){ 
        switch ($this->pageID) {
            case "messages":
                $this->panelHead_2='<h3>Messages</h3>';
                break;
            case "livechat":
                $this->panelHead_2='<h3>Live Chat</h3>';
                break;
            case "viewMsgs":
                $this->panelHead_2='<h3>View Messages</h3>';
                break;
            case "sendMsg":
                $this->panelHead_2='<h3>Send Messages</h3>';
                break;
            case "deleteMsg":
                $this->panelHead_2='<h3>Delete My Messages</h3>';
                break;                
            default:
                $this->panelHead_2='<h3>Messages</h3>';
                break;            
            }//end switch
    }   
    
    /**
    * Set the Panel 2 text content 
    */      
    public function setPanelContent_2(){
        switch ($this->pageID) {
            case "messages":
                $this->panelContent_2='This messages sub-menu illustrates a number of different implementations of messaging between users - including live chat which utilises AJAX';
                break;
            case "livechat":
                if (isset($this->postArray['btnAddMsg'])){


                    //set the message recipient to ALL if its not specified in the form
                    if (isset($this->postArray['msgTo']))  {$msgRecipient=$this->postArray['msgTo'];} else {$msgRecipient='ALL';}

                    $table=new ChatMsgTable($this->db);

                    //make sure the user has not addressed the message to their own ID
                    if ($msgRecipient===$this->user->getUserID()) {
                        $this->panelContent_2='<div id="chat">Chat messages will appear here if chat is enabled</div>';
                        $this->panelContent_2.='Message not sent - You cant address a message to yourself!';      
                    }
                    else { //a legitimate recipient is specified - add the message to the chatMessage table
                        $table=new ChatMsgTable($this->db);
                        
                        if($table->addRecord($this->postArray,$this->user)){
                            $this->panelContent_2='<div id="chat">Chat messages will appear here if chat is enabled</div>';
                            $this->panelContent_2.='<hr>Message Sent Successfully ';
                        }
                        else{ //something went wrong
                            $this->panelContent_2='<div id="chat">Chat messages will appear here if chat is enabled</div>';
                            $this->panelContent_2.='Unable to update record';
                        }       
                    }                    

                }
                else{
                    $this->panelContent_2='<div id="chat">Chat messages will appear here if chat is enabled</div>';
                }

                break;
            case "viewMsgs":
                $this->panelContent_2='View Messages';
                break;
            case "sendMsg":
                if (isset($this->postArray['btnAddMsg'])){


                    //set the message recipient to ALL if its not specified in the form
                    if (isset($this->postArray['msgTo'])) 
                    {
                        $msgRecipient=$this->postArray['msgTo']; 
                    }
                    else 
                    {
                            $msgRecipient='ALL';
                    }

                    //make sure the user has not addressed the message to their own ID
                    if ($msgRecipient===$this->user->getUserID()) { $this->panelContent_2='You cant address a message to yourself!'; }
                    else { //a legitimate recipient is specified - add the message to the chatMessage table
                        $table=new ChatMsgTable($this->db);
                        //if($table->addRecord($this->postArray,$this->user->getUserID(),$this->user->getUserType(),$msgRecipient)){
                        if($table->addRecord($this->postArray,$this->user,$msgRecipient)){
                            $this->panelContent_2='Message Sent ';
                        }
                        else{
                            $this->panelContent_2='Unable to update record';
                        }       
                    }


                }
                else{
                    $this->panelContent_2='Send Messages'; 
                }
                break;
            case "deleteMsg":
                if (isset($this->postArray['btnRecordSelected'])){
                    $table=new ChatMsgTable($this->db);
                    if($table->deleteRecordbyID($this->postArray['recordSelected'])){
                        $this->panelContent_2='Message (msgID='.$this->postArray['recordSelected'].') has been deleted';
                        $this->setPanelContent_1(); //update panel 1 content to show updated table of messages

                    }
                    else{
                        $this->panelContent_2='Unable to delete selected record';
                    }
                }
                else{
                    $this->panelContent_2='Select a message to delete'; 
                }
                break;    

            default:
                $this->panelContent_2='Messages';
                break;   
            }//end switch

    }        

    /**
     * Set the Panel 3 heading 
     */
    public function setPanelHead_3(){ 
        switch ($this->pageID) {
            case "messages":
                $this->panelHead_3='<h3>Messages</h3>';
                break;
            case "livechat":
                $this->panelHead_3='<h3>Live Chat</h3>';
                break;
            case "viewMsgs":
                $this->panelHead_3='<h3>View Messages</h3>';
                break;
            case "sendMsg":
                $this->panelHead_3='<h3>Send Messages</h3>';
                break;
            default:
                $this->panelHead_3='<h3>Messages</h3>';
                break;            
            }//end switch
    }
    
    /**
    * Set the Panel 3 text content 
    */      
    public function setPanelContent_3(){//set the panel 2 content
        switch ($this->pageID) {
            case "messages":
                $this->panelContent_3='This messages sub-menu illustrates a number of different implementations of messaging between users - including live chat which utilises AJAX';
                break;
            case "livechat":
                $this->panelContent_3='Live chat content';
                break;
            case "viewMsgs":
                $this->panelContent_3='View Messages';
                break;
            case "sendMsg":
                $this->panelContent_3='Send Messages';
                break;
            default:
                $this->panelContent_3='Messages';
                break;   
            }//end switch

    }    



        
}//end class
        
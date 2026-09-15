<?php
/**
* This file contains the configuration settings  for this application
* 
*/

/**
* This file contains settings that are required by the framework and to control
 * how it operates.  
* 
*/

/**
 * 
 * @global String FRAMEWORK_VERSION The current release version of the DDA Framework
 * 
 */
define ('FRAMEWORK_VERSION','16.20260309');  //The current release version of the DDA Framework


/**
 * 
 * @global Boolean DEBUG_MODE True for DEBUG mode turned on
 * 
 */
define ('DEBUG_MODE',FALSE);  //True for DEBUG mode turned on


/**
 * 
 * @global Boolean ENCRYPT_PW True for password encryption enabled
 * 
 */
define ('ENCRYPT_PW',TRUE);  //True if Passwords are hash encrypted

/**
 * 
 * @global String PAGE_TITLE String containing the page title (appears in the browser tab) of all pages in this application.
 * 
 */
define ('PAGE_TITLE','DDA Framework'); //site wide page title (tab label at top of web page)

//AJAX Configuration - read the SETUP INSTRUCTIONS

/**
 * 
 * @global Boolean CHAT_ENABLED True if AJAX Chat  is enabled (Part of AJAX live chat configuration)
 * 
 */
define ('CHAT_ENABLED',FALSE);  //True if AJAX Chat  is enabled


/**
 * 
 * @var String $serverIP_address - IP address of the Apache Web Server (Part of AJAX live chat configuration)
 * 
 */
$serverIP_address='192.168.1.8:80';  //change to network IP address and port  of the Apache Server 

/**
 * 
 * @var String $root_path - document root path of the Apache Web Server (Part of AJAX live chat configuration)
 * 
 */
$root_path='k00999999/Framework_16/'; //change to correct path from htdocs folder to the default page (usually index.php) of this web application


/**
 * 
 * @global String __THIS_URI_ROOT - Full URI of this application on the Apache Web Server (Part of AJAX live chat configuration)
 * 
 */
define ('__THIS_URI_ROOT','http://'.$serverIP_address.'/'.$root_path);  //Define root URL folder for this website


//Note no PHP end tag in this file : 
//If a file contains only PHP code, it is preferable to omit the PHP closing tag at the end of the file.
//This prevents accidental whitespace or new lines being added after the PHP closing tag

//**DO NOT EDIT BELOW THIS LINE**
//===========================================================

//initialise the installation variables
$appName=PAGE_TITLE;  //default application name
$installed=FALSE;//TRUE if installed. Used only for Practical Assessments
$practicalAck=FALSE;//Flag used during Practical Assessments 

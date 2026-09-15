<?php
/**
* This HTML file contains a single panel VIEW template with navbar.  
* 
*/


/**
 * 
 * This HTML file contains a single panel VIEW template with navbar.
 * 
 * The template contains PHP placeholders for page content. The content is passed to 
 * this VIEW via the $data array
 *
 * @author gerry.guinane
 * 
 */


 /*
  * @var array $data Array containing page content elements. 
  * 
  */
extract($data);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $pageTitle;?></title>
<?php include_once('css/css.php'); //the css file may be edited to add additional styling to the application if required?>


<!--
<!--
<!--
--Load the bootstrap scripts by reference
--Note the use of the 'integrity' property
--More info on that property here: https://blog.compass-security.com/2015/12/subresource-integrity-html-attribute/
-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"  >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>

<!--If chat function is enabled - include the javascript that contains the AJAX chat implementation -->
<?php	if(CHAT_ENABLED){include("javascript/chat.php");}?>
<!--apply any local styles if required -->

<style type="text/css">
    body{
        padding-top: 70px;
    }
</style>
</head> 

<!--If chat function is enabled - start the AJAX functions-->
<?php	if(CHAT_ENABLED){echo '<body onload="doTimer()">';}else {echo '<body>';}?>
    
<div class="container">

<!--Main SECTION--> 

<!--Top of page Navigation menus-->    
<nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand"><?php echo $pageHeading?></a>
        </div>
        <!-- Collection of nav links and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
		<?php //foreach($menuNav as $menuItem){echo "<li>$menuItem</li>";} //populate the navbar menu items?>
                <?php echo $menuNav; ?>
            </ul>
        </div>
    </div>
</nav>


<!--Main container for page content-->  
<div class="container-fluid"> 

     
<div class="row">
    <!-- content panel--> 
    <div class="col-md-12" style="background-color:white;">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo $panelHead_1; ?></div>
              <div class="panel-body">
                    <?php echo $panelContent_1; ?>
              </div>
            </div>
    </div>

</div>

</div>  <!--end of main content container-->
</div>  <!--end of main container-->
                             		
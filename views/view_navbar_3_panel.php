<?php
extract($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $pageTitle;?></title>
<?php include_once('css/css.php'); ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php if(CHAT_ENABLED){include("javascript/chat.php");}?>

<style type="text/css">
    body{
        padding-top: 70px;
    }
</style>
</head> 

<?php if(CHAT_ENABLED){echo '<body onload="doTimer()">';}else {echo '<body>';}?>

<section>

<nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand"><?php echo $pageHeading?></a>
        </div>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php echo $menuNav; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">

<div class="row">
   
    <!-- LEFT PANEL -->
    <div class="col-md-4" style="background-color:white;">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $panelHead_1; ?></div>
            <div class="panel-body">
                <?php echo $panelContent_1; ?>
            </div>
        </div>
    </div>

    <!-- MAIN PANEL -->
    <div class="col-md-8" style="background-color:white;">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $panelHead_2; ?></div>
            <div class="panel-body">
                <?php echo $panelContent_2; ?>
            </div>
        </div>
    </div>        

    

</div>

</div>

</section>    
</body>
</html>
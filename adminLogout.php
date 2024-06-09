<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

<?php 
$_SESSION["UserId"]=null;
$_SESSION["UserName"]=null;
$_SESSION["AdminName"]=null;

session_destroy();

Redirect_to("login.php");

?>
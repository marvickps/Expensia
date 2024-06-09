<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php $conn = new mysqli('localhost', 'root', '', 'expensia'); ?>



<?php
    if(isset($_POST["Submit"])){
        $Category = $_POST["category"];
        $StartDate = $_POST["startdate"];
        $EndDate = $_POST["enddate"];

    

    }
    $UserID = $_SESSION["UserId"];

    $sql = "SELECT * FROM expenses WHERE user_id=$UserID ORDER BY e_id desc;";
    $stmt = $ConnectingDB->query($sql);
    $Sr=0;
    while($DataRows = $stmt->fetch()){
        $Id = $DataRows["e_id"];
        
        $DateTime = $DataRows["datetime"];
        $CategoryName = $DataRows["cat_name"];
        $ExAmount = $DataRows["ex_amount"];
        $ExComment = $DataRows["ex_comment"];
        $balance = $DataRows["balance"];
        $Sr++;
    ?>
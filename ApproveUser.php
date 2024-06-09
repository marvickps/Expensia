<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

<?php 
    if(isset($_GET["id"])){
        $id_From_URl = $_GET["id"];
        
        $Admin = $_SESSION["Username"];
        $sql = "UPDATE user SET status='ON' WHERE u_id='$id_From_URl'";
        $Execute = $ConnectingDB->query($sql);
         if ($Execute) {
          $sql = "INSERT INTO wallet(amount,daily,weekly,monthly,u_id) VALUES";
          $sql .= "(0,0,0,0, $id_From_URl)";
          $stmt = $ConnectingDB->prepare($sql);
          
          
          

          $Execute=$stmt->execute();
          $_SESSION["SuccessMessage"]="User Approved Successfully ! ";
          Redirect_to("adminDashboard.php");
    
        }else {
          $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
         Redirect_to("adminDashboard.php");
  }

    }


?>
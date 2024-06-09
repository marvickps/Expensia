  <?php require_once("includes/DB.php"); ?>
  <?php require_once("includes/Function.php"); ?>
  <?php require_once("includes/Sessions.php"); ?>

  <?php 
      if(isset($_GET["id"])){
          $id_From_URl = $_GET["id"];
          
          
          $sql = "UPDATE user SET status='OFF' WHERE u_id='$id_From_URl'";
          $Execute = $ConnectingDB->query($sql);
          if ($Execute) {
            $sql = "DELETE FROM wallet WHERE u_id='$id_From_URl'";
            $Execute = $ConnectingDB->query($sql);
              $_SESSION["SuccessMessage"]="User Disapproved Successfully ! ";
              Redirect_to("adminDashboard.php");
      
          }else {
            $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
          Redirect_to("adminDashboard.php");
    }

      }


  ?>
<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php $conn = new mysqli('localhost', 'root', '', 'expensia'); ?>

<?php 
    if(isset($_GET["id"])){
        $userID = $_SESSION["UserId"];
        $id_From_URL = $_GET["id"];

        $sqlWallet = "SELECT amount FROM wallet WHERE u_id = $userID";

        $walletResult = $conn->query($sqlWallet);
        $walletRow = $walletResult->fetch_assoc();
        $amountFromWallet=$walletRow['amount'];

        $sqlExpense = "SELECT ex_amount FROM expenses WHERE e_id = $id_From_URL";

        $expenseResult = $conn->query($sqlExpense);   
        $expenseRow = $expenseResult->fetch_assoc();
        $expenseAmount=$expenseRow['ex_amount'];
        
        $sql = "DELETE FROM expenses WHERE e_id='$id_From_URL'";

        $Execute = $ConnectingDB->query($sql);
         if ($Execute) {
            $sql = "UPDATE wallet set amount=amount+$expenseAmount WHERE u_id='$userID'";
            $Execute = $ConnectingDB->query($sql);

            $_SESSION["SuccessMessage"]="Expense Deleted Successfully ";
            Redirect_to("userPage.php");
    
        }else {
        $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
        Redirect_to("userPage.php");
  }

    }

                          
?>

<?php 
require_once("includes/DB.php");
require_once("includes/Function.php");
require_once("includes/Sessions.php");

if(isset($_GET["id"])) {
    $id_From_URL = $_GET["id"];

    // Delete dependent records from the wallet table first
    $sql_delete_wallet = "DELETE FROM wallet WHERE u_id=:userId";
    $stmt_delete_wallet = $ConnectingDB->prepare($sql_delete_wallet);
    $stmt_delete_wallet->bindValue(':userId', $id_From_URL);
    $stmt_delete_wallet->execute();

    // Then delete dependent records from the expenses table
    $sql_delete_expenses = "DELETE FROM expenses WHERE user_id=:userId";
    $stmt_delete_expenses = $ConnectingDB->prepare($sql_delete_expenses);
    $stmt_delete_expenses->bindValue(':userId', $id_From_URL);
    $stmt_delete_expenses->execute();

    // Then delete dependent records from the categories table
    $sql_delete_categories = "DELETE FROM categories WHERE u_id=:userId";
    $stmt_delete_categories = $ConnectingDB->prepare($sql_delete_categories);
    $stmt_delete_categories->bindValue(':userId', $id_From_URL);
    $stmt_delete_categories->execute();

    // Finally, delete the user
    $sql_delete_user = "DELETE FROM user WHERE u_id=:userId";
    $stmt_delete_user = $ConnectingDB->prepare($sql_delete_user);
    $stmt_delete_user->bindValue(':userId', $id_From_URL);
    $Execute = $stmt_delete_user->execute();

    if ($Execute) {
        $_SESSION["SuccessMessage"] = "User Deleted Successfully";
        
        Redirect_to("adminDashboard.php");
    } else {
        $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again!";
        Redirect_to("AdminDashboard.php");
    }
}
?>

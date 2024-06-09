<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php $conn = new mysqli('localhost', 'root', '', 'expensia'); ?>



<?php
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_SESSION["UserId"];
    if(!empty($_POST['date'])) {
        
        $date = $_POST['date']; 
        
        $DateTime = date("d-m-Y", strtotime($date));// This assumes you're submitting the form data via POST method
        
    } else {

        date_default_timezone_set("Asia/Calcutta");
        $CurrentTime=time();
        $DateTime=strftime("%d-%m-%Y", $CurrentTime);
    }

    $sqlWallet = "SELECT amount FROM wallet WHERE u_id = $userID";
    $walletResult = $conn->query($sqlWallet);
    $walletRow = $walletResult->fetch_assoc();
    $amountFromWallet=$walletRow['amount'];
    
    
    
    $amount = $conn->real_escape_string($_POST['exAmount']);
    $category = $conn->real_escape_string($_POST['category']);
    $comment = $conn->real_escape_string($_POST['comment']);

    $balance = $amountFromWallet - $amount;


    $category_query = "SELECT c_id FROM categories WHERE name = '$category'";
    $result = $conn->query($category_query);
    $row = $result->fetch_assoc();
    $category_id = $row['c_id'];
    
    $sql = "INSERT INTO expenses (user_id, datetime, ex_amount, cat_name, ex_comment, balance) VALUES ('$userID','$DateTime','$amount', '$category', '$comment','$balance')";

    if ($conn->query($sql) === TRUE){
            $sql = "UPDATE wallet set amount=$balance WHERE u_id='$userID'";
            $Execute = $ConnectingDB->query($sql);
            
            $_SESSION["SuccessMessage"]="Expense added with ₹".$amount.
            " to the " .$category. " Successfully";

            Redirect_to("userPage.php");
        }
        else{
            $_SESSION["ErrorMessage"]="Something went wrong !";
            Redirect_to("userPage.php");
        }

    // Close connection
    $conn->close();
}
?>
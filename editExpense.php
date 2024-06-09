<?php 
require_once("includes/DB.php");
require_once("includes/Function.php");
require_once("includes/Sessions.php");

$conn = new mysqli('localhost', 'root', '', 'expensia');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$ex_Id = $_GET["id"];

if (isset($_POST["Submit"])) {


    if(!empty($_POST['date'])) {
        
        $date = $_POST['date']; 
        
        $DateTime = date("d-m-Y", strtotime($date));// This assumes you're submitting the form data via POST method
        
    } else {

        date_default_timezone_set("Asia/Calcutta");
        $CurrentTime=time();
        $DateTime=strftime("%d-%m-%Y", $CurrentTime);
    }

    

    $amount = $conn->real_escape_string($_POST['exAmount']);
    $category = $conn->real_escape_string($_POST['category']);
    $comment = $conn->real_escape_string($_POST['comment']);


    $expense_query = "SELECT ex_amount, balance FROM expenses WHERE e_id = $ex_Id";
    $expense_result = $conn->query($expense_query);

    if ($expense_result === false) {
        die("Error fetching expense details: " . $conn->error);
    }

    $expense_row = $expense_result->fetch_assoc();
    if (!$expense_row) {
        die("Expense not found");
    }

    $oldAmount = $expense_row['ex_amount'];
    $oldBalance = $expense_row['balance'];

    $category_query = "SELECT c_id FROM categories WHERE name = '$category'";
    $category_result = $conn->query($category_query);
    $category_row = $category_result->fetch_assoc();
    $category_id = $category_row['c_id'];


    $newBalance = $oldBalance + $oldAmount - $amount;


    $sql = "UPDATE expenses SET datetime = '$DateTime', ex_amount = '$amount', cat_name = '$category', ex_comment = '$comment', balance = '$newBalance' WHERE e_id = $ex_Id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION["SuccessMessage"] = "Expense updated successfully";
        Redirect_to("userPage.php");
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong!";
        Redirect_to("userPage.php");
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-purple-500">

    <?php 
        $ex_Id = $_GET["id"];

        // Fetch current expense details
        $expense_query = "SELECT * FROM expenses WHERE e_id = $ex_Id";
        $expense_result = $conn->query($expense_query);
        if (!$expense_result || $expense_result->num_rows == 0) {
            die("Expense not found");
        }
        $expense_row = $expense_result->fetch_assoc();
        
        // Assign fetched values to variables
        $exAmount = $expense_row['ex_amount'];
        $date = $expense_row['datetime'];
        $category = $expense_row['cat_name'];
        $comment = $expense_row['ex_comment'];

    ?>
    <div class="min-h-screen flex justify-center items-center">
    <div class="min-h-screen flex justify-center items-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Edit Expense</h2>
            <form action="editExpense.php?id=<?php echo $ex_Id; ?>" method="POST">
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 font-bold mb-2">Amount:</label>
                    <input type="number" id="amount" name="exAmount" placeholder="Enter the amount" required value="<?php echo $exAmount; ?>"
                        class="block w-full rounded-md border-0 px-3.5 text-gray-800 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 font-bold mb-2">Date:<div class="font-normal font-mono text-gray-600"><?php echo $date; ?></div></label>
                    <input type="date" id="date" name="date" value="<?php echo $date; ?>" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                                <label for="category" class="block text-gray-700 font-bold mb-2">Category:</label>
                                <select id="category" name="category" required class="block w-full rounded-md border-0 px-3.5 text-gray-800 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="" disabled selected><?php echo htmlentities($category) ?></option>
                                    <?php
                                        $UserID=$_SESSION["UserId"];
                                        $sql = "SELECT * FROM categories where u_id = $UserID ORDER BY c_id desc";
                                        $stmt = $ConnectingDB->query($sql);
                                        $Sr=0;
                                        while($DataRows = $stmt->fetch()){
                                            $Id = $DataRows["c_id"];
                                            $CategoryName = $DataRows["name"]; 
                                            $Sr++;
                                            ?>
                                    
                                    
                                    <option value='<?php echo htmlentities($CategoryName); ?>'><?php echo htmlentities($CategoryName); ?></option>
                                    <?php } ?>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="mb-4">
                    <label for="comment" class="block text-gray-700 font-bold mb-2">Comment:</label>
                    <textarea id="comment" name="comment" placeholder="Enter a comment"
                        class="block w-full rounded-md border-0 px-3.5 text-gray-800 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"><?php echo $comment; ?></textarea>
                </div>
                <input type="submit" name="Submit"
                    class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
            </form>
        </div>
    </div>
</body>

</html>

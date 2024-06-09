<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assuming $conn is your database connection object
// Replace it with your actual database connection code
$conn = new mysqli('localhost', 'root', '', 'expensia');

// Start the PHP block
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$UserID = $_SESSION["UserId"];
$query = "SELECT datetime, ex_amount FROM expenses WHERE STR_TO_DATE(datetime, '%d-%m-%Y') >= DATE_SUB(NOW(), INTERVAL 30 DAY) AND user_id=$UserID ORDER BY `expenses`.`datetime` ASC";
$result = $conn->query($query);

// Group expenses by date
$groupedExpenses = array();
while ($row = $result->fetch_assoc()) {
    $date = $row['datetime'];
    $amount = $row['ex_amount'];
    if (!isset($groupedExpenses[$date])) {
        $groupedExpenses[$date] = 0;
    }
    $groupedExpenses[$date] += $amount;
}

// Close connection
$conn->close();

// Return grouped expenses data as JSON
$json_data = json_encode($groupedExpenses);

// Send JSON header
header('Content-Type: application/json');

// Output JSON data
echo $json_data;
?>

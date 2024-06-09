<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php $conn = new mysqli('localhost', 'root', '', 'expensia'); ?>

<?php

if(isset($_POST['download'])) {
    $UserID = $_SESSION["UserId"];
    // SQL query to fetch data
    $query = "SELECT * FROM expenses WHERE user_id = $UserID ORDER BY e_id DESC";
    
    // Execute query
    $result = mysqli_query($conn, $query);
    
    // Check if there are rows returned
    if(mysqli_num_rows($result) > 0) {
        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=expenses.csv');
        
        // Create a file pointer
        $output = fopen('php://output', 'w');
        
        // Write column headers
        fputcsv($output, array('Expense ID', 'User ID', 'Date', 'Amount', 'Category','Details', 'Balance'));
        
        // Loop through the rows and write data to the CSV file
        while($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
        
        // Close file pointer
        fclose($output);
    } else {
        echo "No data found to download.";
    }
}
?>
<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php $conn = new mysqli('localhost', 'root', '', 'expensia'); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];

Confirm_Login();
?>
    
<?php
    
if(isset($_POST["SubmitCat"])){
    $Category = $_POST["CategoryName"];
    $userID = $_SESSION["UserId"];
    $Creator = $_SESSION["UserName"];
    date_default_timezone_set("Asia/Calcutta");
    $CurrentTime=time();
    $DateTime=strftime("%d-%m-%Y", $CurrentTime);

    if(empty($Category)){
        $_SESSION["ErrorMessage"]= "All fields must be filled out";
        Redirect_to("userPage.php");
    }
    elseif(strlen($Category)<3){
        $_SESSION["ErrorMessage"]= "Category title should be greater than 2 characters";
        Redirect_to("userPage.php");
    }
    elseif(strlen($Category)>49){
        $_SESSION["ErrorMessage"]= "Category title should be less than 50 characters";
        Redirect_to("userPage.php");
    }
    else{
        //query
        $sql = "INSERT INTO categories(name,u_id,creator,datetime)";
        $sql .= "VALUES(:categoryName,$userID,:creator,:datetime)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt-> bindValue(':categoryName', $Category);
        $stmt-> bindValue(':creator', $Creator);
        $stmt-> bindValue(':datetime', $DateTime);
        $Execute=$stmt->execute();
        
        if($Execute){
            $_SESSION["SuccessMessage"]="Category with id: ".$ConnectingDB->lastInsertId().
            " Added Successfully";
            Redirect_to("userPage.php");
        }
        else{
            $_SESSION["ErrorMessage"]="Something went wrong !";
            Redirect_to("userPage.php");
        }
    }
}
if(isset($_POST["Submit"])){
    $UserID = $_SESSION["UserId"];
    $Amount = $_POST["amount"];
    if(empty($Amount)){
        $_SESSION["ErrorMessage"]= "Amount must be filled out";
        Redirect_to("userPage.php");
    }else{
        $sql = "UPDATE wallet set amount=amount+$Amount WHERE u_id='$UserID'";
        $Execute = $ConnectingDB->query($sql);
            if($Execute){
                $_SESSION["SuccessMessage"]="Amount of ".$Amount.
                " Added to the Wallet Successfully";
                Redirect_to("userPage.php");
            }
            else{
                $_SESSION["ErrorMessage"]="Something went wrong !";
                Redirect_to("userPage.php");
            }
    }


}
?>

<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  

  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

  

  <script src="includes/script.js"></script>
  
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://cdn.tailwindcss.com"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    
  <script>
        window.onbeforeunload = function() {
            window.scrollTo(0, 0);
            }
    </script>



</head>
<script>
    function confirmDelete(event) {
        event.preventDefault(); // Prevent the default behavior of the link
        Swal.fire({
            title: "Are you sure you want to delete?",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it",
            cancelButtonText: "cancel",
            icon: "warning",
            confirmButtonColor: "rgb(220 38 38)",
            cancelButtonColor: "rgb(31 41 55)",
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, redirect to the delete URL
                window.location.href = event.target.href;
            }
        });
    }
</script>
<body>
    <nav id="navbar" class="bg-purple-600 fixed top-0 left-0 w-full flex items-center justify-between px-16 py-4">
            <div>
              <a href="landing.php" class="text-l font-bold  text-white"> <h1> EXPENSIA </h1> </a>
            </div>
            <div class="md:block">
              <ul class="flex space-x-4">
                <li><a href="userPage.php" class="text-white text-sm font-semibold px-2 hover:text-purple-300" >Home</a></li>
                
                <li><a href="ExpensesHistory.php" class="text-white text-sm font-semibold px-2 hover:text-purple-300">Expenses</a></li>
                <li><a href="landing.php#query" class="text-white text-sm font-semibold px-2 hover:text-purple-300">Contact</a></li>
              </ul>
            </div>
            <div >
                  <a href="logout.php" class="text-white text-sm font-semibold hover:text-purple-300 mr-4">Log out<i class="uil uil-arrow-right py-2"></i></a>
                  
                
                </div>
            
  </nav>
   
  <div class="container mx-auto my-12 p-8">
   <div class="sm:col-span-2 mb-2"><?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?></div> 

        

        <!-- Header -->
        <!-- <h1 class="text-3xl font-semibold mb-8">Expense Tracking Dashboard</h1> -->
        <div class="min-w-full bg-purple-500 shadow-md rounded-lg my-6 overflow-hidden">
            <div class="grid grid-cols-4 gap-4 p-4">
                <div class="flex items-center col-span-2">
                    <?php
                        $UserID = $_SESSION["UserId"];

                        $ImageQuery = "SELECT profileImage from user where u_id = $UserID";
                        $NameQuery = "SELECT uname from user where u_id = $UserID";
                                
                        $stmt = $conn->prepare($ImageQuery);
                        $stmt->execute();                     
                        $stmt->bind_result($Image);                    
                        $stmt->fetch();                       
                        $stmt->close();


                        $stmt = $conn->prepare($NameQuery);
                        $stmt->execute();                     
                        $stmt->bind_result($userName);                    
                        $stmt->fetch();                       
                        $stmt->close();
                       
                        // Path to the default image
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);

                        $imageSrc = "assets/images/default.jpg";

                        // Check if $Image is set and not empty
                        if (!empty($Image)) {
                            // Check if the image exists
                            if (file_exists("assets/images/" . $Image)) {
                                $imageSrc = "assets/images/" . $Image;
                            } else {
                                echo "Image file does not exist: " . $Image;
                            }
                        } 
                    
                    ?>
                    


                    <img src="<?php echo $imageSrc; ?>" alt="Profile Picture" class="w-20 h-20 rounded-lg border-2 border-white mr-4">
                    <h2 class="text-white text-xl font-bold"><?php echo htmlentities($userName); ?></h2>
                    <button onclick="openEditModal()" class="text-white ml-1 mb-5 "><i class="uil uil-edit"></i></button>
                </div>
                <div id="editModal" class="editprofilemodal fixed top-0 left-0 w-full h-full  bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
                <?php
                    
                    
                        
                    if (isset($_POST["UpdateSub"])) {
                        $userId = $_SESSION["UserId"];
                    
                        $newUsername = htmlspecialchars(trim($_POST["username"]));
                        $newProfileImage = $_FILES["profileImage"]["name"];
                        $tmpName = $_FILES["profileImage"]["tmp_name"];
                        $uploadDir = "assets/images/";
                        $uploadFile = $uploadDir . basename($newProfileImage);
                    
                        $usernameUpdated = false;
                        $profileImageUpdated = false;
                    
                       
                        if (!empty($newUsername)) {
                            $updateUsernameQuery = "UPDATE user SET uname = ? WHERE u_id = ?";
                            $stmt = $conn->prepare($updateUsernameQuery);
                            $stmt->bind_param("si", $newUsername, $userId);
                            if ($stmt->execute()) {
                                if ($stmt->affected_rows > 0) {
                                    $usernameUpdated = true;
                                }
                            }
                            $stmt->close();
                        }
                    
                       
                        if (!empty($newProfileImage)) {
                            $updateImageQuery = "UPDATE user SET profileImage = ? WHERE u_id = ?";
                            $stmt = $conn->prepare($updateImageQuery);
                            $stmt->bind_param("si", $newProfileImage, $userId);
                            if ($stmt->execute()) {
                                if (move_uploaded_file($tmpName, $uploadFile)) {
                                    $profileImageUpdated = true;
                                } else {
                                    $errorMessage = "There was an error uploading your file.";
                                }
                            } else {
                                $errorMessage = "Error updating profile image.";
                            }
                            $stmt->close();
                        }
                    
                        if ($usernameUpdated && $profileImageUpdated) {
                            $_SESSION["SuccessMessage"] = "Both username and profile image are updated successfully";
                        } elseif ($usernameUpdated) {
                            $_SESSION["SuccessMessage"] = "Username is updated";
                        } elseif ($profileImageUpdated) {
                            $_SESSION["SuccessMessage"] = "Profile image is updated";
                        } elseif (isset($errorMessage)) {
                            $_SESSION["ErrorMessage"] = $errorMessage;
                        }
                    
                        header("Location: userPage.php");
                        exit();
                    }
                    

                    
                ?>

                    <div class="bg-white p-8 rounded-lg w-1/3">
                        
                        <form action="userPage.php" enctype="multipart/form-data" method="POST">
                            <label for="profileImage" class="block mb-2">Profile Image</label>
                            <input type="file" name="profileImage" id="profileImage" class="border rounded-lg p-2 mb-4">

                            <label for="username" class="block mb-2">Username</label>
                            <input type="text" name="username" id="username" value="<?php echo htmlentities($userName); ?>" class="border rounded-lg p-2 mb-4">

                            <div class="flex justify-between">
                                <button name="UpdateSub" type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save</button>
                                
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    // Function to open the edit modal
                    function openEditModal() {
                        document.getElementById('editModal').classList.remove('hidden');
                    }

                    // Function to close the edit modal
                    function closeEditModal() {
                        document.getElementById('editModal').classList.add('hidden');
                    }
                    window.addEventListener('click', function(event) {
                        var editModal = document.getElementById('editModal');
                        if (event.target === editModal) {
                            editModal.classList.add('hidden');
                        }
                    });
                    
                </script>
                <div class="col-span-1 grid grid-cols-2">
                    <div class="col-span-1"></div>
                    <div class="flex items-center justify-between bg-white px-4 col-span-1 shadow-md rounded-lg">
                        <div class="flex items-center"> <!-- Left side container -->
                            <div class="flex flex-col">
                                <h2 class="text-lg font-semibold">Expenses</h2>
                                
                            </div>
                        </div>

                        <!-- Right side container for second icon -->
                        <div class="flex justify-center items-center">
                        <button id="openExModalBtn" class="font-bold"><i class="uil uil-plus-circle text-2xl"></i></button>
                        </div>
                        
                    </div>
                </div>
                
                <div class="flex items-center justify-between bg-white px-4 col-span-1 shadow-md rounded-lg">
                    <div class="flex items-center"> <!-- Left side container -->
                        <i class="uil uil-coins text-3xl mr-3"></i>
                        <div class="flex flex-col">
                            <h2 class="text-lg font-semibold">Balance</h2>
                            <?php
                                $UserID = $_SESSION["UserId"];
                                $query = "SELECT amount FROM wallet WHERE u_id = $UserID";
                                $stmt = $conn->prepare($query);
                                $stmt->execute();
                                $stmt->bind_result($Amount);
                                $stmt->fetch();
                                $stmt->close();
                                ?>
               
                                 <p class="text-2xl font-bold text-purple-500">₹<?php echo htmlentities($Amount); ?></p>
                        </div>
                    </div>
                    <!-- Right side container for second icon -->
                    <div class="flex justify-center items-center">
                        <button id="openModalBtn" class=" font-bold "><i class="uil uil-edit text-2xl"></i></button>
                    </div>
                </div>
                    
            </div>
        </div>

        
        <div class="grid grid-cols-5 gap-4">

    
        <div class="col-span-1 mb-8" >
            
            
            
            
                <div id="AmountModal" class="modal fixed hidden inset-0 bg-black flex bg-opacity-50 items-center justify-center">
                   
                    

                    <div class="modal-content bg-white w-1/2 p-8 rounded-lg">
                        
                        <span class="close absolute top-0 right-0 mt-4 mr-4 text-2xl cursor-pointer">&times;</span>
                        <form action="userPage.php" method="POST">

                            <div class="mb-4">
                                <label for="amount" class="block text-gray-700 font-bold mb-2">Amount:</label>
                                <input type="number" id="amount" name="amount" placeholder="Enter the amount" required class="block w-full rounded-md border-0 px-3.5 text-gray-800 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>

                            <input type="submit" name="Submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        </form>
                    </div>
                
                    
                    <!-- <script>
                        var amountModal = document.getElementById("AmountModal");
                        var btn = document.getElementById("openModalBtn");
                        var amountSpan = document.getElementsByClassName("close");

                        // When the user clicks the button, open the modal
                        btn.onclick = function() {
                            amountModal.classList.remove("hidden");
                        }

                        // When the user clicks on <span> (x), close the modal
                        for (var i = 0; i < amountSpan.length; i++) {
                            amountSpan[i].onclick = function() {
                                amountModal.classList.add("hidden");
                            }
                        }

                        // When the user clicks anywhere outside of the modal, close it
                        window.onclick = function(event) {
                            if (event.target == amountModal) {
                                amountModal.classList.add("hidden");
                            }
                            // Add handling for the second modal
                            var modalcat = document.getElementById("categoryModal");
                            if (event.target == modalcat) {
                                modalcat.classList.add("hidden");
                            }
                        }
                    </script> -->
            </div>
            <div class="bg-white p-4 shadow-md mt-4 rounded-lg">
                
                <canvas id="expenses-chart" width="400" height="200"></canvas>
            
                <?php
                        $UserID = $_SESSION["UserId"];

                        $daily_query = "SELECT COALESCE(CAST(SUM(ex_amount) AS UNSIGNED), 0) AS total_daily_expenses FROM expenses WHERE user_id = $UserID AND datetime = DATE_FORMAT(CURDATE(), '%d-%m-%Y');";
          
                        $stmt = $conn->prepare($daily_query);
                        $stmt->execute();                     
                        $stmt->bind_result($DailyAmount);                    
                        $stmt->fetch();                       
                        $stmt->close();

                        $weekly_query = "SELECT COALESCE(CAST(SUM(ex_amount) AS UNSIGNED),0) AS total_weekly_expenses FROM expenses WHERE user_id = $UserID AND STR_TO_DATE(datetime, '%d-%m-%Y') BETWEEN CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY AND CURDATE() + INTERVAL 7 - DAYOFWEEK(CURDATE()) DAY";
                        $stmt2 = $conn->prepare($weekly_query);
                        $stmt2->execute();                     
                        $stmt2->bind_result($WeeklyAmount);                    
                        $stmt2->fetch();                       
                        $stmt2->close();

                        $monthly_query = "SELECT COALESCE(CAST(SUM(ex_amount) AS UNSIGNED),0) AS total_monthly_expenses FROM expenses WHERE user_id = $UserID AND MONTH(STR_TO_DATE(datetime, '%d-%m-%Y')) = MONTH(NOW()) AND YEAR(STR_TO_DATE(datetime, '%d-%m-%Y')) = YEAR(NOW())";
                        $stmt3 = $conn->prepare($monthly_query);
                        $stmt3->execute();                     
                        $stmt3->bind_result($MonthlyAmount);                    
                        $stmt3->fetch();                       
                        $stmt3->close();
       
                    ?> 
            <script>
                    // Sample data (replace with your actual data)
                    const dailyExpense = <?php echo htmlentities($DailyAmount) ?>;
                    const weeklyExpense = <?php echo htmlentities($WeeklyAmount) ?>;
                    const monthlyExpense = <?php echo htmlentities($MonthlyAmount) ?>;

                    // Create chart
                    new Chart(document.getElementById('expenses-chart').getContext('2d'), {
                        type: 'bar',
                        
                        data: {

                            
                            labels: ['Daily', 'Weekly', 'Monthly'],
                            
                            datasets: [{
                                label: 'Expenses',
                                data: [dailyExpense, weeklyExpense, monthlyExpense],
                                backgroundColor: [
                                    'rgb(2 132 199)',
                                    'rgb(124 58 237)',
                                    'rgb(217 70 239)'
                                ],
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            maintainAspectRatio: false,
                            legend: { display: false },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                </script>

        </div>
            
            <div class="bg-white p-4 shadow-md  mt-2 rounded-lg">

                
                <h2 class="text-xl font-semibold  mb-4">Daily Expense</h2>
                
                <p class="text-2xl font-bold  text-purple-500">₹<?php echo htmlentities($DailyAmount); ?>

                </p>
            </div>
            
            <div class="bg-white p-4 shadow-md mt-2 rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Weekly Expense</h2>
               

                
                <p class="text-2xl font-bold text-purple-500">₹<?php echo htmlentities($WeeklyAmount);?></p>
            </div>
            <div class="bg-white p-4 shadow-md mt-2 rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Monthly Expense</h2>
                <p class="text-2xl font-bold text-purple-500">₹<?php echo htmlentities($MonthlyAmount);?></p>
        
            </div>
            
            
        </div>

        <!-- Expense History -->
        <div class="col-span-3"> 
            
            <script>
                
                    document.addEventListener("DOMContentLoaded", function() {
                    var expenseModal = document.getElementById("expenseModal");
                    var exBtn = document.getElementById("openExModalBtn");
                    var amountSpan = document.getElementsByClassName("close")[0]; // Changed index to 0 for expense modal

                    var modalcat = document.getElementById("categoryModal");
                    var btncat = document.getElementById("openCateModalBtn");
                    var spancat = document.getElementsByClassName("close")[1]; // Changed index to 1 for category modal

                    var amountModal = document.getElementById("AmountModal");
                    var btn = document.getElementById("openModalBtn");
                    var amountSpan2 = document.getElementsByClassName("close")[2]; // Changed index to 2 for amount modal

                    // Function to open expense modal
                    exBtn.onclick = function() {
                        expenseModal.classList.remove("hidden");
                    }

                    // Function to close expense modal
                    amountSpan.onclick = function() {
                        expenseModal.classList.add("hidden");
                    }

                    // Function to open category modal
                    btncat.onclick = function() {
                        modalcat.classList.remove("hidden");
                    }

                    // Function to close category modal
                    spancat.onclick = function() {
                        modalcat.classList.add("hidden");
                    }

                    // Function to open amount modal
                    btn.onclick = function() {
                        amountModal.classList.remove("hidden");
                    }

                    // Function to close amount modal
                    amountSpan2.onclick = function() {
                        amountModal.classList.add("hidden");
                    }

                    // Close modals when clicking outside
                    window.onclick = function(event) {
                        if (event.target == expenseModal || event.target == modalcat || event.target == amountModal) {
                            expenseModal.classList.add("hidden");
                            modalcat.classList.add("hidden");
                            amountModal.classList.add("hidden");
                        }
                    }
                });
            </script>

            

            
            
            <div id="expenseModal" class="modal fixed hidden inset-0 bg-black flex bg-opacity-50 items-center justify-center">
                   
                    <div class="modal-content bg-white w-1/2 p-8 rounded-lg">
                        <span class="close absolute top-0 right-0 mt-4 mr-4 text-2xl cursor-pointer">&times;</span>

                        <!-- Expenses Adding section -->
                        <form action="Expense.php" method="POST">
                            <div class="mb-4">
                                <label for="amount" class="block text-gray-700 font-bold mb-2">Amount:</label>
                                <input type="number" id="amount" name="exAmount" placeholder="Enter the amount" required class="block w-full rounded-md border-0 px-3.5 text-gray-800 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div class="mb-4">
                                <label for="date" class="block text-gray-700 font-bold mb-2">Date:</label>
                                <input type="date" id="date" name="date"  class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="category" class="block text-gray-700 font-bold mb-2">Category:</label>
                                <select id="category" name="category" required class="block w-full rounded-md border-0 px-3.5 text-gray-800 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="" disabled selected>Select a category</option>
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

                            </div>

                            <div class="mb-4">
                                <label for="comment" class="block text-gray-700 font-bold mb-2">Comment:</label>
                                <textarea id="comment" name="comment" placeholder="Enter a comment" class="block w-full rounded-md border-0 px-3.5 text-gray-800 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                            </div>

                            <input type="submit" name="Submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        </form>
                    </div>
                </div>  
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Category</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Balance</th>
                            <th class="px-4 py-2">Comment</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                $UserID = $_SESSION["UserId"];
                                $sql = "SELECT * FROM expenses WHERE user_id=$UserID ORDER BY e_id desc LIMIT 4;";
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
                        <tr>
                            <td class="border-b border-dashed px-4 py-2"><div class="flex font-sm"><?php echo htmlentities($DateTime)?></div></td>
                            <td class="border-b border-dashed px-4 py-2"><div class="text-purple-600 font-semibold flex"><?php echo htmlentities($CategoryName)?></div></td>
                            <td class="border-b border-dashed px-4 py-2"><div class="justify-center font-semibold flex">₹<?php echo htmlentities($ExAmount)?></div></td>
                            
                            <td class="border-b border-dashed px-4 py-2"><div class="justify-center font-semibold flex">₹<?php echo htmlentities($balance)?></div></td>
                            <td class="border-b border-dashed bg-gray-50 px-4 py-2"><div class="text-gray-600  flex"><?php echo htmlentities($ExComment)?></div></td>
                            <td class="border-b border-dashed px-4 py-2">
                            <button type="button" data-modal-target="deleteModal" data-modal-toggle="deleteModal" class="delete-button" data-id="<?php echo $Id ?>">
                                <i class="uil text-2xl justify-center flex font-medium text-red-600 hover:text-red-400 uil-times"></i>
                            </button>
                            </td>
                        </tr>

                    <?php } ?>
                        <!-- Add more rows dynamically with real data -->
                    </tbody>
                </table>
            
            <div class="bg-purple-50 mt-4 rounded-lg">
                <div class="flex justify-center gap-4 py-4 ">
                    <input type="radio" id="defaultRadio" name="chartType" checked>
                    <label for="defaultRadio">Default</label>
                    <input type="radio" id="weeklyRadio" name="chartType">
                    <label for="weeklyRadio">Weekly</label>
                    <input type="radio" id="monthlyRadio" name="chartType">
                    <label for="monthlyRadio">Monthly</label>
                </div>
                <script>
                    document.getElementById('defaultRadio').addEventListener('change', function() {
                        document.getElementById('myChart').parentElement.classList.remove('hidden');
                        document.getElementById('weeklyChart').parentElement.classList.add('hidden');
                        document.getElementById('monthlyChart').parentElement.classList.add('hidden');
                    });

                    document.getElementById('weeklyRadio').addEventListener('change', function() {
                        document.getElementById('myChart').parentElement.classList.add('hidden');
                        document.getElementById('weeklyChart').parentElement.classList.remove('hidden');
                        document.getElementById('monthlyChart').parentElement.classList.add('hidden');
                    });

                    document.getElementById('monthlyRadio').addEventListener('change', function() {
                        document.getElementById('myChart').parentElement.classList.add('hidden');
                        document.getElementById('weeklyChart').parentElement.classList.add('hidden');
                        document.getElementById('monthlyChart').parentElement.classList.remove('hidden');
                    });
                </script>
            
                <div class="flex justify-center " style=" height: 25rem;">
                <canvas id="myChart" width="100" height="100"></canvas>               
                </div>
                <div class="flex justify-center hidden" style=" height: 25rem;">
                <canvas id="weeklyChart" width="100" height="100"></canvas>                
                </div>
                <div class="flex justify-center hidden" style=" height: 25rem;">
                <canvas id="monthlyChart" width="100" height="100"></canvas>
                </div>

                <script>
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var dataValues = [<?php
                                    $UserID = $_SESSION["UserId"];
                                    $sql = "SELECT DISTINCT cat_name FROM expenses WHERE user_id=$UserID ORDER BY e_id desc;";
                                    $stmt1 = $ConnectingDB->query($sql);
                                    $firstCategory = true;
                                    $sr=0;

                                    while ($DataRows2 = $stmt1->fetch()) {
                                        if (!$firstCategory) echo ",";
                                        // Add a comma between category spends
                                        $CategoryName = htmlentities($DataRows2["cat_name"]);

                                        // Query for the total spend of the current category
                                        $sql = "SELECT COALESCE(CAST(SUM(ex_amount) AS UNSIGNED),0) AS total_amount FROM expenses WHERE user_id=$UserID AND cat_name='$CategoryName'";
                                        $stmt = $ConnectingDB->query($sql);
                                        $DataRows = $stmt->fetch();
                                        $Total = $DataRows["total_amount"];

                                        // Output total spend for current category
                                        echo "'$Total'";
                                        

                                        $firstCategory = false;
                                        $sr++;
                                    }
                                    $count = $sr;                     
                                ?>];

                    var myChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: [<?php
                                $UserID = $_SESSION["UserId"];
                                $sql = "SELECT DISTINCT cat_name FROM expenses WHERE user_id=$UserID ORDER BY e_id desc;";
                                $stmt = $ConnectingDB->query($sql);
                                $first = true;
                                while ($DataRows = $stmt->fetch()) {
                                    if (!$first) echo ",";
                                    $CategoryName = htmlentities($DataRows["cat_name"]);
                                    echo "'$CategoryName'";
                                    $first = false;
                                }
                            ?>],
                            datasets: [{
                                label: 'Spend',
                                data: dataValues,

                                backgroundColor: [
                                'rgb(239 68 68)',    // Red
                                'rgb(249 115 22)',   // Orange
                                'rgb(252 211 77)',   // Yellow
                                'rgb(34 197 94)',  // Green
                                'rgb(20 184 166)',  // Cyan
                                'rgb(99 102 241)',  // Blue
                                'rgb(168 85 247)',  // Purple
                                'rgb(236 72 153)',  // Magenta
                                'rgb(244 63 94)',  // Pink
                            ],

                                borderColor: [
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff'
                                ],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            },
                            plugins: {
                                datalabels: {
                                    color: '#fff' // Change this to the desired font color
                                }
                            }
                        }
                    });
                </script>
                <script>
                    var ctx = document.getElementById('weeklyChart').getContext('2d');
                    var dataValues = [<?php
                                    $UserID = $_SESSION["UserId"];
                                    $sql = "SELECT DISTINCT cat_name FROM expenses WHERE user_id=$UserID AND STR_TO_DATE(datetime, '%d-%m-%Y') BETWEEN CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY AND CURDATE() + INTERVAL 7 - DAYOFWEEK(CURDATE()) DAY ORDER BY e_id desc;";
                                    $stmt1 = $ConnectingDB->query($sql);
                                    $firstCategory = true;
                                    $sr=0;

                                    while ($DataRows2 = $stmt1->fetch()) {
                                        if (!$firstCategory) echo ",";
                                        // Add a comma between category spends
                                        $CategoryName = htmlentities($DataRows2["cat_name"]);

                                        // Query for the total spend of the current category
                                        $sql = "SELECT COALESCE(CAST(SUM(ex_amount) AS UNSIGNED),0) AS total_amount FROM expenses WHERE user_id=$UserID AND cat_name='$CategoryName' AND STR_TO_DATE(datetime, '%d-%m-%Y') BETWEEN CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY AND CURDATE() + INTERVAL 7 - DAYOFWEEK(CURDATE()) DAY";
                                        $stmt = $ConnectingDB->query($sql);
                                        $DataRows = $stmt->fetch();
                                        $Total = $DataRows["total_amount"];

                                        // Output total spend for current category
                                        echo "'$Total'";
                                        

                                        $firstCategory = false;
                                        $sr++;
                                    }
                                    $count = $sr;


                                    
                                ?>];
                    
                   
                    var myChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: [<?php
                                $UserID = $_SESSION["UserId"];
                                $sql = "SELECT DISTINCT cat_name FROM expenses WHERE user_id=$UserID  AND STR_TO_DATE(datetime, '%d-%m-%Y') BETWEEN CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY AND CURDATE() + INTERVAL 7 - DAYOFWEEK(CURDATE()) DAY ORDER BY e_id desc;";
                                $stmt = $ConnectingDB->query($sql);
                                $first = true;
                                while ($DataRows = $stmt->fetch()) {
                                    if (!$first) echo ",";
                                    $CategoryName = htmlentities($DataRows["cat_name"]);
                                    echo "'$CategoryName'";
                                    $first = false;
                                }
                            ?>],
                            datasets: [{
                                label: 'Spend',
                                data: dataValues,

                                backgroundColor: [
                                'rgb(239 68 68)',    // Red
                                'rgb(249 115 22)',   // Orange
                                'rgb(252 211 77)',   // Yellow
                                'rgb(34 197 94)',  // Green
                                'rgb(20 184 166)',  // Cyan
                                'rgb(99 102 241)',  // Blue
                                'rgb(168 85 247)',  // Purple
                                'rgb(236 72 153)',  // Magenta
                                'rgb(244 63 94)',  // Pink
                            ],

                                borderColor: [
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff'
                                ],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            },
                            plugins: {
                                datalabels: {
                                    color: '#fff' // Change this to the desired font color
                                }
                            }
                        }
                    });
                </script>
                <script>
                    var ctx = document.getElementById('monthlyChart').getContext('2d');
                    var dataValues = [<?php
                                    $UserID = $_SESSION["UserId"];
                                    $sql = "SELECT DISTINCT cat_name FROM expenses WHERE user_id=$UserID AND MONTH(STR_TO_DATE(datetime, '%d-%m-%Y')) = MONTH(NOW()) AND YEAR(STR_TO_DATE(datetime, '%d-%m-%Y')) = YEAR(NOW()) ORDER BY e_id desc;";
                                    $stmt1 = $ConnectingDB->query($sql);
                                    $firstCategory = true;
                                    $sr=0;

                                    while ($DataRows2 = $stmt1->fetch()) {
                                        if (!$firstCategory) echo ",";
                                        // Add a comma between category spends
                                        $CategoryName = htmlentities($DataRows2["cat_name"]);

                                        // Query for the total spend of the current category
                                        $sql = "SELECT COALESCE(CAST(SUM(ex_amount) AS UNSIGNED),0) AS total_amount FROM expenses WHERE user_id=$UserID AND cat_name='$CategoryName' AND MONTH(STR_TO_DATE(datetime, '%d-%m-%Y')) = MONTH(NOW()) AND YEAR(STR_TO_DATE(datetime, '%d-%m-%Y')) = YEAR(NOW())";
                                        $stmt = $ConnectingDB->query($sql);
                                        $DataRows = $stmt->fetch();
                                        $Total = $DataRows["total_amount"];

                                        // Output total spend for current category
                                        echo "'$Total'";
                                        

                                        $firstCategory = false;
                                        $sr++;
                                    }
                                    $count = $sr;


                                    
                                ?>];
                    
                   
                    var myChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: [<?php
                                $UserID = $_SESSION["UserId"];
                                $sql = "SELECT DISTINCT cat_name FROM expenses WHERE user_id=$UserID AND MONTH(STR_TO_DATE(datetime, '%d-%m-%Y')) = MONTH(NOW()) AND YEAR(STR_TO_DATE(datetime, '%d-%m-%Y')) = YEAR(NOW()) ORDER BY e_id desc;";
                                $stmt = $ConnectingDB->query($sql);
                                $first = true;
                                while ($DataRows = $stmt->fetch()) {
                                    if (!$first) echo ",";
                                    $CategoryName = htmlentities($DataRows["cat_name"]);
                                    echo "'$CategoryName'";
                                    $first = false;
                                }
                            ?>],
                            datasets: [{
                                label: 'Spend',
                                data: dataValues,

                                backgroundColor: [
                                'rgb(239 68 68)',    // Red
                                'rgb(249 115 22)',   // Orange
                                'rgb(252 211 77)',   // Yellow
                                'rgb(34 197 94)',  // Green
                                'rgb(20 184 166)',  // Cyan
                                'rgb(99 102 241)',  // Blue
                                'rgb(168 85 247)',  // Purple
                                'rgb(236 72 153)',  // Magenta
                                'rgb(244 63 94)',  // Pink
                            ],

                                borderColor: [
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff',
                                    '#ffffff'
                                ],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            },
                            plugins: {
                                datalabels: {
                                    color: '#fff' // Change this to the desired font color
                                }
                            }
                        }
                    });
                </script>
                                        
                                        
            </div>
    </div>
            
    <div class="col-span-1  rounded-lg   text-white mb-8 " >
            
            <div class="bg-purple-600 flex rounded-lg p-4 shadow-md">
            <h2 class="text-xl flex-1 font-semibold my-2">Add Category </h2>
            <button id="openCateModalBtn" class=" text-white font-bold "><i class="uil uil-plus-circle text-2xl"></i></button>
            
            


                <div id="categoryModal" class="modal fixed hidden inset-0 bg-black flex bg-opacity-50 items-center justify-center">
                   
                    <div class="modal-content bg-white w-1/2 p-8 rounded-lg">
                        <span class="close absolute top-0 right-0 mt-4 mr-4 text-2xl cursor-pointer">&times;</span>
                        <form action="userPage.php" method="POST">

                            <div class="mb-4">
                                <label for="Category" class="block text-gray-700 font-bold mb-2">Category:</label>
                                <input type="text" name="CategoryName" id="Category" placeholder="Add Category" class="block w-full rounded-md border-0 px-3.5 text-gray-800 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      
                            </div>

                            <input type="submit" name="SubmitCat" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        </form>
                    </div>
                </div>
                    <!-- <script>
                        var modalcat = document.getElementById("categoryModal");
                        var btncat = document.getElementById("openCateModalBtn");
                        var spancat = document.getElementsByClassName("close")[1]; // Changed index to 1

                        // When the user clicks the button, open the modal
                        btncat.onclick = function() {
                            modalcat.classList.remove("hidden");
                        }

                        // When the user clicks on <span> (x), close the modal
                        spancat.onclick = function() {
                            modalcat.classList.add("hidden");
                        }
                    </script> -->

                
            </div>
            <div class="rounded-lg p-4 shadow-md mt-2 bg-gray-100">
                <h2 class="text-xl text-purple-600 font-semibold mb-2">Categories</h2>
                
                <ul class="divide-y divide-gray-300">
                    <?php
                    $UserID = $_SESSION["UserId"];
                    $sql = "SELECT * FROM categories where u_id = $UserID ORDER BY c_id desc";
                    $stmt = $ConnectingDB->query($sql);
                    $Sr=0;
                    
                    while($DataRows = $stmt->fetch()){
                        $Id = $DataRows["c_id"];
                        $CategoryName = $DataRows["name"]; 
                        $Sr++;
                        ?>
                    <li class="bg-purple-600 rounded-lg p-3 shadow-md flex mt-2 items-center">
                        <span class="flex-1 pl-1 font-medium text-white"><?php echo htmlentities($CategoryName); ?></span>
                        <a href="DeleteCategory.php?id=<?php echo $Id?>"></a>
                        <button type="button" data-modal-target="deleteModalCat" data-modal-toggle="deleteModalCat" class="delete-button-cat" data-id="<?php echo $Id ?>">
                            <i class="uil text-xl uil-times-circle"></i></i>
                        </button>
                        
                    </li>
                    
                    <?php } ?>
                </ul>
        </div>
    </div>
  </div>
  <div id="deleteModal" tabindex="-1" class="hidden overflow-y-auto fixed top-0 left-0 right-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow ">
                <div class="flex justify-end p-2">
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="deleteModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>  
                    </button>
                </div>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 w-14 h-14 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-6000">Are you sure you want to delete this expense?</h3>
                    <a id="confirmDelete" href="" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Yes, I'm sure
                    </a>
                    <button data-modal-hide="deleteModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        No, cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = event.currentTarget.getAttribute('data-id');
                    const confirmDelete = document.getElementById('confirmDelete');
                    confirmDelete.href = `removeExpense.php?id=${id}`;
                });
            });
        });
    </script>
     <div id="deleteModalCat" tabindex="-1" class="hidden overflow-y-auto fixed top-0 left-0 right-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow ">
                <div class="flex justify-end p-2">
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="deleteModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>  
                    </button>
                </div>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 w-14 h-14 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-6000">Are you sure you want to delete this Category?</h3>
                    <a id="confirmDeleteCat" href="" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Yes, I'm sure
                    </a>
                    <button data-modal-hide="deleteModalCat" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        No, cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.delete-button-cat').forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = event.currentTarget.getAttribute('data-id');
                    const confirmDelete = document.getElementById('confirmDeleteCat');
                    confirmDelete.href = `DeleteCategory.php?id=${id}`;
                });
            });
        });
    </script>
  </div>
  <?php include 'includes/footer.php'; ?> 
        </body>
</html>
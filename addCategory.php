<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];

Confirm_Login();
?>
<?php 
    if(isset($_POST["Submit"])){

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
 
</head>
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
   
  <div class="container mx-auto my-16 p-8">
   <div class="sm:col-span-2 mb-2"><?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?></div> 
        <!-- Header -->
        <h1 class="text-3xl font-semibold mb-8">Expense Tracking Dashboard</h1>

        <!-- Filters
        <div class="flex flex-wrap mb-4 space-x-4">
            <div>
                <label for="start-date" class="block text-gray-600">Start Date:</label>
                <input type="date" id="start-date" class="form-input mt-1" />
            </div>
            <div>
                <label for="end-date" class="block text-gray-600">End Date:</label>
                <input type="date" id="end-date" class="form-input mt-1" />
            </div>
            <div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md">Apply</button>
            </div>
        </div> -->

        <!-- Expense Overview -->
        <div class="grid grid-cols-2 gap-4 mb-8">
            <!-- Daily Expense -->
            <div class="bg-white p-4 shadow-md rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Daily Expense</h2>
                <p class="text-2xl font-bold text-blue-500">₹250</p>
            </div>
            <!-- Weekly Expense -->
            <div class="bg-white p-4 shadow-md rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Weekly Expense</h2>
                <p class="text-2xl font-bold text-blue-500">₹1500</p>
            </div>
            <!-- Monthly Expense -->
            <div class="bg-white p-4 shadow-md rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Monthly Expense</h2>
                <p class="text-2xl font-bold text-blue-500">₹1500</p>
            </div>
            <div class="bg-white p-4 shadow-md rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Balance</h2>
                <p class="text-2xl font-bold text-blue-500">₹10</p>
            </div>
        </div>

        <!-- Expense History -->
        <div>
            <h2 class="text-2xl font-semibold mb-4">Expense History</h2>
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Category</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border px-4 py-2">2024-03-19</td>
                        <td class="border px-4 py-2">Food</td>
                        <td class="border px-4 py-2">₹50</td>
                        <td class="border px-4 py-2">Lunch with friends</td>
                    </tr>
                    <!-- Add more rows dynamically with real data -->
                </tbody>
            </table>
    </div>
  </div>
  <?php include 'includes/footer.php'; ?> 
        </body>
</html>
<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php $conn = new mysqli('localhost', 'root', '', 'expensia'); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login();
?>
<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
</head>
<body>
    <nav id="navbar" class="bg-purple-600 fixed top-0 left-0 w-full flex items-center justify-between px-16 py-4">
        <div>
          <a href="landing.php" class="text-l font-bold text-white"> <h1> EXPENSIA </h1> </a>
        </div>
        <div class="md:block">
          <ul class="flex space-x-4">
            <li><a href="userPage.php" class="text-white text-sm font-semibold px-2 hover:text-purple-300">Home</a></li>
            <li><a href="ExpensesHistory.php" class="text-white text-sm font-semibold px-2 hover:text-purple-300">Expenses</a></li>
            <li><a href="landing.php#query" class="text-white text-sm font-semibold px-2 hover:text-purple-300">Contact</a></li>
          </ul>
        </div>
        <div>
          <a href="logout.php" class="text-white text-sm font-semibold hover:text-purple-300 mr-4">Log out<i class="uil uil-arrow-right py-2"></i></a>
        </div>
    </nav>
   
    <div class="container mx-auto my-20 px-8">
        <div class="col-span-4 rounded-lg">
            <div class="p-4 rounded-lg">
                <form action="expensefilter.php" method="post" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                    <!-- Category Select -->
                    <div class="w-full md:w-1/3">
                        <label for="category" class="block text-gray-700 font-bold mb-2">Category:</label>
                        <select id="category" name="category" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500">
                            <?php
                                $UserID = $_SESSION["UserId"];
                                $sql = "SELECT * FROM categories where u_id = $UserID ORDER BY c_id desc";
                                $stmt = $ConnectingDB->query($sql);
                                while($DataRows = $stmt->fetch()){
                                    $Id = $DataRows["c_id"];
                                    $CategoryName = $DataRows["name"]; 
                                    echo "<option value='".htmlentities($CategoryName)."'>".htmlentities($CategoryName)."</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <!-- Date Select -->
                    <div class="w-full md:w-1/3">
                        <label for="startdate" class="block text-gray-700 font-bold mb-2">Start Date:</label>
                        <input type="date" id="startdate" name="startdate" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="w-full md:w-1/3">
                        <label for="enddate" class="block text-gray-700 font-bold mb-2">End Date:</label>
                        <input type="date" id="enddate" name="enddate" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500">
                    </div>

                    <!-- Submit Button -->
                    <div class="w-full md:w-auto">
                        <button type="submit" name="FSubmit" class="w-full mt-7 md:w-auto bg-purple-600 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline">
                            Filter
                        </button>
                    </div>
                </form>
            </div>
      
            <canvas id="expensesChart" width="700" height="200"></canvas>

            <script>
                fetch('ExpensesChart.php')
                    .then(response => response.json())
                    .then(data => {
                        const labels = Object.keys(data);
                        const expenses = Object.values(data);
                        const ctx = document.getElementById('expensesChart').getContext('2d');
                        const chart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Monthly Expenses',
                                    data: expenses,
                                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error fetching expenses:', error));
            </script>
      
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Category</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Balance</th>
                        <th class="px-4 py-2">Comment</th>
                        <th class="px-4 py-2"><i class="uil text-xl justify-center flex font-medium uil-edit-alt"></i></th>
                        <th class="px-4 py-2"><i class="uil text-xl justify-center flex font-medium uil-trash-alt"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $UserID = $_SESSION["UserId"];
                        $sql = "SELECT * FROM expenses WHERE user_id=$UserID ORDER BY STR_TO_DATE(datetime, '%d-%m-%Y') desc;";
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
                        <td class="border-b border-dashed bg-gray-50 px-4 py-2"><div class="text-gray-600 flex"><?php echo htmlentities($ExComment)?></div></td>
                        <td class="border-b border-dashed px-4 py-2"><a href="editExpense.php?id=<?php echo $Id?>"><i class="uil text-2xl justify-center flex font-medium text-purple-600 hover:text-purple-400 uil-edit"></i></a></td>
                        <td class="border-b border-dashed px-4 py-2">
                            <button type="button" data-modal-target="deleteModal" data-modal-toggle="deleteModal" class="delete-button" data-id="<?php echo $Id ?>">
                                <i class="uil text-2xl justify-center flex font-medium text-red-600 hover:text-red-400 uil-times"></i>
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <form method="post" action="ExpenseDownload.php">
            <button type="submit" name="download" class="bg-purple-500 hover:bg-purple-700 mt-6 text-white font-bold py-2 px-4 rounded">
                Download User Data
            </button>
        </form>
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

    <?php include 'includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = event.currentTarget.getAttribute('data-id');
                    const confirmDelete = document.getElementById('confirmDelete');
                    confirmDelete.href = `removeExpenseFromHistory.php?id=${id}`;
                });
            });
        });
    </script>
</body>
</html>

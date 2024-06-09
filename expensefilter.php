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

  

  <script src="includes/script.js"></script>
  
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://cdn.tailwindcss.com"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
  <script>
        function downloadCSV() {
            let csvContent = "data:text/csv;charset=utf-8,";
            const rows = document.querySelectorAll("table tr");
            rows.forEach(row => {
                const cols = row.querySelectorAll("td, th");
                let rowData = [];
                cols.forEach(col => rowData.push(col.innerText.replace('₹', '')));
                csvContent += rowData.join(",") + "\r\n";
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "expenses.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
 
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
   
  <div class="container mx-auto my-20 px-8">
  



    <div class=" col-span-4  rounded-lg">
          <div class="p-4 rounded-lg ">
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

                              ?>
                  
                      <option value="<?php echo $CategoryName; ?>"><?php echo htmlentities($CategoryName); ?></option>
                      
                      <?php } ?>
                  </select>
              </div>

              <!-- Date Select -->
              <div class="w-full md:w-1/3">
                  <label for="date" class="block text-gray-700 font-bold mb-2">Start Date:</label>
                  <input type="date" id="date" name="startdate"  class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500">
              </div>
              <div class="w-full md:w-1/3">
                  <label for="date" class="block text-gray-700 font-bold mb-2">End Date:</label>
                  <input type="date" id="date" name="enddate" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500">
              </div>

              <!-- Submit Button -->
              <div class="w-full  md:w-auto">
                  <button type="submit" name="FSubmit" class="w-full mt-7 md:w-auto bg-purple-600  hover:bg-purple-800  text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline">
                      Filter
                  </button>
              </div>
          </form>
          

      </div>
      
      <canvas id="expensesChart" width="700" height="200"></canvas>

        <script>
            // Fetch expenses data from the server
            fetch('ExpensesChart.php')
                .then(response => response.json())
                .then(data => {
                    // Extracting labels (dates) and data (total expenses) from grouped expenses
                    const labels = Object.keys(data);
                    const expenses = Object.values(data);

                    // Drawing chart
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
        <?php                 
                                if(isset($_POST["FSubmit"])){
                                    $UserID = $_SESSION["UserId"];
                                    $Category = $_POST["category"];

                                    $StartDate = date('Y-m-d', strtotime($_POST["startdate"]));
                                    $EndDate = date('Y-m-d', strtotime($_POST["enddate"]));

                                    // $sql = "SELECT * FROM expenses WHERE user_id = $UserID AND cat_name = '$Category' AND datetime BETWEEN '$StartDate' AND '$EndDate' ORDER BY e_id DESC";
                                    $sql = "SELECT * FROM expenses WHERE user_id = $UserID AND cat_name = '$Category' AND STR_TO_DATE(datetime, '%d-%m-%Y') BETWEEN '$StartDate' AND '$EndDate' ORDER BY e_id DESC;";

                                    $stmt = $ConnectingDB->query($sql);?>
        <div class="bg-white shadow-md rounded-lg p-6 mb-6 mt-6">
    <div class="flex items-center justify-between ">
        <div class="flex items-center">
            <div class="bg-purple-500 text-white rounded-full h-12 w-12 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16h8M8 12h8m-8 4h8m-8 4h8M4 8h16"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-xl font-semibold text-gray-800">Expense Filter Overview</h3>
                <p class="text-sm text-gray-500">From <strong><?php echo $StartDate; ?></strong> to <strong><?php echo $EndDate; ?></strong></p>
            </div>
        </div>
        <div class="text-right">
            <p class="font-semibold text-m text-gray-700">Category:</p>
            <p class="text-2xl font-semibold text-purple-600"><strong><?php echo htmlentities($Category); ?></strong></p>
        </div>
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
                            <th class="px-4 py-2"><i class="uil text-xl justify-center flex font-medium uil-trash-alt"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                                
                                    <?php
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
                            <td class="border-b border-dashed px-4 py-2"><a href="removeExpense.php?id=<?php echo $Id?>"><i class="uil text-2xl justify-center flex font-medium text-red-600 hover:text-red-400 uil-times"></i></a></td>
                            
                        </tr>

                    <?php }
                       
                        }
                    ?>
                        <!-- Add more rows dynamically with real data -->
                    </tbody>
                </table>

    </div>

    <button class="bg-purple-500 hover:bg-purple-700 mt-6 text-white font-bold py-2 px-4 rounded" onclick="downloadCSV()">Download Filter Data</button>

  </div>
</div>
  
  <?php include 'includes/footer.php'; ?>  
  
        </body>
</html>
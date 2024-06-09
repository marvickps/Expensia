
<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 
// $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];

// Confirm_Login();
// ?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <script src="includes/script.js"></script>` 
  
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
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
<body class="bg-stone-100">
  
<SCript>
    
</SCript>
 
    <nav id="navbar" class="bg-purple-600 fixed top-0 left-0 w-full flex items-center justify-between px-16 py-4">
            <div>
              <a href="landing.php" class="text-l font-bold text-white"> <h1> EXPENSIA </h1> </a>
            </div>
            <div>
              <a href="landing.php" class="text-l font-semibold  text-white"> <h1> ADMIN DASHBOARD </h1> </a>
            </div>
            <div >
              <a href="adminLogout.php" class="text-white text-sm font-semibold hover:text-purple-300 mr-4">Log out<i class="uil uil-arrow-right py-2"></i></a>
              
            
            </div>
            
          </nav>
          
    <div class="px-10 ">

        <h1 class="text-black text-2xl text-center font-bold mt-20 mb-5">User Section</h1>
        <div><?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?></div>
        
        
        <div class="bg-white m-2 rounded-md shadow-md overflow-hidden">
            <div class="flex justify-between bg-gray-800 items-center px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-white">Disapproved Users</h2>
                
            </div>
            <!-- Sample Query Item -->
            <div class="px-6 py-4 border-b hover:bg-gray-50">
            <div class="mt-2">
                <table class="table-auto w-full">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                      
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delete</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $sql = "SELECT * FROM user WHERE status='OFF' ORDER BY u_id desc";
                    $stmt = $ConnectingDB->query($sql);
                    $Sr=0;
                    while($DataRows = $stmt->fetch()){
                        $Id = $DataRows["u_id"];
                        
                        $UName = $DataRows["uname"];
                        $UserName = $DataRows["username"];
                        $Email = $DataRows["email"];
                        $Sr++;
                    ?>
                    <tr class="bg-white">
                      <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($Sr); ?></td>
                      
                      <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($UName); ?></td>
                      <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($UserName); ?></td>
                      <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($Email); ?></td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <a class="text-green-500 hover:text-green-700" href="ApproveUser.php?id=<?php echo $Id?>">Approve</a>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <a class="text-red-500 hover:text-red-700 delete-link" href="DeleteUser.php?id=<?php echo $Id?>" onclick="confirmDelete(event)">Delete</a>
                    </td>


                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
        </div>
        

        </div>
            
        </div>
        <div class="bg-white m-2 rounded-md shadow-md overflow-hidden">
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Approved Users</h2>
                
            </div>
            <!-- Sample Query Item -->
            <div class="px-6 py-4 border-b hover:bg-gray-50">
            <div class="mt-2">
                <table class="table-auto w-full">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                      
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delete</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $sql = "SELECT * FROM user WHERE status='ON' ORDER BY u_id desc";
                    $stmt = $ConnectingDB->query($sql);
                    $Sr=0;
                    while($DataRows = $stmt->fetch()){
                        $Id = $DataRows["u_id"];
                        
                        $UName = $DataRows["uname"];
                        $UserName = $DataRows["username"];
                        $Email = $DataRows["email"];
                        $Sr++;
                    ?>
                    <tr class="bg-white">
                      <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($Sr); ?></td>
                      
                      <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($UName); ?></td>
                      <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($UserName); ?></td>
                      <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($Email); ?></td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <a class="text-green-500 hover:text-green-700" href="DisapproveUser.php?id=<?php echo $Id?>">Disapprove</a>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                      <a class="text-red-500 hover:text-red-700 delete-link" href="DeleteUser.php?id=<?php echo $Id?>" onclick="confirmDelete(event)">Delete</a>
                    </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
        </div>
        

        </div>
            
        </div>
        <div class="bg-white m-2 rounded-md shadow-md overflow-hidden">
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Queries</h2>
                
            </div>
            <!-- Sample Query Item -->
            <div class="overflow-x-auto px-6 py-4 border-b hover:bg-gray-50">
            <table class="table-auto w-full">
              <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $sql = "SELECT * FROM query ORDER BY q_id DESC";
                    $stmt = $ConnectingDB->query($sql);
                    $Sr = 0;
                    while ($DataRows = $stmt->fetch()) {
                        $Id = $DataRows["q_id"];

                        $Name = $DataRows["query_person"];
                        $email = $DataRows["email"];
                        
                        $message = $DataRows["message"];
                        $Sr++;
                    ?>
                    <tr class="transition-all hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($Sr); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($Name); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($email); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($message); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="DeleteContact.php?id=<?php echo $Id ?>" onclick="confirmDelete(event)" class="text-red-500 hover:text-red-700" >Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            </div>
            <!-- End Sample Query Item -->
        </div>
        </div>
    </div>




    <!-- <section class="adminSection">
    <div class="px-10 ">

<h1 class="text-black text-2xl text-center font-bold mt-20 mb-5">Admin Section</h1>
<div><?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?></div>


<div class="bg-white m-2 rounded-md shadow-md overflow-hidden">
    <div class="flex justify-between items-center px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-800">Admins</h2>
        
    </div>
   
    <div class="px-6 py-4 border-b hover:bg-gray-50">
    <div class="mt-2">
        <table class="table-auto w-full">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
              
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php
            $sql = "SELECT * FROM admin ORDER BY a_id desc";
            $stmt = $ConnectingDB->query($sql);
            $Sr=0;
            while($DataRows = $stmt->fetch()){
                $Id = $DataRows["a_id"];
                
                $AName = $DataRows["aname"];
                $UserName = $DataRows["username"];
                $Sr++;
            ?>
            <tr class="bg-white">
              <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($Sr); ?></td>
              
              <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($AName); ?></td>
              <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($UserName); ?></td>

              <td class="px-6 py-4 whitespace-nowrap">
                <a class="text-red-500 hover:text-red-700" href="DeleteAdmin.php?id=<?php echo $Id?>">Delete</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
</div>

</div> -->
    
<!-- </div>
<div class="bg-white m-2 rounded-md shadow-md overflow-hidden">
    <div class="flex justify-between items-center px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-800">Queries</h2>
        
    </div>
    
    <div class="overflow-x-auto px-6 py-4 border-b hover:bg-gray-50">
    <table class="table-auto w-full">
      <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php
            $sql = "SELECT * FROM query ORDER BY q_id DESC";
            $stmt = $ConnectingDB->query($sql);
            $Sr = 0;
            while ($DataRows = $stmt->fetch()) {
                $Id = $DataRows["q_id"];

                $Name = $DataRows["query_person"];
                $email = $DataRows["email"];
                
                $message = $DataRows["message"];
                $Sr++;
            ?>
            <tr class="transition-all hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($Sr); ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($Name); ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($email); ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlentities($message); ?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="DeleteContact.php?id=<?php echo $Id ?>" class="text-red-500 hover:text-red-700">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
    </div>
    
</div>
</div>
</div>          
    </section> -->
</body>
</html>

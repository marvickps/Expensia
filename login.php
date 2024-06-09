<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/function.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php 
    if(isset($_SESSION["UserId"])){
        Redirect_to("adminDashboard.php");
      }
    if (isset($_POST["Submit"])) {
        $UserName = $_POST["Username"];
        $Password = $_POST["Password"];
        if(empty($UserName)||empty($Password)){
            $_SESSION["ErrorMessage"]="Please enter all the fields";
            Redirect_to("login.php");
        }else{
            $Login_Attempt=Login_Attempt($UserName,$Password);
            if($Login_Attempt){
                $_SESSION["UserId"]=$Login_Attempt["a_id"];
                $_SESSION["UserName"]=$Login_Attempt["username"];
                $_SESSION["AdminName"]=$Login_Attempt["aname"];

                $_SESSION["SuccessMessage"]="Welcome ".$_SESSION["UserName"];
                if (isset($_SESSION["TrackingURL"])) {
                    Redirect_to($_SESSION["TrackingURL"]);
                  }else{
                  Redirect_to("adminDashboard.php");
                }               
            }else{
                $_SESSION["ErrorMessage"]="Account does not exist";
                Redirect_to("login.php");
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
 
</head>
<body>    
    <nav id="navbar" class="bg-purple-600 fixed top-0 left-0 w-full flex items-center justify-between px-16 py-4">
        <div>
          <a href="landing.php" class="text-l font-bold  text-white"> <h1> EXPENSIA </h1> </a>
        </div>
    
        
      </nav> 

    <div>
        
        <div class="flex justify-center items-center h-screen">
            
            <div class="bg-grey rounded-lg p-8 shadow-md w-full max-w-md">
                <h1 class="text-2xl font-semibold mb-4">Admin Login</h1>
                <form action="login.php" method="post">
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-600">Username </label>
                        <input type="text" name="Username" id="username" placeholder="Username" placeholder="Enter your username" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-purple-500">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                        <input type="password" name="Password" id="password" placeholder="Password" placeholder="Enter your password" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-purple-500">
                    </div>
                    
                
                
                <input class="bg-purple-500 mb-4 text-white px-4 py-2 rounded-md w-full hover:bg-purple-700" type="submit" name="Submit" id="submit" placeholder="Password" value="Login">
                <div><?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?></div>    
            </form>
                
            </div>
        </div>
    </div>


</body>
</html>
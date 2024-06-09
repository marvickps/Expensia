<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/function.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php 
    if(isset($_SESSION["UserId"])){
        Redirect_to("userPage.php"); 
      }
    if (isset($_POST["Submit"])) {
        $UserName = $_POST["Username"];
        $Password = $_POST["Password"];
        if(empty($UserName)||empty($Password)){
            $_SESSION["ErrorMessage"]="Please enter all the fields";
            Redirect_to("userLogin.php");
        }else{
            $Login_Attempt=Login_AttemptForUser($UserName,$Password);
            if($Login_Attempt){
                $_SESSION["UserId"]=$Login_Attempt["u_id"];
                $_SESSION["UserName"]=$Login_Attempt["username"];
                $_SESSION["AdminName"]=$Login_Attempt["uname"];

                $_SESSION["SuccessMessage"]="Welcome ".$_SESSION["UserName"];
                if (isset($_SESSION["TrackingURL"])) {
                    Redirect_to($_SESSION["TrackingURL"]);
                  }else{
                  Redirect_to("userPage.php");
                }               
            }else{
                $_SESSION["ErrorMessage"]="Account does not exist";
                Redirect_to("userLogin.php");
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
        <style>
                body {
                    background-image: url("assets/bg.jpg");
                    /* Set background image to cover the entire screen */
                    background-size: cover;
                    /* Center the background image */
                    background-position: center;
                }
        </style>      
  
    <?php include 'includes/nav.php'; ?> 

    <div>
        
        <div class="flex justify-center items-center h-screen " >
            
            <div class="bg-white rounded-lg p-8 shadow-md w-full max-w-md">
                <div class="flex flex-col items-center justify-center" >
                <i class="uil uil-user-circle text-4xl text-purple-600"></i>
                <h1 class="text-2xl font-semibold mb-4">User Login</h1>
                </div>
                  
                <form action="userLogin.php" method="post">
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-600">Username </label>
                        <input type="text" name="Username" id="username" placeholder="Enter Username" placeholder="Enter your username" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-purple-500">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                        <input type="password" name="Password" id="password" placeholder="Enter Password" placeholder="Enter your password" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-purple-500">
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
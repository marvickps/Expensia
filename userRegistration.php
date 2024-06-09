<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 

// $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
// Confirm_Login();?> 
<?php
  if(isset($_POST["Submit"])){
      $UName           = $_POST["UName"];

      $Image = $_FILES["Image"]["name"];
      //location of our image
      $Target = "assets/images/".basename($_FILES["Image"]["name"]);

      $UserName        = $_POST["Username"];
      $Email            = $_POST["Email"];
      $Password        = $_POST["Password"];
      $ConfirmPassword = $_POST["ConfirmPassword"];

      if(empty($UserName)||empty($Password)||empty($ConfirmPassword)){
          $_SESSION["ErrorMessage"]= "All fields must be filled out";
          Redirect_to("userRegistration.php");
        }elseif (strlen($Password)<4) {
          $_SESSION["ErrorMessage"]= "Password should be greater than 3 characters";
          Redirect_to("userRegistration.php");
        }elseif ($Password !== $ConfirmPassword) {
          $_SESSION["ErrorMessage"]= "Password and Confirm Password didn't match!";
          Redirect_to("userRegistration.php");
        }elseif (CheckUserNameExistsOrNotForUser($UserName)) {
          $_SESSION["ErrorMessage"]= "Username Exists. Try Another One! ";
          Redirect_to("userRegistration.php");
        }else{
          // Query to insert new admin in DB When everything is fine
          global $ConnectingDB;
        
          $sql = "INSERT INTO user(uname,username,password,email,status,profileImage) VALUES";
          $sql .= "(:uName,:userName,:Password,:Email,'OFF',:ProfileImage)";
          $stmt = $ConnectingDB->prepare($sql);
          $stmt->bindValue(':uName',$UName);

          $stmt->bindValue(':userName',$UserName);
          $stmt->bindValue(':Password',$Password);
          $stmt->bindValue(':Email',$Email);
          $stmt ->bindValue(':ProfileImage',$Image);
          
          

          $Execute=$stmt->execute();
          move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
          
          if($Execute){
            
            

            $_SESSION["SuccessMessage"]="New User with the name of ".$UName." added Successfully";
            Redirect_to("userLogin.php");
          }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("userRegistration.php");
          }
        }
  }
?>
<!-- && sendmail($_POST['email'],$_POST['token)']) -->
<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  

  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

  

  <script src="includes/script.js"></script>
  
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
      function previewImage() {
          var preview = document.getElementById('image-preview');
          var file    = document.getElementById('profile-picture').files[0];
          var reader  = new FileReader();

          reader.onloadend = function () {
              preview.src = reader.result;
          }

          if (file) {
              reader.readAsDataURL(file);
          } else {
              preview.src = "";
          }
      }
</script>
 
</head>
<body>
  <div class = "MerajAlom">
              <style>
                .MerajAlom{
                
                    background-image: url("assets/bg.jpg");
                    /* Set background image to cover the entire screen */
                    background-size: cover;
                    /* Center the background image */
                    background-position: center;
                  
                }
              </style> 
  
        <!-- Add padding-top to body -->
      <nav id="navbar" class="bg-purple-600 fixed top-0 left-0 w-full flex items-center justify-between px-16 py-4">
        <div>
          <a href="landing.php" class="text-l font-bold  text-white"> <h1> EXPENSIA </h1> </a>
        </div>
        <div class="md:block">
          <ul class="flex space-x-4">
            <li><a href="landing.php#query" class="text-white text-sm font-semibold px-2 hover:text-purple-300">Contact</a></li>
            <li><a href="userPage.php" class="text-white text-sm font-semibold px-2 hover:text-purple-300" >Login</a></li>
          </ul>
        </div>
      </nav>
    
        <div class="flex justify-center items-center min-h-screen m-10 mb-5">
            <div class="bg-purple-600 rounded-lg p-8 shadow-md w-full max-w-lg">
                <h1 class="text-2xl text-white font-semibold">Registration</h1>
                      <form action="userRegistration.php" method="POST" enctype="multipart/form-data"  class="mt-6">
                        <div class="grid grid-cols-1 gap-x-8 sm:grid-cols-2">
                        <div class="sm:col-span-2 mb-4">
                            <label for="uname" class="block text-sm font-semibold leading-6 text-white">Name </label>
                            <div class="mt-2.5">
                              <input type="text" name="UName" id="uname" class="block w-full rounded-md border-0 px-3.5 py-2 text-grey  shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-2 mb-4">
                              <label for="profile-picture" class="block text-sm font-semibold leading-6 text-white">
                                  Profile picture
                                  <div class="relative mt-1 rounded-md shadow-sm">
                                      <input type="file" id="profile-picture" name="Image" class="hidden" accept="image/*" onchange="previewImage();">
                                  </div>
                              </label>
                              <button type="button" class="px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-white bg-purple-600 hover:bg-purple-500 focus:outline-none focus:border-purple-700 focus:ring focus:ring-purple-200 focus:ring-opacity-50" onclick="document.getElementById('profile-picture').click()">
                                  Select a file
                              </button>
                              <span id="file-name" class="ml-2 text-gray-500"></span>
                          </div>
                          <div class="sm:col-span-2">
                              <img id="image-preview" style="max-width: 200px; max-height: 200px;" class="image-preview rounded-md">
                          </div>
                          <div class="mb-4">
                            <label for="username" class="block text-sm font-semibold leading-6 text-white">Enter your username</label>
                            <div class="mt-2.5">
                              <input type="text" name="Username" id="username" autocomplete="user-name" class="block w-full rounded-md border-0 px-3.5 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div class="mb-4">
                          </div>
                          <div>
                          <div class="sm:col-span-2 mb-4">
                            <label for="email" class="block text-sm font-semibold leading-6 text-white">Enter your email </label>
                            <div class="mt-2.5">
                              <input type="email" name="Email" id="email" autocomplete="email" class="block w-full rounded-md border-0 px-3.5 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                          </div>
                          <div class="sm:col-span-2 mb-4">
                            <label for="password" class="block text-sm font-semibold leading-6 text-white">Enter your password</label>
                            <div class="mt-2.5">
                              <input type="password" name="Password" id="password" autocomplete="password" class="block w-full rounded-md border-0 px-3.5 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                          </div>
                          <div class="sm:col-span-2 mb-4">
                            <label for="password" class="block text-sm font-semibold leading-6 text-white">Confirm your password </label>
                            <div class="mt-2.5">
                              <input type="password" name="ConfirmPassword" id="password" autocomplete="password" class="block w-full rounded-md border-0 px-3.5 py-2 text-grey  shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-2  mt-3">
                          <button type="Submit" name="Submit" class="block w-full rounded-md bg-white px-3.5 py-2.5 text-center text-sm font-semibold text-purple-600 shadow-sm hover:bg-purple-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                        </div>
                        <!-- <div class="sm:col-span-2 mt-3">
                          <a href="userLogin.php" class="  rounded-md bg-white px-3.5 py-2.5 text-center text-sm font-semibold text-purple-600 shadow-sm hover:bg-purple-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Login</a>
                        </div> -->
                        <div class="sm:col-span-2"><?php
                      echo ErrorMessage();
                      echo SuccessMessage();
                      ?></div>   
                </form>
                
            </div>
        </div>
    </div>
  </div>
</body>
</html>
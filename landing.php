
<?php require_once("includes/Function.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php
  if(isset($_POST["Submit"])){
      $conn = new mysqli('localhost', 'root', '', 'expensia');

      // I tried to conncet database using mysqli this time cause i haven't done this before

      $FirstName = $_POST["firstname"];
      $LastName = $_POST["lastname"];
      $Email = $_POST["email"];
      $message = $_POST["message"];
      if(empty($FirstName)||empty($LastName)||empty($Email)||empty($message)){
        $_SESSION["ErrorMessage"]= "Connot be empty";
        Redirect_to("landing.php#query");
       
      }else { 
        $full_name = $FirstName . ' ' . $LastName;

        $query = "INSERT INTO query (`query_person`, `email`, `message`) VALUES ('$full_name','$Email', '$message')";
        $result = mysqli_query($conn, $query);
        if ($result) {
          $_SESSION["SuccessMessage"] = "Message Sent Successfully";
          Redirect_to("landing.php#query");
        } else {
          $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again!";
          Redirect_to("landing.php#query");
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
      .scrolled {    
    background-color: rgb(107 33 168); 
  } 
  
    </style>
  
    <div class="relative firstHeader" >
        <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover opacity-80">
          <source src="assets/video/homepage_desktop_v2.webm" type="video/mp4">
          </video>

          <div class="absolute inset-0 bg-black opacity-75"></div>

          <div class="relative z-10">
          <!-- Navigation Bar -->
          <nav id="navbar" class="fixed top-0 left-0 w-full flex items-center justify-between px-16 py-4 bg-transparent">
            <div>
              <h1 class="text-l font-bold  text-white">EXPENSIA</h1>
            </div>
            <div class="md:block">
              <ul class="flex space-x-4">
                <li><a href="#" class="text-white text-sm font-semibold px-2 hover:text-purple-300" >Home</a></li>
                <li><a href="#services" class="text-white text-sm font-semibold px-2 hover:text-purple-300">Services</a></li>
                <li><a href="#aboutus" class="text-white text-sm font-semibold px-2 hover:text-purple-300">About Us</a></li>
                <li><a href="#" class="text-white text-sm font-semibold px-2 hover:text-purple-300">Contact</a></li>
              </ul>
            </div>
            <div class="hidden sm:flex sm:items-center">
              <a href="userLogin.php" class="text-white text-sm font-semibold hover:text-purple-300 mr-4">Login<i class="uil uil-arrow-right py-2"></i></a>      
            </div>
          </nav>
          <!-- Main Content -->
          <header class="text-white text-center flex items-center justify-center h-screen ">
            <div>
            <h1 class="text-4xl font-bold">The Easiest way to to manage
                <br>your personal finances.</h1>
            
            <div class="mt-10">
              
              <a href="userRegistration.php" class="hover:bg-transparent hover:text-purple-500 outline-purple-500 outline  bg-purple-500 px-7 rounded-xl text-white font-bold py-2 transition duration-300">Register Now</a>            
              <a href="userLogin.php" class="bg-transparent text-purple-500 outline-purple-500 outline  hover:bg-purple-500 px-7 rounded-xl hover:text-white font-bold py-2 transition duration-300 ml-5">Login</a>
            </div>
          </div>
          </header>
        </div>
      </div>
  
      <section id="services">
          <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
              <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-3xl font-bold tracking-tight text-purple-500 sm:text-4xl">Services</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-850 sm:text-3xl">Everything you need to manage your budgets</p>
                <p class="mt-6 text-lg leading-8 text-gray-600">Elevate your budgeting game with our comprehensive toolkit, designed to simplify and optimize your financial management.</p>
              </div>
              <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                  <div class="relative pl-16">
                    <dt class="text-base font-semibold leading-7 text-gray-800">
                      <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-purple-500">
                        <!--<svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                        </svg>-->
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5,12a1,1,0,0,0-1,1v8a1,1,0,0,0,2,0V13A1,1,0,0,0,5,12ZM10,2A1,1,0,0,0,9,3V21a1,1,0,0,0,2,0V3A1,1,0,0,0,10,2ZM20,16a1,1,0,0,0-1,1v4a1,1,0,0,0,2,0V17A1,1,0,0,0,20,16ZM15,8a1,1,0,0,0-1,1V21a1,1,0,0,0,2,0V9A1,1,0,0,0,15,8Z"></path>
                        </svg>
                      </div>
                      Expense at Hand
                    </dt>
                    <dd class="mt-2 text-base leading-7 text-gray-600">"Keep your finances in check with Expensia - effortlessly track your daily, monthly, and yearly expenses, all at your fingertips!"</dd>
                  </div>
                  <div class="relative pl-16">
                    <dt class="text-base font-semibold leading-7 text-gray-800">
                      <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-purple-500">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                      </div>
                      Categorise Expenses
                    </dt>
                    <dd class="mt-2 text-base leading-7 text-gray-600"> "Take charge of your spending habits and declutter your finances by effortlessly categorizing your daily expenses with Expensia!" </dd>
                  </div>
                  <div class="relative pl-16">
                    <dt class="text-base font-semibold leading-7 text-gray-800">
                      <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-purple-500">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                      </div>
                      Search Expenses via Payment Mode
                    </dt>
                    <dd class="mt-2 text-base leading-7 text-gray-600"> "Find your spending habits at your fingertips - effortlessly track down expenses by payment mode with Expensia!" </dd>
                  </div>
                  <div class="relative pl-16">
                    <dt class="text-base font-semibold leading-7 text-gray-800"> 
                      <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-purple-500">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0119.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 004.5 10.5a7.464 7.464 0 01-1.15 3.993m1.989 3.559A11.209 11.209 0 008.25 10.5a3.75 3.75 0 117.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 01-3.6 9.75m6.633-4.596a18.666 18.666 0 01-2.485 5.33" />
                        </svg>
                      </div>
                      View and Analyse your Expense History
                    </dt>
                    <dd class="mt-2 text-base leading-7 text-gray-600"> "Dive into your financial story with Expensia's dynamic real-time graphs, empowering you to visualize and analyze your expense history like never before!" </dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>
        </section>
      <section id = "query">
        <div class="isolate bg-purple-800 px-6 py-14 sm:py-24 lg:px-8">
          <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]" aria-hidden="true">
            <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
          </div>
          <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl mb-4 font-bold tracking-tight text-white sm:text-4xl">Query</h2>
            <p class="mt-2 text-lg leading-8 text-white">We'd love to hear from you! Drop us a line with your feedback or questions to help us make Expensia even better for you!</p>
          </div>
          <div class="mx-auto mt-16 max-w-xl sm:mt-20"><?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?></div>
          <form action="#" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
              <div>
                <label for="first-name" class="block text-sm font-semibold leading-6 text-white">First name</label>
                <div class="mt-2.5">
                  <input type="text" name="firstname" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 px-3.5 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
              </div>
              <div>
                <label for="last-name" class="block text-sm font-semibold leading-6 text-white">Last name</label>
                <div class="mt-2.5">
                  <input type="text" name="lastname" id="last-name" autocomplete="family-name" class="block w-full rounded-md border-0 px-3.5 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
              </div>
              
              <div class="sm:col-span-2">
                <label for="email" class="block text-sm font-semibold leading-6 text-white">Email</label>
                <div class="mt-2.5">
                  <input type="email" name="email" id="email" autocomplete="email" class="block w-full rounded-md border-0 px-3.5 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
              </div>
            
              <div class="sm:col-span-2">
                <label for="message" class="block text-sm font-semibold leading-6 text-white">Message</label>
                <div class="mt-2.5">
                  <textarea name="message" id="message" rows="4" class="block w-full rounded-md border-0 px-3.5 py-2 text-grey shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                </div>
              </div>
              
            </div>
            <div class="mt-10">
              <button type="submit" name="Submit" class="block w-full rounded-md bg-white px-3.5 py-2.5 text-center text-sm font-semibold text-purple-600 shadow-sm hover:bg-purple-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Let's talk</button>
            </div>
          </form>
        </div>
      </section>
      <section id="aboutus">
        <div class="container mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">
                <div class="max-w-lg">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">About Us</h2>
                    <p class="mt-4 text-gray-600 text-lg">Welcome to Expensia, your ultimate companion in financial management! At Expensia, we understand the importance of keeping track of your expenses effortlessly. Our platform is designed to streamline the process of monitoring your spending, offering intuitive tools and insightful analytics to empower you in making informed financial decisions. Whether you're a savvy investor, a diligent budgeter, or simply aiming for better financial health, Expensia is here to simplify your journey towards financial stability. With our user-friendly interface and comprehensive features, managing your expenses has never been easier. Join Expensia today and take control of your finances with confidence!</p>
                    <div class="mt-8">
                        <a href="#query" class="text-blue-500 hover:text-blue-600 font-medium">Contact us now to know more.
                            <span class="ml-2">&#8594;</span></a>
                    </div>
                </div>
                <div class="mt-12 md:mt-0">
                    <img src="https://images.collegedunia.com/public/reviewPhotos/397186/IMG-20230605-WA0022.jpg?mode=cover" alt="About Us Image" class="object-cover rounded-lg shadow-md">
                </div>
            </div>
        </div>
    </section>
</body>
<!-- component -->
<footer class="bg-purple-800">
  <div class="container px-6 py-12 mx-auto">
     
      
      <hr class="mb-6 border-gray-200 ">
      
      <div class="flex items-center justify-between">
          <a href="#">
            <h1 class="text-l font-bold  text-white">EXPENSIA</h1>
          </a>
          
          <div class="flex -mx-2">
              <a href="#" class="mx-2 text-gray-600 transition-colors duration-300 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400" aria-label="Reddit">
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                          d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C21.9939 17.5203 17.5203 21.9939 12 22ZM6.807 10.543C6.20862 10.5433 5.67102 10.9088 5.45054 11.465C5.23006 12.0213 5.37133 12.6558 5.807 13.066C5.92217 13.1751 6.05463 13.2643 6.199 13.33C6.18644 13.4761 6.18644 13.6229 6.199 13.769C6.199 16.009 8.814 17.831 12.028 17.831C15.242 17.831 17.858 16.009 17.858 13.769C17.8696 13.6229 17.8696 13.4761 17.858 13.33C18.4649 13.0351 18.786 12.3585 18.6305 11.7019C18.475 11.0453 17.8847 10.5844 17.21 10.593H17.157C16.7988 10.6062 16.458 10.7512 16.2 11C15.0625 10.2265 13.7252 9.79927 12.35 9.77L13 6.65L15.138 7.1C15.1931 7.60706 15.621 7.99141 16.131 7.992C16.1674 7.99196 16.2038 7.98995 16.24 7.986C16.7702 7.93278 17.1655 7.47314 17.1389 6.94094C17.1122 6.40873 16.6729 5.991 16.14 5.991C16.1022 5.99191 16.0645 5.99491 16.027 6C15.71 6.03367 15.4281 6.21641 15.268 6.492L12.82 6C12.7983 5.99535 12.7762 5.993 12.754 5.993C12.6094 5.99472 12.4851 6.09583 12.454 6.237L11.706 9.71C10.3138 9.7297 8.95795 10.157 7.806 10.939C7.53601 10.6839 7.17843 10.5422 6.807 10.543ZM12.18 16.524C12.124 16.524 12.067 16.524 12.011 16.524C11.955 16.524 11.898 16.524 11.842 16.524C11.0121 16.5208 10.2054 16.2497 9.542 15.751C9.49626 15.6958 9.47445 15.6246 9.4814 15.5533C9.48834 15.482 9.52348 15.4163 9.579 15.371C9.62737 15.3318 9.68771 15.3102 9.75 15.31C9.81233 15.31 9.87275 15.3315 9.921 15.371C10.4816 15.7818 11.159 16.0022 11.854 16C11.9027 16 11.9513 16 12 16C12.059 16 12.119 16 12.178 16C12.864 16.0011 13.5329 15.7863 14.09 15.386C14.1427 15.3322 14.2147 15.302 14.29 15.302C14.3653 15.302 14.4373 15.3322 14.49 15.386C14.5985 15.4981 14.5962 15.6767 14.485 15.786V15.746C13.8213 16.2481 13.0123 16.5208 12.18 16.523V16.524ZM14.307 14.08H14.291L14.299 14.041C13.8591 14.011 13.4994 13.6789 13.4343 13.2429C13.3691 12.8068 13.6162 12.3842 14.028 12.2269C14.4399 12.0697 14.9058 12.2202 15.1478 12.5887C15.3899 12.9572 15.3429 13.4445 15.035 13.76C14.856 13.9554 14.6059 14.0707 14.341 14.08H14.306H14.307ZM9.67 14C9.11772 14 8.67 13.5523 8.67 13C8.67 12.4477 9.11772 12 9.67 12C10.2223 12 10.67 12.4477 10.67 13C10.67 13.5523 10.2223 14 9.67 14Z">
                      </path>
                  </svg>
              </a>

              <a href="#" class="mx-2 text-gray-600 transition-colors duration-300 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400" aria-label="Facebook">
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                          d="M2.00195 12.002C2.00312 16.9214 5.58036 21.1101 10.439 21.881V14.892H7.90195V12.002H10.442V9.80204C10.3284 8.75958 10.6845 7.72064 11.4136 6.96698C12.1427 6.21332 13.1693 5.82306 14.215 5.90204C14.9655 5.91417 15.7141 5.98101 16.455 6.10205V8.56104H15.191C14.7558 8.50405 14.3183 8.64777 14.0017 8.95171C13.6851 9.25566 13.5237 9.68693 13.563 10.124V12.002H16.334L15.891 14.893H13.563V21.881C18.8174 21.0506 22.502 16.2518 21.9475 10.9611C21.3929 5.67041 16.7932 1.73997 11.4808 2.01722C6.16831 2.29447 2.0028 6.68235 2.00195 12.002Z">
                      </path>
                  </svg>
              </a>

              <a href="#" class="mx-2 text-gray-600 transition-colors duration-300 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400" aria-label="Github">
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                          d="M12.026 2C7.13295 1.99937 2.96183 5.54799 2.17842 10.3779C1.395 15.2079 4.23061 19.893 8.87302 21.439C9.37302 21.529 9.55202 21.222 9.55202 20.958C9.55202 20.721 9.54402 20.093 9.54102 19.258C6.76602 19.858 6.18002 17.92 6.18002 17.92C5.99733 17.317 5.60459 16.7993 5.07302 16.461C4.17302 15.842 5.14202 15.856 5.14202 15.856C5.78269 15.9438 6.34657 16.3235 6.66902 16.884C6.94195 17.3803 7.40177 17.747 7.94632 17.9026C8.49087 18.0583 9.07503 17.99 9.56902 17.713C9.61544 17.207 9.84055 16.7341 10.204 16.379C7.99002 16.128 5.66202 15.272 5.66202 11.449C5.64973 10.4602 6.01691 9.5043 6.68802 8.778C6.38437 7.91731 6.42013 6.97325 6.78802 6.138C6.78802 6.138 7.62502 5.869 9.53002 7.159C11.1639 6.71101 12.8882 6.71101 14.522 7.159C16.428 5.868 17.264 6.138 17.264 6.138C17.6336 6.97286 17.6694 7.91757 17.364 8.778C18.0376 9.50423 18.4045 10.4626 18.388 11.453C18.388 15.286 16.058 16.128 13.836 16.375C14.3153 16.8651 14.5612 17.5373 14.511 18.221C14.511 19.555 14.499 20.631 14.499 20.958C14.499 21.225 14.677 21.535 15.186 21.437C19.8265 19.8884 22.6591 15.203 21.874 10.3743C21.089 5.54565 16.9181 1.99888 12.026 2Z">
                      </path>
                  </svg>
              </a>
          </div>
      </div>
  </div>
</footer>
</html>
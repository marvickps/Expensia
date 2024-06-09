<?php require_once("includes/DB.php"); ?>
<?php
global $ConnectingDB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
function Redirect_to($New_Location){
    header("Location:".$New_Location);
    exit;
}

// function sendmail($email,$v_code){
//     require ('mailer/Exception.php'); 
//     require ('mailer/PHPMailer.php'); 
//     require ('mailer/SMTP.php'); 

//     $mail = new PHPMailer(true);
//     try {
//         //Server settings
//         $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//         $mail->isSMTP();                                            //Send using SMTP
//         $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
//         $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//         $mail->Username   = 'expensia2024@gmail.com';                     //SMTP username
//         $mail->Password   = 'projectexpensia';                               //SMTP password
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//         $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
//         //Recipients
//         $mail->setFrom('expensia2024@gmail.com', 'Expensia 2024');
//         $mail->addAddress($email);     //Add a recipient      
    
//         //Content
//         $mail->isHTML(true);                                  //Set email format to HTML
//         $mail->Subject = 'Please verify your email, Expensia 2024';
//         $mail->Body    = "Thanks for Registration!</b>
//             Please click the link to verify your mail address</b>
//             <a href='http://localhost/Expensia_atu/verify.php?email=$email&v_code=$v_code'>Verify </a>";
            
       
    
//         $mail->send();
//         return true;
//     } catch (Exception $e) {
//         return false;
//     }
// }


function CheckUserNameExistsOrNot($UserName){
global $ConnectingDB;
$sql="SELECT username FROM admin WHERE username=:userName";

$stmt = $ConnectingDB->prepare($sql);
$stmt ->bindValue(':userName', $UserName);
$stmt-> execute();
$Result = $stmt->rowcount();
if($Result==1){
    return true;
}
else{
    return false;
}

}
function Login_Attempt($UserName,$Password){
    global $ConnectingDB;
    $sql = "SELECT * FROM admin WHERE username=:userName AND password=:passWord LIMIT 1";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':userName',$UserName);
            $stmt->bindValue(':passWord',$Password);
            $stmt->execute();
            $Result = $stmt->rowcount();
            if($Result==1){
                return $stmt->fetch();
            }else{
                return null;
            }
}
function CheckUserNameExistsOrNotForUser($UserName){
  global $ConnectingDB;
  $sql="SELECT username FROM user WHERE username=:userName";
  
  $stmt = $ConnectingDB->prepare($sql);
  $stmt ->bindValue(':userName', $UserName);
  $stmt-> execute();
  $Result = $stmt->rowcount();
  if($Result==1){
      return true;
  }
  else{
      return false;
  }
  
  }
  function Login_AttemptForUser($UserName,$Password){
      global $ConnectingDB;
      $sql = "SELECT * FROM user WHERE username=:userName AND password=:passWord AND status='ON' LIMIT 1 ";
              $stmt = $ConnectingDB->prepare($sql);
              $stmt->bindValue(':userName',$UserName);
              $stmt->bindValue(':passWord',$Password);
              $stmt->execute();
              $Result = $stmt->rowcount();
              if($Result==1){
                  return $stmt->fetch();
              }else{
                  return null;
              }
  }
function Confirm_Login(){
    if(isset($_SESSION["UserId"])){
        return true;
    }else{
        $_SESSION["ErrorMessage"]="Login Requires";
        Redirect_to("UserLogin.php");
    }
}

?>
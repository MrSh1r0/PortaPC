<?php
session_start();
include_once("Helper.php");
// Create an instance of our Helper class
$helper                      = new Helper();

// here we check for all the variables if they are SET
// this is only for ADDING product
if(isset($_POST["submit_login"]) && isset($_POST["email"]) && isset($_POST["password"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];
  if(empty($email) === false && empty($password) === false){
    $response = json_decode($helper->loginAdmin($email, $password));
    if($response->result === true){
      $_SESSION["username"] = $response->admin_username;
      $_SESSION["user_email"] = $email;
      $_SESSION["user_password"] = $password;

      header("Location: ../pages/panel/admin.php?result=success&action=login&message=Sie haben sich angemeldet");
      exit;
    } else {
      header("Location: ../pages/panel/admin.php?result=mismatch&action=login&message=Ihre Angaben sind nicht korrekt");
      exit;
    }
  } else {
    header("Location: ../pages/panel/admin.php?result=empty&action=login&message=Bitte vollständigen Sie Ihre Angaben!");
    exit;
  }
} else if (isset($_POST["submit_logout"])) {
  session_unset();
  // destroy the session
  session_destroy();

  header("Location: ../pages/panel/admin.php?result=success&action=logout&message=Sie haben sich abgemeldet");
  exit;
}
?>

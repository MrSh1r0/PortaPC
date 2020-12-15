<?php
session_start();
/*
We will use a Helper class in PHP to get our Json content.
If we use JavaScript, our Json file will be exposed.
We want to try our best to keep it a bit secure, even if it's not the best approach.

First, include the class once. We don't want any duplicated includes of the same file (prevent any conflicts)
*/
include_once("../utilities/Helper.php");

// Create an instance of our Helper class
$helper                      = new Helper();
if(isset($_SESSION["email"]) === true && isset($_SESSION["password"]) === true && $helper->checkLogin($_SESSION["email"], $_SESSION["password"]) === true){
  header('Location: index.php');
  exit;
}


$login_result = "pending";

if(isset($_POST["input_email"]) && isset($_POST["input_password"])){
  $email = $_POST["input_email"];
  $password = $_POST["input_password"];
  if($helper->checkLogin($email, $password) === true){
    $login_result = "done";
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    header('Location: index.php');
    exit;
  } else {
    $login_result = "rejected";
  }
} else {

}

?>

<!DOCTYPE html>
<html lang="de" dir="ltr">

<head>
  <title>PortaPC</title>
  <meta charset="utf-8">
  <!-- Import Google's Roboto font -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <!--Let browser know that the website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link type="text/css" rel="stylesheet" href="../css/styles.css" media="screen" />
  <script src="../js/scripts.js"></script>
  <script>
    document.onreadystatechange = function() {
      if (document.readyState == "complete") {
        let login_result = "<?php echo $login_result ?>";
        if(login_result == "rejected"){
          alert("Anmeldung war nicht erfolgreich!");
        }
      }
    }
  </script>
</head>

<body>



  <!-- Navbar -->
  <!-- By default, the navbar is hidden -->
  <div class="navbar-fixed nav-default" id="nav-container">
    <nav class="nav-default" id="nav">
      <div class="nav-wrapper">
        <a href="/"><div class="website-logo"></div></a>
      </div>
    </nav>
  </div>

  <div class="container top-bar" id="top-bar">
    <div class="row">
      <!--Logo column-->
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <a href="/"><div class="website-logo" ></div></a>
      </div>
      <!--End of Logo column-->


    </div>
  </div>

  <main id="homepage-content" class="margin-t-4">
    <div class="container">
      <div class="row justify-content-center">
        <!-- login -->
        <div class="col-xs-12 col-sm-12 col-md-4">
          <form class="row cardview justify-content-center" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="col-xs-12 col-sm-12 col-md-8">
              <input class="login-input" name="input_email" placeholder="Email"/>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
              <input class="login-input" name="input_password" placeholder="Passwort"/>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5">
              <button class="login-button text-uppercase clickable">Anmelden</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>



  </footer>


  <!-- <script type="text/javascript" src="js/slide.js"></script> -->
</body>

</html>

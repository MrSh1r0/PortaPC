<?php
/*
We will use a Helper class in PHP to get our Json content.
If we use JavaScript, our Json file will be exposed.
We want to try our best to keep it a bit secure, even if it's not the best approach.

First, include the class once. We don't want any duplicated includes of the same file (prevent any conflicts)
*/
include_once("../utilities/Helper.php");

// Create an instance of our Helper class
$helper                      = new Helper();

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
      <div class="row">

        <!-- login -->
        <div class="col-xs-12">

        </div>
      </div>
    </div>
  </main>



  </footer>


  <!-- <script type="text/javascript" src="js/slide.js"></script> -->
</body>

</html>

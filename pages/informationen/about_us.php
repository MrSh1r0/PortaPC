<?php
/*
We will use a Helper class in PHP to get our Json content.
If we use JavaScript, our Json file will be exposed.
We want to try our best to keep it a bit secure, even if it's not the best approach.

First, include the class once. We don't want any duplicated includes of the same file (prevent any conflicts)
*/
include_once("../../utilities/Helper.php");

// Create an instance of our Helper class
$helper                      = new Helper();

// create an instance of our latest products

$categories                  = $helper->getCategories(false);
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">

<head>
  <title>Über uns</title>
  <meta charset="utf-8">
  <link rel="icon" type="image/png" href="../../favicon.png"/>
  <!-- Import Google's Roboto font -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <!--Let browser know that the website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link type="text/css" rel="stylesheet" href="../../css/styles.css" media="screen" />
  <script src="../../js/scripts.js"></script>
  <script>
    let categories = <?php echo $helper->getCategories(true) ?>;

    document.onreadystatechange = function() {
      if (document.readyState == "complete") {
        handleScroll();
        handleSearchCategoryList();
      }
    }
  </script>
</head>

<body>

  <!-- Side nav -->
  <div class="mobile-side-navigation-container " id="mobile_side_navigation_container">
    <i class="material-icons mobile-side-navigation-menu margin-t-2" id="mobile_side_navigation_menu" onclick="handleMobileNavigation()">menu</i>
  </div>

  <!-- Navbar -->
  <!-- By default, the navbar is hidden -->
  <div class="navbar-fixed nav-default" id="nav-container">
    <nav class="nav-default" id="nav">
      <div class="nav-wrapper">
        <a href="/PortaPC"><div class="website-logo"></div></a>
      </div>
    </nav>
  </div>

  <div class="container" id="top-bar">
    <div class="row">
      <!--Logo column-->
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
        <a href="/PortaPC"><div class="website-logo"></div></a>
      </div>
      <!--End of Logo column-->

      <!--Search & Category parent-->
      <div class="col-xs-10 col-sm-10 col-md-10 col-lg-8">

        <!--Search & Category row-->
        <div class="row search-container margin-a-0 padding-a-0">

          <!--Search column-->
          <div class="col-xs-8 col-sm-9 fill-height margin-a-0">
            <div class="input-field margin-a-0 fill-height">

              <!--Search input-->
              <div class="row margin-a-0 padding-a-0 fill-height">
                <div class="col-xs-2 col-sm-2 col-md-1 margin-a-0 padding-a-0 align-self-center text-align-center">
                  <i class="search-icon material-icons">search</i>
                </div>

                <div class="col-xs-10 col-sm-10 col-md-11 margin-a-0 padding-a-0">
                  <input id="search_input" class="search-input margin-y-0" placeholder="Wonach suchen Sie?" type="text" onkeydown="handleSearch(this)">
                </div>
              </div>
            </div>
          </div>
          <!--End of Search column-->

          <div class="col-xs-4 col-sm-3 margin-a-0 fill-height searchbar-category-container vertical-left-line categories-dropdown-container">
            <div class="categories-dropdown">
              <p class='searchbar-category-dropdown' id="searchbar-category-text"><?php echo $categories[0] ?></p>
              <div id="categories-dropdown-content" class="categories-dropdown-content">
                <?php
                foreach($categories as $category){
                ?>

                <p class="categories-dropdown-item" onclick="handleSearchCategroyText('<?php echo $category ?>')"><?php echo $category ?></p>

                <?php
                }
                ?>

              </div>
            </div>

          </div>
        </div>
        <!--End of Search & Categroy row-->

      </div>
      <!--End of Search & Category parent-->

      <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 align-self-center banner-product-add">
        <a href="/PortaPC/pages/panel/product_add.php"><p class="banner-product-add-text clickable text-align-center">Anzeige aufgeben</p></a>
      </div>
    </div>
  </div>

  <main id="homepage-content" class="margin-t-4">
    <div class="container">
      <div class="row">

        <!-- Left side of the content -->
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 margin-a-0 padding-a-0 padding-r-3 categories-col-container" id="categories-col-container">
          <div class="row">
            <!-- Category title -->
            <div class="col-xs-12 col-sm-12">
              <p class="category-title text-uppercase">Informationen</p>
            </div>

            <!-- Category card -->
            <div class="col-xs-12 col-sm-12">
              <div class="categories-container">
                <ul class="categories-list" id="categories-list">
                  <li><a class="categories-item categories-item-selected" href="/PortaPC/pages/informationen/about_us.php">Über uns</a></li>
                  <li><a class="categories-item" href="/PortaPC/pages/informationen/agb.php">AGB</a></li>
                  <li><a class="categories-item" href="/PortaPC/pages/informationen/impressum.php">Impressum</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Right side of the content -->
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 margin-a-0 padding-a-0">
          <div class="row">

            <div class="col-xs-12">
              <p class="category-title text-uppercase">Über uns</p>
            </div>

            <div class="col-xs-12">
              <p class="text-subtitle text-weight-medium">Das sind wir:</p>
              <!-- <br></br> SPACE -->
              <p class="text-body-1 text-weight-regular">
                Wir sind vier Informatikstudenten aus der schönen Stadt Trier. Wir sind im ersten Semester und dachten uns, was braucht die Welt noch.
                Na klar, eine Webseite, auf der man einfach, günstig und vorallem sicher, Hardware für seinen PC kaufen kann.
              </p>
              <br><br>
              <p class="text-subtitle text-weight-medium">Unsere Idee:</p>
              <p class="text-body-1 text-weight-regular">
                Unsere Idee war es eine Webseite zu entwickeln, auf der Benutzer ihre benutzte Hardware zum verkauf anbieten kann und gleichzeitig Anderen
                die Möglichkeit zu bieten für wenig Geld ihr Setup aufzurüsten. Zudem gibt es Angebote die verifiziert sind, das heißt, dass diese Artikel von unserem Team
                geprüft wurden und generalüberholt worden sind.
              </p>
              <br><br>
              <p class="text-subtitle text-weight-medium">Wie funktioniert es:</p>
              <p class="text-body-1 text-weight-regular">
                Es ist einfacher als man denkt, wenn man ein Produkt sucht, gibt man den Namen in der Suchleiste ein und man bekommt direkt alle Produkte angzeigt.
                Wenn man zum Beispiel noch nicht genau weiß welche Grafikkarte man haben will, kann man einfach im Filtersystem seine Kriterien eingeben und man bekommt die Produkte angezeigt, die darauf zutreffen.
                Eine Anzeige aufgeben ist genauso leicht, alles was man dafür braucht ist ein Bild des Produkts und eine E-Mailadresse. Man klickt auf dem Button in der rechten, oberen Ecke und wir zu einem Forular weitergeleitet,
                indem man seine Daten eingibt. Falls sich dann ein andere Benutzer für dein Produkt interessiert, kann er über die E-Mailadresse mit Ihnen in Kontakt treten.
              </p>
              <br>
            </div>

            <div class="col-xs-12">
              <p class="text-subtitle text-weight-medium">PortaPC Team</p>
            </div>
            <?php

            foreach($helper->getWebsiteDevs() as $dev){
              ?>
              <div class="col-xs-6 col-sm-6 col-md-2">
                <div class="row padding-a-0 margin-a-0">
                  <div class="col-xs-12  text-align-center">
                    <img class="dev-profile-picture" src="<?php echo $dev->profile_picture ?>" alt="Profile picture"/>
                  </div>
                  <div class="col-xs-12 text-align-center margin-t-0">
                    <p class="text-subtitle text-weight-medium"><?php echo $dev->name ?></p>
                  </div>
                </div>
              </div>
              <?php
            }
            ?>

          </div>
        </div>

      </div>
    </div>
  </main>

  <footer class="margin-t-4">
    <div class="container">
      <div class="row justify-content-center">

        <div class="col-xs-12 padding-a-0 margin-a-0 margin-b-4">
          <div class="separator-line"></div>
        </div>

        <div class="col-xs-12 col-md-4 col-lg-4">
          <p class="footer-title"><?php echo $helper->getInformation()->about_us_title ?></p>
          <p class="footer-content"><?php echo $helper->getInformation()->about_us_summary ?></p>
        </div>

        <div class="col-xs-12 col-md-2 col-lg-2">
          <p class="footer-title">Informationen</p>

          <a href="/PortaPC/pages/informationen/about_us.php">
            <p class="footer-content">Über uns</p>
          </a>
          <a href="/PortaPC/pages/informationen/impressum.php">
            <p class="footer-content">Impressum</p>
          </a>
          <a href="/PortaPC/pages/informationen/agb.php">
            <p class="footer-content">AGB</p>
          </a>


        </div>

        <div class="col-xs-12 col-md-2 col-lg-2 margin-a-0">
          <div class="row">
            <div class="col-xs-12 padding-l-0">
              <p class="footer-title">Kontakt</p>
              <p class="footer-content"><?php echo $helper->getInformation()->contact_email ?></p>
            </div>

            <div class="col-xs-12 margin-a-0 padding-l-0">
              <p class="footer-title">Folge uns</p>
              <div class="row margin-t-2">
                <div class="margin-a-0 padding-a-0 margin-r-1">
                  <a href="<?php echo $helper->getSocialLinks()->facebook ?>"><img class="footer-social-icon" src="/PortaPC/images/footer/social_icons/facebook.svg" alt="Facebook"></a>
                </div>
                <div class="margin-a-0 padding-a-0 margin-x-1">
                  <a href="<?php echo $helper->getSocialLinks()->twitter ?>"><img class="footer-social-icon" src="/PortaPC/images/footer/social_icons/twitter.svg" alt="Twitter"></a>
                </div>
                <div class="margin-a-0 padding-a-0 margin-x-1">
                  <a href="<?php echo $helper->getSocialLinks()->instagram ?>"><img class="footer-social-icon" src="/PortaPC/images/footer/social_icons/instagram.svg" alt="Instagram"></a>
                </div>
                <div class="margin-a-0 padding-a-0 margin-x-1">
                  <a href="<?php echo $helper->getSocialLinks()->youtube ?>"><img class="footer-social-icon" src="/PortaPC/images/footer/social_icons/youtube.svg" alt="Youtube"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </footer>

  <button class="scroll-top-button" id="scroll-top-button" title="Nach oben scrollen">nach oben</button>

  <!-- <script type="text/javascript" src="js/slide.js"></script> -->
</body>

</html>

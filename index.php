<?php
session_start();
/*
We will use a Helper class in PHP to get our Json content.
If we use JavaScript, our Json file will be exposed.
We want to try our best to keep it a bit secure, even if it's not the best approach.

First, include the class once. We don't want any duplicated includes of the same file (prevent any conflicts)
*/
include_once("utilities/Helper.php");

// Create an instance of our Helper class
$helper                      = new Helper();

// create an instance of our latest products
$products_latest_sort_object = (object) ["sort_by" => "created_at", "sort_order" => "desc"];
$products_latest_json        = json_decode($helper->getProducts(null, $products_latest_sort_object, $helper->homepage_products_latest_limit, null));

$categories                  = $helper->getCategories(false);
$sliders                     = $helper->getSliders();
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

  <link type="text/css" rel="stylesheet" href="css/styles.css" media="screen" />
  <script src="js/scripts.js"></script>
  <script>
    let categories = <?php echo $helper->getCategories(true) ?>;

    document.onreadystatechange = function() {
      if (document.readyState == "complete") {
        handleSlider(0);
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

  <div class="container top-bar" id="top-bar">
    <div class="row">
      <!--Logo column-->
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
        <a href="/PortaPC"><div class="website-logo" ></div></a>
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
              <p class="category-title text-uppercase">Entdecken</p>
            </div>

            <!-- Category card -->
            <div class="col-xs-12 col-sm-12">
              <div class="categories-container">
                <ul class="categories-list" id="categories-list">


                  <?php
                  foreach($categories as $category){
                  ?>
                  <li><a class="categories-item" href="/PortaPC/pages/products/category.php?category=<?php echo $category ?>"><?php echo $category ?></a></li>
                  <?php
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Right side of the content -->
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 margin-a-0 padding-a-0">
          <div class="row">

            <div class="col-xs-12 col-sm-12">
              <p class="category-title text-uppercase">Homepage</p>
            </div>

            <!-- Slider placeholder -->
            <div class="col-xs-12 col-sm-12">

              <div class="slider">
                <?php
                foreach($sliders as $slider){
                  $thumbnail = $slider->thumbnail;
                  $redirect_url = $slider->redirect_url;
                ?>
                <a class="slide slide-fade-in" href="<?php echo $redirect_url ?>">
                  <img class="slide-image" src="/PortaPC/images/slider/<?php echo $thumbnail ?>">
                </a>
                <?php
                }
                ?>
                <!-- Next and previous buttons -->
                <i class="material-icons slide-previous" onclick="applySlider(-1, true)">arrow_back_ios</i>
                <i class="material-icons slide-next" onclick="applySlider(1, true)">arrow_forward_ios</i>

                <!-- The dots/circles -->
                <div class="slider-dots">
                  <?php
                  for($i = 0; $i < sizeof($sliders); $i++){
                  ?>
                  <span class="slide-dot" onclick="applySlider(<?php echo $i ?>, false)"></span>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>


            <div class="col-xs-6 col-sm-6">
              <p class="category-title text-uppercase">Neueste Anzeige</p>
            </div>

            <!-- Combine PHP and HTML, if the if clause is true, then the HTML code will be shown -->
            <?php if ($products_latest_json->has_more === true){
              ?>

              <div class="col-xs-6 col-sm-6">
                <a class="category-show-more text-uppercase clickable float-right" href="/PortaPC/pages/products/category.php?sort_by=created_at&sort_order=desc">alles anzeigen</a>
              </div>

              <!-- Close the if clause -->
              <?php
            } else {
              ?>

              <!-- We need to take the 6 columns grid space, when the "ALLES ANZEIGEN" is not enabled -->
              <div class="col-xs-6 col-sm-6"></div>
              <?php
            }
            ?>


            <?php
            $products_latest = $products_latest_json->products;
            foreach($products_latest as $product){
              $id = $product->id;
              $title = $product->title;
              $images = $product->images;
              $price = $product->price;
              $location = $product->location;
              $owner = $product->owner;
              $is_admin = $owner->user_type == "admin";
              ?>

              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-3 product">
                <a href="/PortaPC/pages/products/product.php?id=<?php echo $id ?>">
                  <div class="row">
                    <!-- image part -->
                    <div class="col-xs-12 col-sm-12 margin-a-0 product-image-container">
                      <img src="/PortaPC/images/products/<?php echo $id ?>/<?php echo $images[0] ?>" class="product-image" alt="product">
                        <div class="product-price-container">
                          <p class="product-price">€<?php echo $price ?></p>
                        </div>
                      </img>
                    </div>

                    <!-- title -->
                    <div class="col-xs-12 col-sm-12 margin-a-0 margin-t-2">
                      <p class="product-title"><?php
                      if($is_admin === true) {
                        ?>
                        <i class="material-icons product-owner-check">check</i>
                        <?php
                      }
                      echo $title;
                      ?></p>
                    </div>

                    <!-- location -->
                    <div class="col-xs-12 col-sm-12 margin-a-0 margin-t-1">
                      <p class="product-location"><?php echo $location ?></p>
                    </div>

                  </div>
                </a>
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
                <div class="col-xs margin-a-0 padding-a-0 margin-r-1">
                  <a href="<?php echo $helper->getSocialLinks()->facebook ?>"><img class="footer-social-icon" src="/PortaPC/images/footer/social_icons/facebook.svg" alt="Facebook"></a>
                </div>
                <div class="col-xs margin-a-0 padding-a-0 margin-x-1">
                  <a href="<?php echo $helper->getSocialLinks()->twitter ?>"><img class="footer-social-icon" src="/PortaPC/images/footer/social_icons/twitter.svg" alt="Twitter"></a>
                </div>
                <div class="col-xs margin-a-0 padding-a-0 margin-x-1">
                  <a href="<?php echo $helper->getSocialLinks()->instagram ?>"><img class="footer-social-icon" src="/PortaPC/images/footer/social_icons/instagram.svg" alt="Instagram"></a>
                </div>
                <div class="col-xs margin-a-0 padding-a-0 margin-x-1">
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

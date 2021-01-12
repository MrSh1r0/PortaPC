<?php
session_start();
/*
We will use a Helper class in PHP to get our Json content.
If we use JavaScript, our Json file will be exposed.
We want to try our best to keep it a bit secure, even if it's not the best approach.

First, include the class once. We don't want any duplicated includes of the same file (prevent any conflicts)
*/
include_once("../../utilities/Helper.php");

// Create an instance of our Helper class
$helper                      = new Helper();


$categories                  = $helper->getCategories();
$conditions                  = $helper->getConditions();
$locations                   = $helper->getLocations(false);

$login_status = false;
if(isset($_SESSION["user_email"]) && isset($_SESSION["user_password"])){
  if(json_decode($helper->loginAdmin($_SESSION["user_email"], $_SESSION["user_password"]))->result === true){
    $login_status = true;
  }
}

$result = null;
$message = null;
$post_token_id = null;
$post_token_password = null;
$product_id = null;
$product = null;
if(isset($_GET["result"]) && isset($_GET["action"])){
  $result = $_GET["result"];
  $action = $_GET["action"];
  $message = $_GET["message"];
}

if(isset($_GET["id"]) === true && empty($_GET["id"]) === false && isset($_GET["post_token_id"]) === true && isset($_GET["post_token_password"]) === true){
  $product_id = $_GET["id"];
  $post_token_id = $_GET["post_token_id"];
  $post_token_password = $_GET["post_token_password"];
  $product = $helper->getProduct($product_id);
}



?>

<!DOCTYPE html>
<html lang="de" dir="ltr">

<head>
  <title>Anzeige bearbeiten</title>
  <link rel="icon" type="image/png" href="../../favicon.png"/>
  <meta charset="utf-8">
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


    document.onreadystatechange = function() {
      if (document.readyState == "complete") {
        handleScroll();
        handleSearchCategoryList();
      }
    }

    function removeUploadedPicture(id, size){
      // javascript doesn't let us delete an element
      // but it let us delete a child of an element
      // so we go to the parent and then we remove the child
      var elem = document.getElementById(id);
      elem.parentNode.removeChild(elem);
      let has_uploaded_pictures = false;
      for(let i = 0; i < size; i++){
        let el = document.getElementById(`uploaded_image_${i}`);
        // if this element exists, then we have an uploaded picture
        if(el){
          has_uploaded_pictures = true;
        }
      }

      if(!has_uploaded_pictures){
        document.getElementById("uploaded_images_no_result").style.display = "initial";
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
              <p class='searchbar-category-dropdown' id="searchbar-category-text">Alle Kategorien</p>
              <div id="categories-dropdown-content" class="categories-dropdown-content">
                <p class="categories-dropdown-item" onclick="handleSearchCategroyText('Alle Kategorien')">Alle Kategorien</p>
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
              <p class="category-title text-uppercase">Anzeige bearbeiten</p>
            </div>

            <!-- https://www.w3schools.com/tags/att_form_enctype.asp -->
            <div class="col-xs-12 padding-a-0 margin-a-0">
              <form class="row padding-a-0 margin-a-0" action="../../utilities/Product.php" method="POST" enctype='multipart/form-data'>
                <?php

                if(empty($message) === false){
                  ?>
                  <div class="col-xs-12">
                    <p class="listing-response-message"><?php echo $message ?></p>
                  </div>
                  <?php
                }

                if($result == "success" && empty($post_token_id) === false && empty($post_token_password) === false){
                  $page_edit = "/PortaPC/pages/panel/product_edit.php?id=" . $product_id . "&post_token_id=" . $post_token_id . "&post_token_password=" . $post_token_password;
                  $page_delete = "/PortaPC/pages/panel/product_delete.php?id=" . $product_id . "&post_token_id=" . $post_token_id . "&post_token_password=" . $post_token_password;
                  ?>
                  <div class="col-xs-12">
                    <p class="listing-response-message">Um die Anzeige zu bearbeiten, klicken Sie bitte diesen <?php echo "<a href='" . $page_edit . "'>Link</a>" ?> (speichern Sie diesen Link ab!).</p>
                    <p class="listing-response-message">Um die Anzeige zu löschen, klicken Sie bitte diesen <?php echo "<a href='" . $page_delete . "'>Link</a>" ?> (speichern Sie diesen Link ab!).</p>
                  </div>
                  <?php
                }

                if(empty($product) === false){
                  ?>

                  <div class="col-xs-2">
                    <input class="product-listing-input-title" value="<?php echo $product_id ?>" placeholder="ID" name="id" readonly ></input>
                  </div>

                  <div class="col-xs-4">
                    <input class="product-listing-input-title" value="<?php echo $post_token_id ?>" placeholder="Post ID" name="post_token_id" readonly ></input>
                  </div>

                  <div class="col-xs-6">
                    <input class="product-listing-input-title" value="<?php echo $post_token_password ?>" placeholder="Post password" name="post_token_password" readonly ></input>
                  </div>

                  <?php
                    ?>
                    <!-- username -->
                    <div class="col-xs-6">
                      <input class="product-listing-input-title" placeholder="Name" name="name" value="<?php echo $product->owner->username ?>"></input>
                    </div>

                    <div class="col-xs-6">
                      <input class="product-listing-input-title" type="email" placeholder="Email" name="email" value="<?php echo $product->owner->user_email ?>"></input>
                    </div>
                    <?php

                  ?>

                  <!-- title -->
                  <div class="col-xs-12">
                    <input class="product-listing-input-title" placeholder="Titel" name="title" value="<?php echo $product->title ?>"></input>
                  </div>
                  <!-- Description -->
                  <div class="col-xs-12">
                    <textarea class="product-listing-input-description" placeholder="Beschreibung (Sie können HTML tags verwenden)" name="description"><?php echo $product->description ?></textarea>
                  </div>
                  <!-- price -->
                  <div class="col-xs-12 col-sm-12 col-md-3">
                    <input type="number" name="price" min="0" value="<?php echo $product->price ?>" step="1" onfocus="this.previousValue = this.value" onkeydown="this.previousValue = this.value" oninput="validity.valid || (value = this.previousValue)" class="product-listing-input-price" placeholder="Preis"></input>
                  </div>
                  <!-- category -->
                  <div class="col-xs-12 col-sm-12 col-md-3">
                    <select class="product-listing-select" name="category" id="category">
                      <?php
                      foreach($categories as $category){
                        $is_selected = $product->category == $category;
                        ?>
                        <option <?php if($is_selected) echo "selected='selected'" ?>  value="<?php echo $category ?>"><?php echo $category ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <!-- condition -->
                  <div class="col-xs-12 col-sm-12 col-md-3">
                    <select class="product-listing-select" name="condition" id="condition">
                      <?php
                      foreach($conditions as $condition){
                        $is_selected = $product->condition == $condition;
                        ?>
                        <option <?php if($is_selected) echo "selected='selected'" ?>  value="<?php echo $condition ?>"><?php echo $condition ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <!-- location -->
                  <div class="col-xs-12 col-sm-12 col-md-3">
                    <select class="product-listing-select" name="location" id="location">
                      <?php
                      foreach($locations as $location){
                        $is_selected = $product->location == $location;
                        ?>
                        <option <?php if($is_selected) echo "selected='selected'" ?> value="<?php echo $location ?>"><?php echo $location ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <!-- images -->
                  <!-- we will hide the input value and pass the uploaded images into the form easily -->
                  <div class="col-xs-12">
                    <div class="product-listing-input-file">
                      <div class="row">
                        <div class="col-xs-12">
                          <p class="product-listing-edit-image-label">Hochgeladene Bilder</p>
                        </div>
                        <div class="col-xs-12 text-align-center" id="uploaded_images_no_result" style="display: none;">
                          <p class="product-listing-edit-image-label">Es gibt keine Bilder mehr!</p>
                        </div>
                        <?php
                        $i = 0;
                        foreach($product->images as $image){
                          $i++;
                          ?>
                          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 text-align-center" id="uploaded_image_<?php echo $i ?>">
                            <div class="row">
                              <div class="col-xs-12 padding-a-0 margin-a-0 text-align-center user-select-none">
                                <input readonly class="product-listing-edit-image" style="background: url('/PortaPC/images/products/<?php echo $product->id ?>/<?php echo $image ?>')" name="images_uploaded[]" value="<?php echo $image ?>" title="Bild"></input>
                              </div>
                              <div class="col-xs-12 padding-a-0 margin-a-0 text-align-center">
                                <button class="product-listing-edit-image-remove clickable text-uppercase" onclick="removeUploadedPicture('uploaded_image_<?php echo $i ?>', <?php echo sizeof($product->images) ?>)">Löschen</button>
                              </div>
                            </div>
                          </div>
                          <?php
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                  <!-- New images -->
                  <div class="col-xs-12">
                    <div class="product-listing-input-file">
                      <label for="images">Neue Bilder auswählen: </label>
                      <input id="images" type="file" name="images_upload[]" accept="image/x-png,image/gif,image/jpeg" multiple="multiple"/>
                    </div>
                  </div>
                  <!-- submit -->
                  <div class="col-xs-12 text-align-right">
                    <button class="product-listing-submit text-uppercase clickable" type="submit" name="submit_edit">Bearbeiten</button>
                  </div>

                  <?php
                } else {
                  if(empty($message) === true){
                  ?>
                  <div class="col-xs-12">
                    <p class="listing-response-message">Wir können keine Anzeige mit diesem ID finden!</p>
                  </div>
                  <?php
                  }
                }
                  ?>

              </form>
            </div>

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
          <a href="/PortaPC/pages/informationen/agb.php">
            <p class="footer-content">AGB</p>
          </a>
          <a href="/PortaPC/pages/informationen/impressum.php">
            <p class="footer-content">Impressum</p>
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
              <div class="footer-social-icon-list row margin-t-2">
                <div class="margin-a-0 padding-a-0 margin-r-1">
                  <a href="<?php echo $helper->getSocialLinks()->facebook ?>"><img class="footer-social-icon" src="/PortaPC/images/footer/social_icons/facebook.svg" alt="Facebook"></a>
                </div>
                <div class="margin-a-0 padding-a-0 margin-x-1">
                  <a href="<?php echo $helper->getSocialLinks()->twitter ?>"><img class="footer-social-icon" src="/PortaPC/images/footer/social_icons/twitter.svg" alt="Twitter"></a>
                </div>
                <div class="margin-a-0 padding-a-0 margin-x-1">
                  <a href="<?php echo $helper->getSocialLinks()->instagram ?>"><img class="footer-social-icon" src="/PortaPC/images/footer/social_icons/instagram.svg" alt="Instagram"></a>
                </div>
                <div class="margin-a-0 padding-a-0 margin-l-1">
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

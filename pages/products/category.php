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

// create an instance of our latest products


$products_sort_object = null;
if(isset($_GET['sort_by']) === true && isset($_GET['sort_order']) === true){
  $products_sort_object = (object) ["sort_by" => $_GET['sort_by'], "sort_order" => $_GET['sort_order']];
}

$products_search_object = [];
if(isset($_GET['title']) === true){
  $title = $_GET['title'];
  $products_search_object += ['title' => $title];
}

if(isset($_GET['search_type']) === true){
  $search_type = $_GET['search_type'];
  $products_search_object += ['search_type' => $search_type];
}

if(isset($_GET['price']) === true){
  $price = $_GET['price'];
  $price_range = explode(",", $price);
  // here we check if max < min
  // then we change that
  // then we create a new string for the price
  // of course, it's not needed, but it will be a bonus point in our project to pay attention to little details
  // a user can change the url and cause some weird results
  $price_range_min = $price_range[0];
  $price_range_max = $price_range[1];

  if(empty($price_range_min) === false && empty($price_range_max) === false){
    if($price_range_max < $price_range_min){
      $price_range_min_placeholder = $price_range_min;
      $price_range_min = $price_range_max;
      $price_range_max = $price_range_min_placeholder;
      $price = $price_range_min . "," . $price_range_max;
    }
  }
  $products_search_object += ['price' => $price];
}

if(isset($_GET['category']) === true){
  $category = $_GET['category'];
  $products_search_object += ['category' => $category];
}

if(isset($_GET['locations']) === true){
  $locations = $_GET['locations'];
  $products_search_object += ['locations' => $locations];
}

if(isset($_GET['conditions']) === true){
  $conditions = $_GET['conditions'];
  $products_search_object += ['conditions' => $conditions];
}

// if this array is null, then we don't have a search object, so just nullify it.
if(sizeof($products_search_object) === 0){
  $products_search_object = null;
} else {
  // we do indeed have some search filters, therefore, cast to an object.
  $products_search_object = (object) $products_search_object;
}

$page_current = 1;
if(isset($_GET['page_current']) === true){
  $page_current = $_GET['page_current'];
  // prevent any weird values
  if($page_current < 1){
    $page_current = 1;
  }
}

$products_json        = json_decode($helper->getProducts($products_search_object, $products_sort_object, null, $page_current));

$categories           = $helper->getCategories(false);
$conditions           = $helper->getConditions();
$locations            = $helper->getLocations();
$products             = $products_json->products;
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">

<head>
  <title>Suche</title>
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

        let category_selected = "";
        <?php if(isset($_GET["category"])){
          ?>
          category_selected = "<?php echo $_GET['category']; ?>";
          <?php
        }
        ?>
        // if the value is set and actually exists, do the if clause.
        if(category_selected){
          handleSearchCategroyText(category_selected);
        }
        refreshFilters(<?php echo json_encode($products_search_object) ?>, <?php echo json_encode($products_sort_object) ?>);
        handleScroll();
        handleDropdowns();
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

  <header class="container" id="top-bar">
    <div class="row">
      <!--Logo column-->
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
        <a href="/PortaPC"><div class="website-logo"></div></a>
      </div>
      <!--End of Logo column-->

      <!--Search & Category parent-->
      <div class="col-xs-10 col-sm-10 col-md-10 col-lg-8 fill-width">

        <!--Search & Category row-->
        <div class="row search-container">

          <!--Search column-->
          <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 fill-height margin-a-0">
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

          <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 margin-a-0 fill-height searchbar-category-container vertical-left-line categories-dropdown-container">
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
  </header>

  <main id="homepage-content" class="margin-t-4">
    <div class="container">
      <div class="row">

        <!-- Left side of the content -->
        <div class="col-sm-12 col-md-4 col-lg-3 margin-a-0 padding-a-0 padding-r-3 categories-col-container" id="categories-col-container">
          <div class="row">
            <!-- Category title -->
            <div class="col-xs-12 col-sm-12">
              <p class="category-title text-uppercase">Suche</p>
            </div>

            <!-- Category card -->
            <div class="col-xs-12 col-sm-12 filters-container">

                <div class="row padding-a-0 margin-a-0">
                  <div class="col-xs-12 col-sm-12">
                    <p class="filters-title">Suche</p>
                    <ul class="filters-categories-list" id="search-type-list">
                      <li><a class="search-type-item clickable" onclick="refreshSearchType('Normal')">Normal</a></li>
                      <li><a class="search-type-item clickable" onclick="refreshSearchType('Erweitert')">Erweitert</a></li>
                    </ul>
                  </div>

                  <div class="col-xs-12 col-sm-12">
                    <p class="filters-title">Kategorien</p>
                    <ul class="filters-categories-list" id="filters-categories-list">
                      <?php
                      foreach($categories as $category){
                      ?>
                      <li><a class="filters-categories-item clickable" onclick="refreshFiltersCategory('<?php echo $category ?>')"><?php echo $category ?></a></li>
                      <?php
                      }
                      ?>
                    </ul>
                  </div>

                  <div class="col-xs-12 col-sm-12">
                    <p class="filters-title">Preis</p>
                    <div class="row margin-a-0 padding-a-0">
                      <div class="col-xs-6 col-sm-6">
                        <!-- We basically save the previous value -->
                        <!-- then we check if the user entered something negative or something that is NOT a number -->
                        <!-- when that happens, we return to the old VALID number -->
                        <!-- min is our minimum, step is to prevent decimals -->
                        <!-- onfocus and onkeydown are two different state of input changes -->
                        <!-- in those states, we save the variable -->
                        <!-- oninput has the new variable, there we check for the validation of the input -->
                        <!-- the || means if it's not correct -->
                        <input type="number" class="filters-price-input" min="0" step="1" onfocus="this.previousValue = this.value" onkeydown="this.previousValue = this.value" oninput="validity.valid || (value = this.previousValue)" id="filters_price_min" placeholder="Von"/>
                      </div>
                      <div class="col-xs-6 col-sm-6">
                        <input type="number" class="filters-price-input" min="0" step="1" onfocus="this.previousValue = this.value" onkeydown="this.previousValue = this.value" pattern="\d+" id="filters_price_max" placeholder="Bis"/>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-12">
                    <p class="filters-title">Zustand</p>
                    <div class="row padding-a-0 margin-a-0">
                    <?php
                    $condition_id = 0;
                    foreach($conditions as $condition){
                    ?>
                      <div class="col-xs-12 col-sm-12 margin-b-0">
                        <label class="checkbox-container">
                          <input class="checkbox" id="condition_<?php echo $condition_id ?>" type="checkbox">
                          <label id="condition_label_<?php echo $condition_id ?>" for="condition_<?php echo $condition_id ?>"><?php echo $condition ?></label>
                        </label>
                      </div>
                    <?php
                    $condition_id++;
                    }
                    ?>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-12">
                    <p class="filters-title">Ort</p>
                    <div class="row margin-a-0 padding-l-2">
                    <?php
                    $location_id = 0;
                    foreach($locations as $location){
                    ?>
                      <div class="col margin-t-2">
                        <label class="checkbox-container">
                          <input class="chip" id="location_<?php echo $location_id ?>" type="checkbox">
                          <label id="location_label_<?php echo $location_id ?>" for="location_<?php echo $location_id ?>"><?php echo $location ?></label>
                        </label>
                      </div>
                    <?php
                    $location_id++;
                    }
                    ?>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-12">
                    <button class="filters-apply-button text-uppercase clickable" onclick="applyFilters()">Anwenden</button>
                  </div>
                </div>

                <!-- <ul class="categories-list" id="categories-list">
                  <?php
                  foreach($categories as $category){
                  ?>
                  <li><a class="categories-item" href="/PortaPC/pages/products/category.php?category=<?php echo $category ?>"><?php echo $category ?></a></li>
                  <?php
                  }
                  ?>
                </ul> -->
            </div>
          </div>
        </div>

        <!-- Right side of the content -->
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 margin-a-0 padding-a-0">
          <div class="row">

            <div class="col-xs-12 col-sm-12">
              <p class="category-title text-uppercase">Anzeige</p>
            </div>

            <!-- Filters -->
            <div class="col-xs-12 col-sm-12">

              <div class="row padding-a-0 margin-a-0">
                <div class="col-xs-6 col-sm-6 col-md-3 margin-a-0 fill-height sorting-dropdown-container">
                  <div class="sorting-dropdown">
                    <p class='sorting-dropdown-text' id="sorting-dropdown-text"></p>
                    <div id="sorting-dropdown-content" class="sorting-dropdown-content">
                      <p id="sorting_filters_item" data-sort-by="default" data-sort-order="default" class="sorting-dropdown-item" onclick="handleSortingDropdownText('PortaPC präsentiert')">PortaPC präsentiert</p>
                      <p id="sorting_filters_item_0" data-sort-by="price" data-sort-order="asc" class="sorting-dropdown-item" onclick="handleSortingDropdownText('Preis (Aufsteigend)')">Preis (Aufsteigend)</p>
                      <p id="sorting_filters_item_1" data-sort-by="price" data-sort-order="desc" class="sorting-dropdown-item" onclick="handleSortingDropdownText('Preis (Absteigend)')">Preis (Absteigend)</p>
                      <p id="sorting_filters_item_2" data-sort-by="title" data-sort-order="asc" class="sorting-dropdown-item" onclick="handleSortingDropdownText('Title (Aufsteigend)')">Title (Aufsteigend)</p>
                      <p id="sorting_filters_item_3" data-sort-by="title" data-sort-order="desc" class="sorting-dropdown-item" onclick="handleSortingDropdownText('Title (Absteigend)')">Title (Absteigend)</p>
                      <p id="sorting_filters_item_4" data-sort-by="created_at" data-sort-order="asc" class="sorting-dropdown-item" onclick="handleSortingDropdownText('Datum (Aufsteigend)')">Datum (Aufsteigend)</p>
                      <p id="sorting_filters_item_5" data-sort-by="created_at" data-sort-order="desc" class="sorting-dropdown-item" onclick="handleSortingDropdownText('Datum (Absteigend)')">Datum (Absteigend)</p>
                    </div>
                  </div>
                </div>

                <!-- Number of products -->
                <div class="col fill-height align-self-center">
                  <p class="products-list-information-text"><?php echo $products_json->products_total_count ?> Anzeige


                <?php if($products_json->pages > 0){
                  ?>  •  <?php echo $page_current ?> von <?php echo $products_json->pages ?> Seiten</p>
                  </div>
                  <?php
                }
                ?>
              </div>
            </div>
            <!-- End of filters -->

            <?php if (sizeof($products) === 0){
              ?>
              <div class="col-xs-12 col-sm-12">
                <p class="products-empty-text">Leider haben wir keine Ergebnisse gefunden 😔</p>
              </div>
              <?php
            }
            ?>

            <?php

            foreach($products as $product){
              $id = $product->id;
              $title = $product->title;
              $images = $product->images;
              $price = $product->price;
              $category = $product->category;
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
            <?php if (sizeof($products) > 0){
              $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"] . "?";
              $page_first = 1;
              $page_last = $products_json->pages;
              $page_next = $page_current + 1;
              $page_previous = $page_current - 1;

              $has_next = $page_last >= $page_next;
              $has_previous = $page_previous >= 1;

              $queries = $_GET;

              $queries['page_current'] = $page_current;
              $queries_result = http_build_query($queries);
              $page_current_url = $current_url . $queries_result;

              $queries['page_current'] = $page_first;
              $queries_result = http_build_query($queries);
              $page_first_url = $current_url . $queries_result;

              $queries['page_current'] = $page_last;
              $queries_result = http_build_query($queries);
              $page_last_url = $current_url . $queries_result;

              $queries['page_current'] = $page_next;
              $queries_result = http_build_query($queries);
              $page_next_url = $current_url . $queries_result;

              $queries['page_current'] = $page_previous;
              $queries_result = http_build_query($queries);
              $page_previous_url = $current_url . $queries_result;
              ?>
              <!-- Page controller -->
              <div class="col-xs-12 col-sm-12">
                <div class="row margin-a-0 padding-a-0 justify-content-center">
                  <div class="col fill-height align-self-center">
                    <?php if($has_previous === false){
                      ?>
                      <a class="material-icons pagination-icon pagination-icon-disabled">first_page</a>
                      <?php
                    } else {
                      ?>
                      <a class="material-icons pagination-icon" href="<?php echo $page_first_url ?>">first_page</a>
                      <?php
                    }
                    ?>
                  </div>
                  <div class="col fill-height align-self-center">
                    <?php if($has_previous === false){
                      ?>
                      <a class="material-icons pagination-icon pagination-icon-disabled">navigate_before</a>
                      <?php
                    } else {
                      ?>
                      <a class="material-icons pagination-icon" href="<?php echo $page_previous_url ?>">navigate_before</a>
                      <?php
                    }
                    ?>
                  </div>

                  <div class="col fill-height align-self-center">
                    <a class="pagination-current-text" href="<?php echo $page_current_url ?>"><?php echo $page_current ?></a>
                  </div>

                  <div class="col fill-height align-self-center">
                    <?php if($has_next === false){
                      ?>
                      <a class="material-icons pagination-icon pagination-icon-disabled">navigate_next</a>
                      <?php
                    } else {
                      ?>
                      <a class="material-icons pagination-icon" href="<?php echo $page_next_url ?>">navigate_next</a>
                      <?php
                    }
                    ?>
                  </div>

                  <div class="col fill-height align-self-center">
                    <?php if($has_next === false){
                      ?>
                      <a class="material-icons pagination-icon pagination-icon-disabled">last_page</a>
                      <?php
                    } else {
                      ?>
                      <a class="material-icons pagination-icon" href="<?php echo $page_last_url ?>">last_page</a>
                      <?php
                    }
                    ?>
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

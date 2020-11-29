<?php
/*
We will use a Helper class in PHP to get our Json content.
If we use JavaScript, our Json file will be exposed.
We want to try our best to keep it a bit secure, even if it's not the best approach.

First, include the class once. We don't want any duplicated includes of the same file (prevent any conflicts)
*/
include_once("utilities/Helper.php");

// We then create an instance of our class
$helper = new Helper();

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

  <link type="text/css" rel="stylesheet" href="css/styles.css" media="screen,projection" />
  <script type="text/javascript" src="js/scripts.js"></script>
  <script type="text/javascript">
    var categories = <?php echo $helper -> getCategories() ?>;

    document.onreadystatechange = function() {
      if (document.readyState == "complete") {
        handleNavbar();
        handleScrollTop();
        populateSearchCategories(categories);
        handleSearchCategroyText(categories, null);
        populateDiscoverCategories(categories);
      }
    }
  </script>
  <!--
      <script type="text/javascript">
        // We will use JQuery
        // First, we check if the document is ready for any changes
        var categories = [];
        var category_selected = "Alle Kategorien";
        $(document).ready(function() {
          /*
          Dropdown should be ONLY initilized after the dynamic content is populated.
          This means: Add the item of the dropdown, then initilize it.

          */
          populateDropdown();
          // Log the message to let the developer know.
          console.log("The document is ready!");

          // initialize the dropdown (MaterializeCSS) using JQuery.
          $('.dropdown-trigger').dropdown();

          handleNavbar();

        });

        /*
        This function shows the navbar after we reached the page content block/div.
        We basically check what's the offset of the #homepage-content regarding the top of the whole document
        then we add an eventlistener using JQuery to the scroll event
        once we are past that offset (scrollTop() > offset)
        then we add the css class to show the navbar
        */
        function handleNavbar(){
          var offset = $("#homepage-content").offset().top;
          $(window).bind('scroll', function() {
            if ($(window).scrollTop() > offset) {
              $('#nav').addClass('nav-visible');
              $('#nav-container').addClass('nav-visible');
            }
            else {
             $('#nav').removeClass('nav-visible');
             $('#nav-container').removeClass('nav-visible');
            }
          });
        }

        // Create a function to add items to our categories
        function populateDropdown(){
          // Get the categories from our PHP helper
          // The encoded Json getCategories() will be parsed automatically to JSON
          categories = ?php echo $helper->getCategories()?>;


          // We now have an array, the "Alle Kategorien" option is NOT included in the categories
          // There are a lot of ways to do it, but... we will do it "hardcoded", which is a bad way
          // but already does the job for us :) Using "unshift()" method, we will add an element to the start of the array
          categories.unshift("Alle Kategorien");

          // Create a for-loop, then use JQuery to "append/add" the HTML to the div #searchbar-category
          for(let i = 0; i < categories.length; i++){
            let category = categories[i];
            let category_html = `<li><a onclick="setSearchbarCategoryText(${i})">${category}</a></li>`;
            $("#searchbar-category").append(category_html);
          }

        }

        // If there's a change in the selected dropdown, we need to change the text to that selected option
        function setSearchbarCategoryText(elementIndex){
          // We have the index
          // Get the category from the categories array using the passed parameter (index)
          category_selected = categories[elementIndex];
          // We got it? Nice, now, update the text using JQuery
          $("#searchbar-category-text").text(category_selected);
        }

        // Normal Javascript function to redirect the user using Javascript to a specific page
        // Paramter is a String
        function visitURL(urlName) {
          if (urlName === "homepage") {
            // The "location" of the current page should be redirected to the "slash /" which is
            // a shortcut for the root page of this website (basically from website.com/blabla/caca to website.com/)
            location.href = location.protocol + '//' + location.host + "/PortaPC";
          }
        }

        /*$(document).ready(function(){
        //Get the button:
        //var mybutton = $("#ScrollTopButton");

        // When the user scrolls down 20px from the top of the document, show the button
        $(function()  {
          $(window).scroll(function() {
            if ($(window).scrollTop() > 20)
            {
              $("#ScrollTopButton").fadeIn(200);
            }
            else
            {
              $("#ScrollTopButton").fadeOut(200);
            }
          });

          $("#ScrollTopButton").click(function()  {
            $('body,html').animate({scrollTop: 0}, 800);
          });
        });
      })*/
      </script>
    -->
</head>

<body>

  <!-- Navbar -->
  <!-- By default, the navbar is hidden -->
  <div class="navbar-fixed nav-default" id="nav-container">
    <nav class="nav-default" id="nav">
      <div class="nav-wrapper">
        <div class="website-logo" onclick="visitURL('homepage')" alt="Website-Logo"></div>
      </div>
    </nav>
  </div>

  <div class="container top-bar" id="top-bar">
    <div class="row">
      <!--Logo column-->
      <div class="col-sm-12 col-md-12 col-lg-2">
        <div class="website-logo" onclick="visitURL('homepage')" alt="Website-Logo"></div>
      </div>
      <!--End of Logo column-->

      <!--Search & Category parent-->
      <div class="col-sm-12 col-md-12 col-lg-10">

        <!--Search & Category row-->
        <div class="row search-container">

          <!--Search column-->
          <div class="col-sm-8 col-md-9 col-lg-9 fill-height margin-a-0">
            <div class="input-field margin-a-0 fill-height">

              <!--Search input-->
              <input class="search-input margin-y-0" placeholder="Wonach suchen Sie?" id="icon_prefix" type="text">
            </div>
          </div>
          <!--End of Search column-->

          <div class="col-sm-4 col-md-3 col-lg-3 margin-a-0 fill-height searchbar-category-container vertical-left-line">
              <p class='searchbar-category-dropdown' data-target='searchbar-category' id="searchbar-category-text">Alle Kategorien</p>
              <div class="categories-dropdown-content">
                <p class="categories-dropdown-item">Test</p>
                <p class="categories-dropdown-item">Test §2</p>
              </div>

          </div>
        </div>
        <!--End of Search & Categroy row-->

      </div>
      <!--End of Search & Category parent-->

    </div>
  </div>

  <main id="homepage-content" class="margin-t-4">
    <div class="container">
      <div class="row">

        <!-- Left side of the content -->
        <div class="col-sm-12 col-md-4 col-lg-3 margin-a-0 padding-a-0 padding-r-3">
          <div class="row">
            <!-- Category title -->
            <div class="col-sm-12">
              <p class="category-title text-uppercase"><strong>Entdecken</strong></p>
            </div>

            <!-- Category card -->
            <div class="col-sm-12">
              <div class="categories-container">
                <ul class="categories-list" id="categories-list">
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Right side of the content -->
        <div class="col-sm-12 col-md-8 col-lg-9 margin-a-0 padding-a-0">
          <div class="row">

            <div class="col-sm-12">
              <p class="category-title text-uppercase"><strong>Homepage</strong></p>
            </div>

            <!-- Slider placeholder -->
            <!-- TODO: Add an actual slider, currently it's a picture -->
            <div class="col-sm-12">
              <img class="placeholder-image" src="images/placeholders/slider.png"></img>
            </div>

            <div class="col-sm-12">
              <p class="category-title text-uppercase"><strong>Neueste Anzeige</strong></p>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="row">
                <!-- image part -->
                <div class="col-sm-12 margin-a-0 product-image-container">
                  <img src="images/placeholders/product.png" class="product-image"></img>
                  <div class="product-price-container">
                    <p class="product-price">€400</p>
                  </div>
                </div>

                <!-- title -->
                <div class="col-sm-12 margin-a-0 margin-t-3">
                  <p class="product-title">RTX 3090</p>
                </div>

                <!-- location -->
                <div class="col-sm-12 margin-a-0 margin-t-2">
                  <p class="product-location">Trier-Nord</p>
                </div>

              </div>

            </div>


          </div>
        </div>

        <div>
          <div class="col-sm-12 col-md-8 col-lg-9">
            <!-- TODO: Slider -->
            <!-- <div class="row">
                <div class="slideshow-container">
                  <div class="mySlides fade">
                    <div class="numbertext">1 / 3</div>
                    <img src="images/gpu.jpg">
                  </div>
                  <div class="mySlides fade">
                    <div class="numbertext">2 / 3</div>
                    <img src="images/gpu.jpg">
                  </div>
                  <div class="mySlides fade">
                    <div class="numbertext">3 / 3</div>
                    <img src="images/gpu.jpg">
                  </div>
                  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                  <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
                <br>
                <div style="text-align:center">
                  <span class="dot" onclick="currentSlide(1)"></span>
                  <span class="dot" onclick="currentSlide(2)"></span>
                  <span class="dot" onclick="currentSlide(3)"></span>
                </div>
              </div> -->


          </div>
        </div>
      </div>
  </main>

  <footer class="margin-t-4">
    <div class="container">
      <div class="row row-center">

        <div class="col-xs-12 padding-a-0 margin-a-0 margin-b-4">
          <div class="separator-line"></div>
        </div>

        <div class="col-xs-12 col-m-4 col-lg-4">
          <p class="footer-title">PortaPC</p>
          <p class="footer-content">Hier eine einfache, kurze Beschreibung von uns. Dies soll als eine zusammen fassung von diesem Projeckt sein.</p>
        </div>

        <div class="col-xs-12 col-m-2 col-lg-2">
          <p class="footer-title">Informationen</p>
          <p class="footer-content">Über uns</p>
          <p class="footer-content">Impressum</p>
          <p class="footer-content">AGB</p>
        </div>

        <div class="col-xs-12 col-m-2 col-lg-2 margin-a-0">
          <div class="row">
            <div class="col-xs-12">
              <p class="footer-title">Kontakt</p>
              <p class="footer-content">kontakt@portapc.de</p>
            </div>

            <div class="col-xs-12 ma-0">
              <p class="footer-title">Folge uns</p>
              <div class="row margin-t-2">
                <div class="col-xs margin-a-0 padding-a-0 margin-r-1">
                  <a href="#"><img class="footer-social-icon" src="images/footer/social_icons/facebook.svg" alt="Facebook"></a>
                </div>
                <div class="col-xs margin-a-0 padding-a-0 margin-x-1">
                  <a href="#"><img class="footer-social-icon" src="images/footer/social_icons/twitter.svg" alt="Twitter"></a>
                </div>
                <div class="col-xs margin-a-0 padding-a-0 margin-x-1">
                  <a href="#"><img class="footer-social-icon" src="images/footer/social_icons/instagram.svg" alt="Instagram"></a>
                </div>
                <div class="col-xs margin-a-0 padding-a-0 margin-x-1">
                  <a href="#"><img class="footer-social-icon" src="images/footer/social_icons/youtube.svg" alt="Youtube"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </footer>

  <button id="scroll-top-button" title="Nach oben scrollen">nach oben</button>

  <!-- <script type="text/javascript" src="js/slide.js"></script> -->
</body>

</html>

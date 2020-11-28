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
<<<<<<< HEAD
    <link type="text/css" rel="stylesheet" href="css/card.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/grid.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/header.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/footer.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/main.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/slide.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/scrolltop.css" media="screen,projection" />
=======

>>>>>>> 463dfccdc9a9435bdaf9dae2879dc3ae0fe7fa4b
    <link type="text/css" rel="stylesheet" href="css/styles.css" media="screen,projection" />
    <script type="text/javascript">
    categories = <?php echo $helper->getCategories()?>;

    function visitURL(urlName) {
      if (urlName === "homepage") {
        // The "location" of the current page should be redirected to the "slash /" which is
        // a shortcut for the root page of this website (basically from website.com/blabla/caca to website.com/)
        location.href = location.protocol + '//' + location.host + "/PortaPC";
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
    <header>
      <div class="container top-bar" id="top-bar">
        <div class="row">
          <!--Logo column-->
          <div class="col-s-12 col-m-12 col-l-3">
            <div class="website-logo" onclick="visitURL('homepage')" alt="Website-Logo"></div>
          </div>
          <!--End of Logo column-->

          <!--Search & Category parent-->
          <div class="col-s-12 col-m-12 col-l-9">

            <!--Search & Category row-->
            <div class="row search-container">

              <!--Search column-->
              <div class="col-s-8 col-m-9 col-l-9 fill-height">
                <div class="input-field margin-0 fill-height">

                  <!--Search input-->
                  <input class="search-input margin-y-0" placeholder="Wonach suchen Sie?" id="icon_prefix" type="text">
                </div>
              </div>
              <!--End of Search column-->

              <div class="col-s-4 col-m-3 col-l-3 vertical-left-line">
                <select class='dropdown-trigger searchbar-category-dropdown' data-target='searchbar-category' id="searchbar-category-text">
                   <option value="Alle Kategorien">Alle Kategorien</option>
                   <option value="GPUs">GPUs</option>
                   <option value="CPUs">CPUs</option>
                   <option value="Motherboards">Motherboards</option>
                   <option value="Netzteile">Netzteile</option>
                   <option value="Arbeitsspeicher">Arbeitsspeicher</option>
                   <option value="Peripheriegeräte">Peripheriegeräte</option>
                   <option value="Komplettsysteme">Komplettsysteme</option>
                </select>
                 <!--It's going to be a dynamic dropdown, the content will be added using JavaScript-->
                <ul id='searchbar-category' class='dropdown-content'>
                </ul>
              </div>
            </div>
            <!--End of Search & Categroy row-->

          </div>
          <!--End of Search & Category parent-->

        </div>
      </div>
    </header>

    <main>
      <div class="container">
        <div class="row">
          <div class="col-s-12 col-m-4 col-l-3 categories">
            <h3 class="category-header"><strong>Entdecken</strong></h3>
            <ul>
              <li><a class="category-content" href="#!">Alle Katergorien</a></li>
              <li><a class="category-content" href="#!">CPUs</a></li>
              <li><a class="category-content" href="#!">GPUs</a></li>
              <li><a class="category-content" href="#!">Motherboards</a></li>
              <li><a class="category-content" href="#!">Netzteile</a></li>
              <li><a class="category-content" href="#!">RAMs</a></li>
              <li><a class="category-content" href="#!">Speicher</a></li>
              <li><a class="category-content" href="#!">Peripheriegerate</a></li>
              <li><a class="category-content" href="#!">Komplettsysteme</a></li>
              <li></li>
            </ul>
          </div>

          <div>
            <div class="col-s-12 col-m-8 col-l-9">
              <div class="row">
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
              </div>

              <div class="row">
                <div class="col-s-6 col-m-4 col-l-3">
                  <div class="card">
                    <div class="card-image">
                      <img class="activator" src="images/gpu.jpg">
                      <button id="PreisButton" title="preis">900€</button>
                    </div>
                    <div class="card-content">
                      <h4><strong>Nvidia RTX 3090</strong></h4>
                      <p>Ehrang</p>
                    </div>
                  </div>
                </div>

                <div class="col-s-6 col-m-4 col-l-3">
                  <div class="card">
                    <div class="card-image">
                      <img class="activator" src="images/gpu.jpg">
                      <button id="PreisButton" title="preis">900€</button>
                    </div>
                    <div class="card-content">
                      <h4><strong>Nvidia RTX 3090</strong></h4>
                      <p>Ehrang</p>
                    </div>
                  </div>
                </div>

              </div>

              <div class="row">
                <div class="col">
                  <h3 style="text-transform:uppercase "><strong>Neuste Anzeigen</strong></h3>
                </div>
              </div>

              <div class="row">
                <div class="col-s-6 col-m-4 col-l-3">
                  <div class="card">
                    <div class="card-image">
                      <img class="activator" src="images/gpu.jpg">
                      <button id="PreisButton" title="preis">900€</button>
                    </div>
                    <div class="card-content">
                      <h4><strong>Nvidia RTX 3090</strong></h4>
                      <p>Ehrang</p>
                    </div>
                  </div>
                </div>

                <div class="col-s-6 col-m-4 col-l-3">
                  <div class="card">
                    <div class="card-image">
                      <img class="activator" src="images/gpu.jpg">
                      <button id="PreisButton" title="preis">900€</button>
                    </div>
                    <div class="card-content">
                      <h4><strong>Nvidia RTX 3090</strong></h4>
                      <p>Ehrang</p>
                    </div>
                  </div>
                </div>
              </div>


              <div class="row">
                <button onclick="#!" id="more" title="View more">Mehr anzeigen</button>
              </div>

          </div>
        </div>
      </div>
    </main>

    <footer>
      <div class="separator-line">
      </div>

      <div class="container">
        <div class="row">
          <div class="col-l-6 col-m-12 col-s-12">
            <h3 class="header">PortaPC</h3>
            <p class="content">Hier eine einfache, kurze Beschreibung von uns. Dies soll als eine zusammen fassung von diesem Projeckt sein.</p>
          </div>

          <div class="col-l-3 col-m-6 col-s-12">
            <h3 class="header">Informationen</h3>
            <ul>
              <li><a class="content" href="#!">Über uns</a></li>
              <li><a class="content" href="pages/informationen/impressium.html">Imrepssium</a></li>
              <li><a class="content" href="#!">Datenschutzerklärung</a></li>
              <li><a class="content" href="pages/informationen/agb.html">AGB</a></li>
              <li><a class="content" href="#!">DSGVO</a></li>
            </ul>
          </div>

          <div class="col-l-3 col-m-6 col-s-12">
            <h3 class="header">Kontakt</h3>
            <ul>
              <li><a class="content" href="mailto:kontakt@portapc.de">kontakt@portapc.de</a></li>
            </ul>

            <h3 class="header">Folge uns</h3>

            <div class="row">
              <div class="col-l-1 col-m-1 col-s-1">
                <a href="index.html"><img src="images/footer/social_icons/facebook.png" style="max-width:20px"></a>
              </div>

              <div class="col-l-1 col-m-1 col-s-1">
                <a href="index.html"><img src="images/footer/social_icons/instagram.png" style="max-width:20px"></a>
              </div>

              <div class="col-l-1 col-m-1 col-s-1">
                <a href="index.html"><img src="images/footer/social_icons/snapchat.png" style="max-width:20px"></a>
              </div>

              <div class="col-l-1 col-m-1 col-s-1">
                <a href="index.html"><img src="images/footer/social_icons/whatsapp.png" style="max-width:20px"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <button onclick="topFunction()" id="ScrollTopButton" title="nach oben">nach oben</button>

    <script type="text/javascript" src="js/slide.js"></script>
    <script type="text/javascript" src="js/scrolltop.js"></script>
  </body>
</html>

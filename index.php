<?php

// We Setup the php enivornment for later usage.
// Currently, we don't need to add anything.

?>

<!DOCTYPE html>
<html>

<head>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <!-- TODO: minify materialize.css after the needed changes -->
  <link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection" />
  <!--Import styles.css (our own custom css)-->
  <link type="text/css" rel="stylesheet" href="css/styles.css" media="screen,projection" />
  <!-- Import JQuery at the start, we need it in our script headtags -->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <!--Let browser know that the website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>PortaPC</title>

  <script type="text/javascript">
    // We will use JQuery
    // First, we check if the document is ready for any changes
    $(document).ready(function() {
      // Log the message to let the developer know.
      console.log("The document is ready!");

      // initialize the dropdown (MaterializeCSS) using JQuery.
      $('.dropdown-trigger').dropdown();


    });

    // Normal Javascript function to redirect the user using Javascript to a specific page
    // Paramter is a String
    function visitURL(urlName){
      if(urlName === "homepage"){
        // The "location" of the current page should be redirected to the "slash /" which is
        // a shortcut for the root page of this website (basically from website.com/blabla/caca to website.com/)
        location.href = "/";
      }
    }
  </script>
</head>

<body>

  <!-- Navbar goes here -->
  <header class="header">
    <div class="container">
      <div class="row">
        <div class="col s12 m12 l3">
            <div class="website-logo" onclick="visitURL('homepage')" alt="Website-Logo"></div>
        </div>
        <div class="col s12 m12 l7">
          <div class="row search-container">
            <div class="col s12 m12 l10">
              <div class="input-field margin-0">
                <i class="material-icons prefix">account_circle</i>
                <input class="search-input margin-y-0" placeholder="Placeholder" id="icon_prefix" type="text">
              </div>
            </div>
            <div class="col s12 m12 l2 vertical-line">
              <p class='dropdown-trigger' data-target='dropdown1'>Drop Me!</p>

              <!-- Dropdown Structure -->
              <ul id='dropdown1' class='dropdown-content'>
                <li><a href="#!">one</a></li>
                <li><a href="#!">two</a></li>
                <li class="divider" tabindex="-1"></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Navbar ends here -->

  <!-- Page content goes here -->
  <main>
    <div class="container">
      <div class="row">

        <!-- Katorgie goes here -->
        <div class="col s3">
          <h5 style="text-transform:uppercase "><strong>Entdecken</strong></h5>
          <ul class="collection section">
            <li href="#!" class="collection-item">Alle Katergorien</li>
            <li href="#!" class="collection-item">CPUs</li>
            <li href="#!" class="collection-item">GPUs</li>
            <li href="#!" class="collection-item">Motherboards</li>
            <li href="#!" class="collection-item">Netzteile</li>
            <li href="#!" class="collection-item">RAMs</li>
            <li href="#!" class="collection-item">Speicher</li>
            <li href="#!" class="collection-item">Peripheriegerate</li>
            <li href="#!" class="collection-item">Komplettsysteme</li>
          </ul>

        </div>
        <!-- Katorgie ends here -->

        <!-- Slider goes here -->
        <div class="col s9 right">
          <div class="row">
            <div class="col s12">
              <div class="slideshow-container">
                <div class="mySlides fade">
                  <div class="numbertext">1 / 3</div>
                  <img src="images/gpu.jpg" style="width:100%; height:200px; object-fit:cover">
                </div>
                <div class="mySlides fade">
                  <div class="numbertext">2 / 3</div>
                  <img src="images/cpu.png" style="width:100%; height:200px; object-fit:cover">
                </div>
                <div class="mySlides fade">
                  <div class="numbertext">3 / 3</div>
                  <img src="images/motherboard.png" style="width:100%; height:200px; object-fit:cover">
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
            </div>
          <!-- Slider ends here -->

          <!-- Posts goes here -->
          <div class="row">

            <!-- 1st Style with Card reveal -->
            <div class="col s3">
              <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                  <img class="activator" src="images/gpu.jpg">
                </div>
                <div class="card-content">
                  <span class="card-title activator grey-text text-darken-4">RTX 3090</span>
                </div>
                <div class="card-reveal">
                  <span class="card-title grey-text text-darken-4">RTX 3090<i class="material-icons right">close</i></span>
                  <p>300$</p>
                  <p><a href="#">Details</a></p>
                </div>
              </div>
            </div>

            <!-- 2nd Style without Card reveal -->
            <div class="col s3">
              <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                  <a href="#!"><img src="images/gpu.jpg"></a>
                </div>
                <div class="card-content">
                  <a href="#!"style="color:black"><span class="card-title grey-text text-darken-4">RTX 3090</span></a>
                </div>
              </div>
            </div>

            <!-- 3rd Style with link -->
            <div class="col s3">
              <div class="card">
                <div class="card-image">
                  <a href="#!"><img src="images/gpu.jpg"></a>
                </div>
                <div class="card-content">
                  <a href="#!" style="color:black"><p>RTX 3090</p></a>
                </div>
              </div>
            </div>

            <!-- Original Style -->
            <div class="col s3">
              <div class="card">
                <div class="card-image">
                  <a href="#!"><img src="images/gpu.jpg"></a>
                </div>
                <div class="card-content">
                  <p>RTX 3090</p>
                </div>
              </div>
            </div>

          </div>
          <!-- Posts goes here -->


            <!-- Neuste Anzeigen goes here -->
            <div class="row">
              <div class="col s12">
                <h5 style="text-transform:uppercase "><strong>Neuste Anzeigen</strong></h5>
              </div>


            </div>

            <div class="row">
              <div class="col s3">
                <div class="card">
                  <div class="card-image">
                    <a href="#!"><img src="images/gpu.jpg"></a>
                    <!--<span class="card-title">RTX 3090</span>-->
                  </div>
                  <div class="card-content">
                    <p>RTX 3090</p>
                  </div>
                </div>
              </div>

              <div class="col s3">
                <div class="card">
                  <div class="card-image">
                    <a href="#!"><img src="images/gpu.jpg"></a>
                    <!--<span class="card-title">RTX 3090</span>-->
                  </div>
                  <div class="card-content">
                    <p>RTX 3090</p>
                  </div>
                </div>
              </div>

              <div class="col s3">
                <div class="card">
                  <div class="card-image">
                    <a href="#!"><img src="images/gpu.jpg"></a>
                    <!--<span class="card-title">RTX 3090</span>-->
                  </div>
                  <div class="card-content">
                    <p>RTX 3090</p>
                  </div>
                </div>
              </div>

              <div class="col s3">
                <div class="card">
                  <div class="card-image">
                    <a href="#!"><img src="images/gpu.jpg"></a>
                    <!--<span class="card-title">RTX 3090</span>-->
                  </div>
                  <div class="card-content">
                    <p>RTX 3090</p>
                  </div>
                </div>
              </div>

              <div class="col s3">
                <div class="card">
                  <div class="card-image">
                    <a href="#!"><img src="images/gpu.jpg"></a>
                    <!--<span class="card-title">RTX 3090</span>-->
                  </div>
                  <div class="card-content">
                    <p>RTX 3090</p>
                  </div>
                </div>
              </div>

              <div class="col s3">
                <div class="card">
                  <div class="card-image">
                    <a href="#!"><img src="images/gpu.jpg"></a>
                    <!--<span class="card-title">RTX 3090</span>-->
                  </div>
                  <div class="card-content">
                    <p>RTX 3090</p>
                  </div>
                </div>
              </div>

              <div class="col s3">
                <div class="card">
                  <div class="card-image">
                    <a href="#!"><img src="images/gpu.jpg"></a>
                    <!--<span class="card-title">RTX 3090</span>-->
                  </div>
                  <div class="card-content">
                    <p>RTX 3090</p>
                  </div>
                </div>
              </div>

              <div class="col s3">
                <div class="card">
                  <div class="card-image">
                    <a href="#!"><img src="images/gpu.jpg"></a>
                    <!--<span class="card-title">RTX 3090</span>-->
                  </div>
                  <div class="card-content">
                    <p>RTX 3090</p>
                  </div>
                </div>
              </div>

            </div>
            <!-- Neuste Anzeigen ends here -->

            <div class="row center">
              <div>
                <a class="waves-effect waves-light btn" style="text-transform:none">Mehr anzeigen</a>
              </div>
            </div>

          </div>



        </div>

      </div>
    </div>


  </main>
  <!-- Page content ends here -->

  <!-- Footer goes here -->
  <footer class="page-footer white">
    <div class="container">
      <div class="row">
        <div class="col s1">

        </div>

        <div class="col s5">
          <h5 class="black-text">PortaPC</h5>
          <p class="grey-text">Hier eine einfache, kurze Beschreibung von uns. <br>Dies soll als eine zusammen fassung von diesem Projeckt sein.</p>
        </div>

        <div class="col s3">
          <h5 class="black-text">Informationen</h5>
          <ul>
            <li><a class="grey-text" href="#!">Über uns</a></li>
            <li><a class="grey-text" href="pages/informationen/impressium.html">Imrepssium</a></li>
            <li><a class="grey-text" href="#!">Datenschutzerklärung</a></li>
            <li><a class="grey-text" href="pages/informationen/agb.html">AGB</a></li>
            <li><a class="grey-text" href="#!">DSGVO</a></li>
          </ul>
        </div>

        <div class="col s3">
          <h5 class="black-text">Kontakt</h5>
          <ul>
            <li><a class="email grey-text" href="mailto:kontakt@portapc.de">kontakt@portapc.de</a></li>
          </ul>

          <h5 class="black-text">Folge uns</h5>

          <div class="row">
            <div class="col s1">
              <a href="index.html"><img src="images/footer/social_icons/facebook.png" style="max-width:20px"></a>
            </div>

            <div class="col s1">
              <a href="index.html"><img src="images/footer/social_icons/instagram.png" style="max-width:20px"></a>
            </div>

            <div class="col s1">
              <a href="index.html"><img src="images/footer/social_icons/snapchat.png" style="max-width:20px"></a>
            </div>

            <div class="col s1">
              <a href="index.html"><img src="images/footer/social_icons/whatsapp.png" style="max-width:20px"></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Footer ends here -->


  <!--Import the minified script of materialize.js (materilize.min.js)-->
  <script src="js/materialize.js"></script>
  <script src="js/slider.js"></script>
</body>

</html>

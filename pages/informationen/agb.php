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
  <title>AGB</title>
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
                  <li><a class="categories-item" href="/PortaPC/pages/informationen/about_us.php">Über uns</a></li>
                  <li><a class="categories-item categories-item-selected" href="/PortaPC/pages/informationen/agb.php">AGB</a></li>
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
              <p class="category-title text-uppercase">Allgemeine Geschäftsbedingungen der Firma PortaPc</p>
            </div>

            <div class="col-xs-12">
              <p class="text-subtitle text-weight-medium">§1 Geltung gegenüber Unternehmern und Begriffsdefinitionen</p>
              </br>
              <p class="text-body-1 text-weight-regular">(1) Die nachfolgenden Allgemeinen Geschäftbedingungen gelten für alle Lieferungen zwischen uns und einem Verbraucher in ihrer zum Zeitpunkt der Bestellung gültigen Fassung.
                <br><br>
                Verbraucher ist jede natürliche Person, die ein Rechtsgeschäft zu Zwecken abschließt, die überwiegend weder ihrer gewerblichen noch ihrer selbständigen beruflichen Tätigkeit zugerechnet werden können (§ 13 BGB).
              </p>
              <br></br>
              <p class="text-subtitle text-weight-medium">§2 Zustandekommen eines Vertrages, Speicherung des Vertragstextes</p>
              </br>
              <p class="text-body-1 text-weight-regular">(1) Die folgenden Regelungen über den Vertragsabschluss gelten für Bestellungen über unseren Internetshop http://www.portapc.de.
                <br></br>
                (2) Im Falle des Vertragsschlusses kommt der Vertrag mit:<br>
                PortaPC<br>
                Hochschule Trier<br>
                Schneidershof<br>
                D-54293 Trier<br>
                Registernummer XXXXXXXX<br>
                Registergericht Amtsgericht Trier<br>
                zustande.<br>
                <br>
                (3) Die Präsentation der Waren in unserem Internetshop stellen kein rechtlich bindendes Vertragsangebot unsererseits dar, sondern sind nur eine unverbindliche Aufforderungen an den Verbraucher, Waren zu bestellen. Mit der Bestellung
                der gewünschten Ware gibt der Verbraucher ein für ihn verbindliches Angebot auf Abschluss eines Kaufvertrages ab.
                <br><br>
                (4) Bei Eingang einer Bestellung in unserem Internetshop gelten folgende Regelungen: Der Verbraucher gibt ein bindendes Vertragsangebot ab, indem er die in unserem Internetshop vorgesehene Bestellprozedur erfolgreich durchläuft.
                <br><br>
                Die Bestellung erfolgt in folgenden Schritten:
                <br><br>
                1) Auswahl der gewünschten Ware.<br>
                2) Bestätigen durch Anklicken der Buttons „Bestellen“.<br>
                3) Prüfung der Angaben in der Anfrageformular.<br>
                4) Betätigung des Buttons „Abschicken“<br>
                5) Erhalten der Bestätigung der Anfrage.<br>
                6) Nochmalige Prüfung bzw. Bestätigung der jeweiligen eingegebenen Daten.<br>
                7) Überweisung von Kosten der Bestellung, welche dann automatisch behandelt wird.
                <br><br>
                Der Verbraucher kann vor dem verbindlichen Absenden der Bestellung durch Betätigen der in dem von ihm verwendeten Internet-Browser enthaltenen „Zurück“-Taste nach Kontrolle seiner Angaben wieder zu der Internetseite gelangen, auf der
                die Angaben des Kunden erfasst werden und Eingabefehler berichtigen bzw. durch Schließen des Internetbrowsers den Bestellvorgang abbrechen. Wir bestätigen den Eingang der Bestellung unmittelbar durch eine automatisch generierte E-Mail
                („Auftragsbestätigung“). Mit dieser nehmen wir Ihr Angebot an.
                <br><br>
                (5) Speicherung des Vertragstextes bei Bestellungen über unseren Internetshop : Wir senden Ihnen die Bestelldaten und unsere AGB per E-Mail zu. Die AGB können Sie jederzeit auch unter http://www.portapc.de/PortaPC/pages/informationen/agb
                einsehen. Ihre Bestelldaten sind aus Sicherheitsgründen nicht mehr über das Internet zugänglich.
                <br><br>
              </p>
              <p class="text-subtitle text-weight-medium">§3 Preise, Versandkosten, Zahlung, Fälligkeit</p>
              <br>
              <p class="text-body-1 text-weight-regular">
                (1) Die angegebenen Preise enthalten die gesetzliche Umsatzsteuer und sonstige Preisbestandteile. Hinzu kommen etwaige Versandkosten.
                <br></br>
                (2) Der Verbraucher hat die Möglichkeit der Zahlung per Bankeinzug, PayPal, Kreditkarte( Visa ) .
                <br></br>
              </p>
              <p class="text-subtitle text-weight-medium">§4 Lieferung</p>
              <br>
              <p class="text-body-1 text-weight-regular">
                (1) Sofern wir dies in der Produktbeschreibung nicht deutlich anders angegeben haben, sind alle von uns angebotenen Artikel sofort versandfertig. Die Lieferung erfolgt hier spätesten innerhalb von 5 Werktagen. Dabei beginnt die Frist
                für die Lieferung im Falle der Zahlung per Vorkasse am Tag nach Zahlungsauftrag an die mit der Überweisung beauftragte Bank und bei allen anderen Zahlungsarten am Tag nach Vertragsschluss zu laufen. Fällt das Fristende auf einen
                Samstag, Sonntag oder gesetzlichen Feiertag am Lieferort, so endet die Frist am nächsten Werktag.
                <br><br>
                (2) Die Gefahr des zufälligen Untergangs und der zufälligen Verschlechterung der verkauften Sache geht auch beim Versendungskauf erst mit der Übergabe der Sache an den Käufer auf diesen über.
                <br><br>
              </p>
              <p class="text-subtitle text-weight-medium">§5 Eigentumsvorbehalt</p>
              <br>
              <p class="text-body-1 text-weight-regular">
                Wir behalten uns das Eigentum an der Ware bis zur vollständigen Bezahlung des Kaufpreises vor.
              </p>
              <br><br>
              <p class="text-subtitle text-weight-medium">§6 Widerrufsrecht des Kunden als Verbraucher</p>
              <br>
              <p class="text-body-1 text-weight-regular">
              Widerrufsrecht für Verbraucher
              <br><br>
              Verbrauchern steht ein Widerrufsrecht nach folgender Maßgabe zu, wobei Verbraucher jede natürliche Person ist, die ein Rechtsgeschäft zu Zwecken abschließt, die überwiegend weder ihrer gewerblichen noch ihrer selbständigen beruflichen
              Tätigkeit zugerechnet werden können:
              <br><br>
              <p class="text-body-2">Widerrufsbelehrung</p>
              <br>
              <p class="text-body-2">Widerrufsrecht</p>
              Sie haben das Recht, binnen vierzehn Tagen ohne Angabe von Gründen diesen Vertrag zu widerrufen.
              Die Widerrufsfrist beträgt vierzehn Tage, ab dem Tag des Vertragsabschlusses.
              <br><br>
              Um Ihr Widerrufsrecht auszuüben, müssen Sie uns<br>
              PortaPC<br>
              Hochschule Trier<br>
              Schneidershof<br>
              D-54293 Trier<br>
              E-Mail widerruft@portapc.de<br>
              mittels einer eindeutigen Erklärung (z.B. ein mit der Post versandter Brief, Telefax oder E-Mail) über Ihren Entschluss, diesen Vertrag zu widerrufen, informieren. Sie können dafür das beigefügte Muster-Widerrufsformular verwenden, das jedoch nicht vorgeschrieben ist. <br>
              <br>
              Zur Wahrung der Widerrufsfrist reicht es aus, dass Sie die Mitteilung über die Ausübung des Widerrufsrechts vor Ablauf der Widerrufsfrist absenden.
              <br><br>
              <p class="text-body-2">Widerrufsfolgen</p>
              Wenn Sie diesen Vertrag widerrufen, haben wir Ihnen alle Zahlungen, die wir von Ihnen erhalten haben, einschließlich der Lieferkosten (mit Ausnahme der zusätzlichen Kosten, die sich daraus ergeben, dass Sie eine andere Art der Lieferung als die von uns angebotene, günstigste Standardlieferung gewählt haben), unverzüglich und spätestens binnen vierzehn Tagen ab dem Tag zurückzuzahlen, an dem die Mitteilung über Ihren Widerruf dieses Vertrags bei uns eingegangen ist. Für diese Rückzahlung verwenden wir dasselbe Zahlungsmittel, das Sie bei der ursprünglichen Transaktion eingesetzt haben, es sei denn, mit Ihnen wurde ausdrücklich etwas anderes vereinbart; in keinem Fall werden Ihnen wegen dieser Rückzahlung Entgelte berechnet.
              <br><br>
              Haben Sie verlangt, dass die Dienstleistungen während der Widerrufsfrist beginnen soll, so haben Sie uns einen angemessenen Betrag zu zahlen, der dem Anteil der bis zu dem Zeitpunkt, zu dem Sie uns von der Ausübung des Widerrufsrechts
              hinsichtlich dieses Vertrags unterrichten, bereits erbrachten Dienstleistungen im Vergleich zum Gesamtumfang der im Vertrag vorgesehenen Dienstleistungen entspricht.
              <br><br>
              Ende der Widerrufsbelehrung
              </p>
              <br>
              <p class="text-subtitle text-weight-medium">§7 Widerrufsformular</p>
              <br>
              <p class="text-body-1 text-weight-regular">
                Muster-Widerrufsformular
                <br>
                (Wenn Sie den Vertrag widerrufen wollen, dann füllen Sie bitte dieses Formular aus und senden Sie es zurück.)<br>
                An:<br>
                PortaPC<br>
                Hochschule Trier<br>
                Schneidershof<br>
                D-54293 Trier<br>
                E-Mail widerruf@portapc.de<br>
                <br>
                Hiermit widerrufe(n) ich/wir (*) den von mir/uns (*) abgeschlossenen Vertrag über den Kauf der folgenden Waren (*)/die Erbringung der folgenden Dienstleistung (*):
                <br>
                Bestellt am (*)/erhalten am (*):
                <br>
                Name des/der Verbraucher(s):
                <br>
                Anschrift des/der Verbraucher(s):
                <br>
                Unterschrift des/der Verbraucher(s) (nur bei Mitteilung auf Papier):
                <br>
                Datum:
                <br><br>
                (*) Unzutreffendes streichen.
              </p>
              <br>
              <p class="text-subtitle text-weight-medium">§8 Gewährleistung</p>
              <br>
              <p class="text-body-1 text-weight-regular">Es gelten die gesetzlichen Gewährleistungsregelungen.</p>

              <p class="text-subtitle text-weight-medium">§9 Verhaltenskodex</p>
              <p class="text-body-1 text-weight-regular">
                Wir haben uns den Verhaltenskodizes der folgenden Einrichtungen unterworfen:<br>
                Euro-Label Germany<br>
                EHI-EuroHandelsinstitut GmbH<br>
                Spichernstraße 55<br>
                50672 Köln<br>
                Den Euro-Label Verhaltenskodex können Sie durch Anklicken des auf unserer Webseite angebrachten Euro-Label-Siegels oder unter http://www.euro-label.com abrufen. <br>
                <br>
                und<br>
                <br>
                Trusted Shops GmbH<br>
                Colonius Carré<br>
                Subbelrather Straße 15c<br>
                50823 Köln<br>
                Den Trusted Shops Verhaltenskodex können Sie durch Anklicken des auf unserer Webseite angebrachten Trusted-Shops-Siegels oder unter www.trustedshops.de abrufen.<br>
              </p>
              <br>
              <p class="text-subtitle text-weight-medium">§10 Vertragssprache</p>
              <br>
              <p class="text-body-1 text-weight-regular">Als Vertragssprache steht ausschließlich Deutsch zur Verfügung.</p>
              <br>
              <p class="text-subtitle text-weight-medium">§11 Kundendienst</p>
              <br>
              <p class="text-body-1 text-weight-regular">Unser Kundendienst für Fragen, Reklamationen und Beanstandungen steht Ihnen werktags von 9:00 Uhr bis 17:30 Uhr unter
              <br><br>
              Telefon: 0151 123456789<br>
              Telefax: 0151 123456789<br>
              E-Mail: kontakt@portapc.de<br>
              zur Verfügung.</p>
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

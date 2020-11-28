// Custom scripts

function handleNavbar() {
  var offset = $("#homepage-content").offset().top;
  $(window).bind('scroll', function() {
    if ($(window).scrollTop() > offset) {
      $('#nav').addClass('nav-visible');
      $('#nav-container').addClass('nav-visible');
    } else {
      $('#nav').removeClass('nav-visible');
      $('#nav-container').removeClass('nav-visible');
    }
  });
}

function visitURL(urlName) {
  if (urlName === "homepage") {
    // The "location" of the current page should be redirected to the "slash /" which is
    // a shortcut for the root page of this website (basically from website.com/blabla/caca to website.com/)
    location.href = location.protocol + '//' + location.host + "/PortaPC";
  }
}

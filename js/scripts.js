// Custom scripts

function handleNavbar() {
  window.onscroll = function() {
    let element_offset = document.getElementById("homepage-content");
    let offset_top = element_offset.getBoundingClientRect().top;
    let window_scroll_position = window.pageYOffset;

    let element_nav = document.getElementById("nav");
    let element_nav_container = document.getElementById("nav-container");


    if (window_scroll_position > offset_top) {
      element_nav.classList.add("nav-visible");
      element_nav_container.classList.add("nav-visible");
    } else {
      element_nav.classList.remove("nav-visible");
      element_nav_container.classList.remove("nav-visible");
    }
  }

}

function visitURL(urlName) {
  if (urlName === "homepage") {
    // The "location" of the current page should be redirected to the "slash /" which is
    // a shortcut for the root page of this website (basically from website.com/blabla/caca to website.com/)
    location.href = location.protocol + '//' + location.host + "/PortaPC";
  }
}

// Custom scripts
function ajax_example() {
  let xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
      if (xmlhttp.status == 200) {
        // the response is successful
        response_json = JSON.parse(xmlhttp.responseText);
      } else {
        // response wasn't successful, log this into the console
        console.log(`Response received with status ${xmlhttp.status}`);
      }
    }
  };
  // parameter is "request_type" with the value "overview"
  xmlhttp.open("GET", "../utilities/ajax_helper.php?request_type=overview", true);
  xmlhttp.send();
}

function handleSearch(element) {
  // Input was "entered", which means, a search query needs to be executed
  // we can basically redirect the user to the search page with a parameter for the search query
  if (event.key === 'Enter') {
    let search = element.value;
    let category = document.getElementById("searchbar-category-text").innerHTML;
    let current_url = window.location.href;
    let future_url;
    // let's imagine that we are in the pages/products/category.php page, what if there's already a search?
    // therefore, we get the url of the page, check if we are in that page
    // then we change the search parameter, or ADD it if it doesn't exist
    // otherwise, we just visit the page normally
    if (current_url.includes("category.php")) {
      // get the ?query=blabla&query2=blablabla string
      let queryString = window.location.search;
      // check if the page has any parameters
      if (queryString) {
        // parse it
        let urlParams = new URLSearchParams(queryString);
        // check if it has the search
        if (urlParams.has("search")) {
          // it does, we need to change it
          // the best approach is to build the url again
          // then we add the parameter manually
          urlParams.set("search", search);
          future_url = location.protocol + '//' + location.host + location.pathname + urlParams.toString();
        } else {
          // it doesn't, just add search to it
          future_url = current_url + `&search=${search}`;
        }
      } else {
        // it doesn't, just add search query and category query then
        future_url = `${location.protocol}//${location.host}/pages/products/category.php?search=${search}&category=${category}`;
      }
    } else {
      future_url = `${location.protocol}//${location.host}/pages/products/category.php?search=${search}&category=${category}`;
    }
    visitURL(future_url, false);
  }
}

var slide_index_last = 0;

function handleSlider(slide_index_new) {
  // get the slides and the dots
  var slider_slides = document.getElementsByClassName("slide");
  var slider_dots = document.getElementsByClassName("slide-dot");

  // check if our index is correct
  // if it's negativ, then we are going previous => give him the last slide
  if (slide_index_new < 0) {
    slide_index_new = slider_slides.length - 1;
  }

  // transform the index to a human-readerable, because the length is a human-readerable format and it starts with 1, not with 0 like the index
  // if it's over the length, then reset
  if ((slide_index_new + 1) > slider_slides.length) {
    slide_index_new = 0;
  }

  // set the active dot and remove all the active class of other dots
  slider_dots[slide_index_new].classList.add("slide-dot-active");
  for (let i = 0; i < slider_dots.length; i++) {
    if (i !== slide_index_new) {
      slider_dots[i].classList.remove("slide-dot-active");
    }
  }

  // do the same for the slider
  slider_slides[slide_index_new].classList.add("slide-active");
  for (let i = 0; i < slider_slides.length; i++) {
    if (i !== slide_index_new) {
      slider_slides[i].classList.remove("slide-active");
    }
  }

  slide_index_last = slide_index_new;
}

function applySlider(slide_index_new, is_change) {
  if (is_change) {
    handleSlider(slide_index_last += slide_index_new);
  } else {
    handleSlider(slide_index_last = slide_index_new);
  }
}

// categories are given by the php file
function handleSearchCategoryList() {
  let element_categories_dropdown_content = document.getElementById("categories-dropdown-content");
  let element_searchbar_categories_text = document.getElementById("searchbar-category-text");

  // event listener for the text
  element_searchbar_categories_text.addEventListener("click", function() {
    // add/remove the class based if it already exists or not
    if (element_categories_dropdown_content.classList.contains("display-block-show")) {
      element_categories_dropdown_content.classList.remove("display-block-show");
    } else {
      element_categories_dropdown_content.classList.add("display-block-show");
    }
  });

  // if clicked outside the dropdown text or even in the dropdown => close it
  window.onclick = function(event) {
    if (!event.target.matches('.searchbar-category-dropdown')) {
      element_categories_dropdown_content.classList.remove("display-block-show");
    }
  }
}


// selected_item is the text of the selected category
function handleSearchCategroyText(selected_item) {
  let element_searchbar_categories_text = document.getElementById("searchbar-category-text");
  element_searchbar_categories_text.innerHTML = selected_item;
}


function handleScroll() {
  let element_button = document.getElementById("scroll-top-button");

  window.onscroll = function() {
    // Handle the scrollToTop button
    scrollToTop(element_button)

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
  };

  element_button.addEventListener("click", function() {
    document.body.scroll({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
    document.documentElement.scroll({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
  });

}

function scrollToTop(element_button) {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    element_button.classList.add("scroll-top-button-show");
  } else {
    element_button.classList.remove("scroll-top-button-show");
  }
};

function visitURL(urlName, has_name) {
  if (has_name) {
    if (urlName === "homepage") {
      // The "location" of the current page should be redirected to the "slash /" which is
      // a shortcut for the root page of this website (basically from website.com/blabla/caca to website.com/)
      location.href = location.protocol + '//' + location.host + "";
    }
  } else {
    location.href = urlName;
  }

}

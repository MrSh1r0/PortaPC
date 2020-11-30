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


// categories are given by the php file
function handleSearchCategoryList(categories){
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

  let element_list = document.getElementById("categories-dropdown-content");

  for (let i = 0; i < categories.length; i++) {
    let category = categories[i];
    let category_html = `<p class="categories-dropdown-item" onclick="handleSearchCategroyText('${category}')">${category}</p>`;
    element_list.innerHTML = element_list.innerHTML + category_html
  }

  // Set the default text to be the first element of the categories list
  handleSearchCategroyText(categories[0]);
}

// selected_item is the text of the selected category
function handleSearchCategroyText(selected_item) {
  let element_searchbar_categories_text = document.getElementById("searchbar-category-text");
  element_searchbar_categories_text.innerHTML = selected_item;
}

function populateDiscoverCategories(categories) {
  let element_list = document.getElementById("categories-list");

  for (let i = 0; i < categories.length; i++) {
    let category = categories[i];
    let category_html = `<li><a class="categories-item" href="pages/products/category.php?categories=${category}">${category}</a></li>`;
    element_list.innerHTML = element_list.innerHTML + category_html
  }
}

function handleScrollTop() {
  let element_button = document.getElementById("scroll-top-button");

  window.onscroll = function() {
    scrollToTop(element_button)
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
    element_button.classList.add("display-block-show");
  } else {
    element_button.classList.remove("display-block-show");
  }
};

function visitURL(urlName) {
  if (urlName === "homepage") {
    // The "location" of the current page should be redirected to the "slash /" which is
    // a shortcut for the root page of this website (basically from website.com/blabla/caca to website.com/)
    location.href = location.protocol + '//' + location.host + "/PortaPC";
  }
}

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

function populateSearchCategories(categories) {

}

// categories are given by the php file
// selected item is the text of the selected search item, if it's null, then it's FIRST TIME initilization
function handleSearchCategroyText(categories, selected_item) {

  // if this variable is NOT set, it means it's null or undefined
  if (!selected_item) {

  }
}

function populateDiscoverCategories(categories){
  let element_list = document.getElementById("categories-list");

  let all_categories_text = "Alle Kategorien";
  let all_categories_html = `<li><a class="categories-item" href="pages/products/category.php?categories=${all_categories_text}">${all_categories_text}</a></li>`;
  element_list.innerHTML = element_list.innerHTML + all_categories_html

  for(let i = 0; i < categories.length; i++){
    let category = categories[i];
    let category_html = `<li><a class="categories-item" href="pages/products/category.php?categories=${category}">${category}</a></li>`;
    element_list.innerHTML = element_list.innerHTML + category_html
  }
}

function visitURL(urlName) {
  if (urlName === "homepage") {
    // The "location" of the current page should be redirected to the "slash /" which is
    // a shortcut for the root page of this website (basically from website.com/blabla/caca to website.com/)
    location.href = location.protocol + '//' + location.host + "/PortaPC";
  }
}

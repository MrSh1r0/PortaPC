var categories = [];
var category_selected = "Alle Kategorien";

var ready = (callback) => {
  if (document.readyState != "loading") callback();
  else document.addEventListener("DOMContentLoaded", callback);
}

ready(() => {

  populateDropdown();

  console.log("The document is ready!");

  let dropdowntrigger = document.getElementsByClassName('dropdown-trigger');
  dropdowntrigger.dropdown();

  handleNavbar();

});

function handleNavbar(){

  var homepagecontent = document.getElementById("homepage-content");
  var offset = homepagecontent.offset().top;

  window.bind('scroll', function() {

    if (window.scrollTop() > offset) {
      var nav = document.getElementById("nav");
      nav.classList.add("nav-visible");
      var navContainer = document.getElementById("nav-container");
      navContainer.classList.add("nav-visible");
    }

    else {
      nav.classList.remove("nav-visible");
      navContainer.classList.remove("nav-visible");
    }

  });

};

function populateDropdown(){

  categories.unshift("Alle Kategorien");

  for(let i = 0; i < categories.length; i++){
    let category = categories[i];
    let category_html = `<li><a onclick="setSearchbarCategoryText(${i})">${category}</a></li>`;
    var searchbarcategory = document.getElementById("searchbar-category");
    searchbarcategory.append(category_html);
  }

};

function setSearchbarCategoryText(elementIndex){

  category_selected = categories[elementIndex];
  var searchbarcategorytext = document.getElementById("searchbar-category-text");
  searchbarcategorytext.text(category_selected);

};

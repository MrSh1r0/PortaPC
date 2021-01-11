function applyFilters(){
  // create the url params builder
  let urlParams = new URLSearchParams();

  // get sort order and sort by
  let selected_sorting_item_text = document.getElementById("sorting-dropdown-text").innerHTML;
  let sorting_filters_elements = document.getElementsByClassName("sorting-dropdown-item");
  for(let i = 0; i < sorting_filters_elements.length; i++){
    let item = sorting_filters_elements[i];
    let item_text = item.innerHTML;
    let item_sort_order = item.getAttribute('data-sort-order');
    let item_sort_by = item.getAttribute('data-sort-by');
    if(item_text === selected_sorting_item_text){
      urlParams.set("sort_order", item_sort_order);
      urlParams.set("sort_by", item_sort_by);
      break;
    }
  }

  // get the title query
  let title = document.getElementById("search_input").value;
  if(title){
    urlParams.set("title", title);
  }
  // get the selected category
  let category = document.getElementsByClassName("filters-categories-item-selected");
  if(category && category[0]){
    // it's possible that the user wants to search in all categories
    // in case there's no selected category, then we don't specify that.
    category = category[0].innerHTML;
    urlParams.set("category", category);
  }

  // get selected search filter
  let search_type = document.getElementsByClassName("search-type-item-selected");
  if(search_type && search_type[0]){
    // it's possible that the user wants to search in all categories
    // in case there's no selected category, then we don't specify that.
    search_type = search_type[0].innerHTML;
    urlParams.set("search_type", search_type);
  }

  // get the selected min and max price
  let price_min = document.getElementById("filters_price_min").value;
  let price_max = document.getElementById("filters_price_max").value;
  if(price_min || price_max){
    urlParams.set("price", `${price_min},${price_max}`);
  }


  // get the selected conditions
  let conditions_elements = document.getElementsByClassName("checkbox");
  let has_checked_conditions = false;
  let conditions = [];
  for(let i = 0; i < conditions_elements.length; i++){
    let item_condition = conditions_elements[i];
    if(item_condition.checked){
      let item_checkbox_label = document.querySelector(`#${item_condition.id} + label`);
      let item_checkbox_label_text = item_checkbox_label.textContent;
      conditions.push(item_checkbox_label_text);
      has_checked_conditions = true;
    }
  }
  if(has_checked_conditions){
    // it will convert the array to string with commas
    // check https://stackoverflow.com/a/202247/5646429
    urlParams.set("conditions", conditions.toString());
  }


  // get the selected locations
  let locations_elements = document.getElementsByClassName("chip");
  let has_checked_locations = false;
  let locations = [];
  for(let i = 0; i < locations_elements.length; i++){
    let item_location = locations_elements[i];
    if(item_location.checked){
      let item_chip_label = document.querySelector(`#${item_location.id} + label`);
      let item_chip_label_text = item_chip_label.textContent;
      locations.push(item_chip_label_text);
      has_checked_locations = true;
    }
  }
  if(has_checked_locations){
    // it will convert the array to string with commas
    // check https://stackoverflow.com/a/202247/5646429
    urlParams.set("locations", locations.toString());
  }

  // get the link of the page
  // mix it with the parameters builder
  let url = location.protocol + '//' + location.host + location.pathname + "?" + urlParams.toString();
  visitURL(url);
}

function refreshFilters(search_filters, sorting_filters){
  if(sorting_filters){
    let sort_order = sorting_filters.sort_order;
    let sort_by = sorting_filters.sort_by;

    let sorting_filters_elements = document.getElementsByClassName("sorting-dropdown-item");
    let has_found_sorting_filter = false;
    for(let i = 0; i < sorting_filters_elements.length; i++){
      let item = sorting_filters_elements[i];
      let item_sort_order = item.getAttribute('data-sort-order');
      let item_sort_by = item.getAttribute('data-sort-by');
      if(item_sort_order === sort_order && item_sort_by === sort_by){
        handleSortingDropdownText(item.innerHTML);
        has_found_sorting_filter = true;
      }
    }

    // if nothing was found, return to the normal, default filter
    if(!has_found_sorting_filter){
      let sorting_elements_first = document.getElementById("sorting_filters_item").innerHTML;
      handleSortingDropdownText(sorting_elements_first);
    }

  } else {
    let sorting_elements_first = document.getElementById("sorting_filters_item").innerHTML;
    handleSortingDropdownText(sorting_elements_first);
  }

  if(search_filters){
    let title = search_filters.title;
    let category = search_filters.category;
    let search_type = search_filters.search_type;
    let locations = search_filters.locations;
    let conditions = search_filters.conditions;
    let price = search_filters.price;

    if(title){
      document.getElementById("search_input").value = title;
    }

    if(search_type){
      let search_type_elements = document.getElementsByClassName("search-type-item");
      for(let i = 0; i < search_type_elements.length; i++){
        let item_search_type = search_type_elements[i];
        let item_search_type_text = item_search_type.innerHTML;
        if(item_search_type_text === search_type){
          // to avoid duplications, remove and add the class
          item_search_type.classList.remove("search-type-item-selected");
          item_search_type.classList.add("search-type-item-selected");

        } else {
          item_search_type.classList.remove("search-type-item-selected");
        }
      }
    } else {
      let search_type_elements = document.getElementsByClassName("search-type-item");
      for(let i = 0; i < search_type_elements.length; i++){
        let item_search_type = search_type_elements[i];
        let item_search_type_text = item_search_type.innerHTML;
        if(item_search_type_text === "Normal"){
          // to avoid duplications, remove and add the class
          item_search_type.classList.remove("search-type-item-selected");
          item_search_type.classList.add("search-type-item-selected");

        } else {
          item_search_type.classList.remove("search-type-item-selected");
        }
      }
    }

    if(category){
      let categories_elements = document.getElementsByClassName("filters-categories-item");

      for(let i = 0; i < categories_elements.length; i++){
        let item_category = categories_elements[i];
        let item_category_text = item_category.innerHTML;
        if(item_category_text === category){
          // to avoid duplications, remove and add the class
          item_category.classList.remove("filters-categories-item-selected");
          item_category.classList.add("filters-categories-item-selected");

        } else {
          item_category.classList.remove("filters-categories-item-selected");
        }
      }
    }

    if(price){
      let price_array = price.split(",");
      let price_min = price_array[0];
      let price_max = price_array[1];

      // if the price has null, it means it's not set
      if(price_min){
        document.getElementById("filters_price_min").value = price_min
      }

      if(price_max){
        document.getElementById("filters_price_max").value = price_max
      }
    }

    if(conditions){
      // A user can set multiple conditions, we are using "," to separate them
      conditions_array = conditions.split(",");
      // we just loop through the class checkbox
      // get the label of it
      // check the value of that label and match it against the conditions_array
      // if there's a match, then just make that checkbox "checked"
      let conditions_elements = document.getElementsByClassName("checkbox");

      for(let i = 0; i < conditions_elements.length; i++){
        let item_checkbox = conditions_elements[i];
        let item_checkbox_id = item_checkbox.id;
        // we will use querySelector with the + selector to find out the next element
        // it's always assumed that there's a label after each checkbox class
        // so, we will get that next element using the "+" selector
        let item_checkbox_label = document.querySelector(`#${item_checkbox_id} + label`);
        let item_checkbox_label_text = item_checkbox_label.textContent ;
        // by default, set the item "unchecked"
        item_checkbox.checked = false;
        // inside this nested loop, we will find out if this item is indeed "checked"
        for(let j = 0; j < conditions_array.length; j++){
          let item_condition_text = conditions_array[j];
          if(item_condition_text === item_checkbox_label_text){
            item_checkbox.checked = true;
          }
        }
      }
    }

    // same as above
    if(locations){
      // A user can set multiple conditions, we are using "," to separate them
      locations_array = locations.split(",");
      // we just loop through the class chip
      // get the label of it
      // check the value of that label and match it against the locations_array
      // if there's a match, then just make that chip "checked"
      let locations_elements = document.getElementsByClassName("chip");

      for(let i = 0; i < locations_elements.length; i++){
        let item_chip = locations_elements[i];
        let item_chip_id = item_chip.id;
        // we will use querySelector with the + selector to find out the next element
        // it's always assumed that there's a label after each chip class
        // so, we will get that next element using the "+" selector
        let item_chip_label = document.querySelector(`#${item_chip_id} + label`);
        let item_chip_label_text = item_chip_label.textContent ;
        // by default, set the item "unchecked"
        item_chip.checked = false;
        // inside this nested loop, we will find out if this item is indeed "checked"
        for(let j = 0; j < locations_array.length; j++){
          let item_location_text = locations_array[j];
          if(item_location_text === item_chip_label_text){
            item_chip.checked = true;
          }
        }
      }
    }
  }
}

function refreshFiltersCategory(category){
  let categories_elements = document.getElementsByClassName("filters-categories-item");

  for(let i = 0; i < categories_elements.length; i++){
    let item_category = categories_elements[i];
    let item_category_text = item_category.innerHTML;
    if(item_category_text === category){
      // check if this item is already selected, if so, then remove the selection
      // we get an array, so we check if it's defined and the length > 0
      let category_element_selected = document.getElementsByClassName("filters-categories-item-selected");
      if(category_element_selected && category_element_selected.length > 0){
        // we have a selected element
        category_element_selected = category_element_selected[0].innerHTML;
        // check if it's the same category
        if(category_element_selected === category){
          item_category.classList.remove("filters-categories-item-selected");
        } else {
          item_category.classList.remove("filters-categories-item-selected");
          item_category.classList.add("filters-categories-item-selected");
        }
      } else {
        // to avoid duplications, remove and add the class
        item_category.classList.remove("filters-categories-item-selected");
        item_category.classList.add("filters-categories-item-selected");
      }
    } else {
      item_category.classList.remove("filters-categories-item-selected");
    }
  }
}

function refreshSearchType(search_type){
  let categories_elements = document.getElementsByClassName("search-type-item");

  for(let i = 0; i < categories_elements.length; i++){
    let item_search_type = categories_elements[i];
    let item_search_type_text = item_search_type.innerHTML;
    if(item_search_type_text === search_type){
      // check if this item is already selected, if so, then remove the selection
      // we get an array, so we check if it's defined and the length > 0
      let item_search_type_selected = document.getElementsByClassName("search-type-item-selected");
      if(item_search_type_selected && item_search_type_selected.length > 0){
        // we have a selected element
        item_search_type_selected = item_search_type_selected[0].innerHTML;
        item_search_type.classList.remove("search-type-item-selected");
        item_search_type.classList.add("search-type-item-selected");

      } else {
        // to avoid duplications, remove and add the class
        item_search_type.classList.remove("search-type-item-selected");
        item_search_type.classList.add("search-type-item-selected");
      }
    } else {
      item_search_type.classList.remove("search-type-item-selected");
    }
  }
}

function handleSearch(element) {
  // Input was "entered", which means, a search query needs to be executed
  // we can basically redirect the user to the search page with a parameter for the search query
  if (event.key === 'Enter') {
    let title_query = element.value;
    let category = document.getElementById("searchbar-category-text").innerHTML;
    let current_url = window.location.href;
    let future_url;
    // let's imagine that we are in the pages/products/category.php page, what if there's already a title?
    // therefore, we get the url of the page, check if we are in that page
    // then we change the title parameter, or ADD it if it doesn't exist
    // otherwise, we just visit the page normally
    let should_include_category = category !== "Alle Kategorien";

    if (current_url.includes("category.php")) {
      // get the ?query=blabla&query2=blablabla string
      let queryString = window.location.search;

      // check if the page has any parameters
      if (queryString) {
        // parse it
        let urlParams = new URLSearchParams(queryString);
        // check if it has the search
        if (urlParams.has("title")) {
          // it does, we need to change it
          // the best approach is to build the url again
          // then we add the parameter manually
          urlParams.set("title", title_query);
          future_url = location.protocol + '//' + location.host + location.pathname + "?" + urlParams.toString();
        } else {
          // it doesn't, just add title to it
          future_url = current_url + `&title=${title_query}`;
        }
      } else {
        // it doesn't, just add title query and category query then
        future_url = `${location.protocol}//${location.host}/PortaPC/pages/products/category.php?title=${title_query}&category=${category}`;
      }
    } else {

      future_url = `${location.protocol}//${location.host}/PortaPC/pages/products/category.php?title=${title_query}${should_include_category ? `&category=${category}` : ''}`;
    }

    visitURL(future_url);
  }
}

var slide_index_last = 0;
var slider_lastclick_time;
var slider_timeout;
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
  slider_lastclick_time = new Date().getTime();
  clearTimeout(slider_timeout);
  slider_timeout = setTimeout(handleSliderAutomatic, 1000 * 8);
}

function handleSliderAutomatic(){
  let current_time = new Date().getTime();
  // this will get us the difference in seconds
  let time_difference = (current_time - slider_lastclick_time) / 1000;

  if(time_difference >= 8){
    // it has been more than three seconds since the user clicked anything, so we can do this automatic handling
    handleSlider(slide_index_last + 1);
  }
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

// I had to mix those functions, because window.onclick will only be called once in a function to be listened
// otherwise, only one would be applied
// Also, this function gets called only in the category.php
function handleDropdowns() {
  let element_sorting_dropdown_content = document.getElementById("sorting-dropdown-content");
  let element_sorting_text = document.getElementById("sorting-dropdown-text");

  let element_categories_dropdown_content = document.getElementById("categories-dropdown-content");
  let element_searchbar_categories_text = document.getElementById("searchbar-category-text");

  // event listener for the text
  element_sorting_text.addEventListener("click", function() {
    // add/remove the class based if it already exists or not
    if (element_sorting_dropdown_content.classList.contains("display-block-show")) {
      element_sorting_dropdown_content.classList.remove("display-block-show");
    } else {
      element_sorting_dropdown_content.classList.add("display-block-show");
    }
  });

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
    if (!event.target.matches('.sorting-dropdown-text') && !event.target.matches('.searchbar-category-dropdown')) {
      element_sorting_dropdown_content.classList.remove("display-block-show");
      element_categories_dropdown_content.classList.remove("display-block-show");
    }
  }
}

function applySortingDropdownAfterChange(selected_item){
  handleSortingDropdownText(selected_item);
  applyFilters();
}

function handleSortingDropdownText(selected_item){
  let element_sorting_dropdown_text = document.getElementById("sorting-dropdown-text");
  element_sorting_dropdown_text.innerHTML = selected_item;
}



// selected_item is the text of the selected category
function handleSearchCategroyText(selected_item) {
  let element_searchbar_categories_text = document.getElementById("searchbar-category-text");
  element_searchbar_categories_text.innerHTML = selected_item;
}

function handleMobileNavigation(){
  // we are going to change the attribute of the navigation overlay
  // if should_open, make the overlay visible
  // if not, then the "x" button was clicked
  let categories_col_container = document.getElementById("categories-col-container");
  if(categories_col_container.classList.contains("categories-col-container-visible")){
    categories_col_container.classList.remove("categories-col-container-visible");
  } else {
    categories_col_container.classList.add("categories-col-container-visible");
  }
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

    let element_mobile_nav_menu = document.getElementById("mobile_side_navigation_menu");
    let categories_col_container = document.getElementById("categories-col-container");
    if (window_scroll_position > offset_top) {
      if(element_mobile_nav_menu)
        element_mobile_nav_menu.classList.remove("margin-t-2");
      if(element_nav)
        element_nav.classList.add("nav-visible");
      if(element_nav_container)
        element_nav_container.classList.add("nav-visible");
      // there will be a white space in between, so remove the extra space
      if(categories_col_container){
        categories_col_container.style.top = "0px";
      }

    } else {
      if(element_mobile_nav_menu)
        element_mobile_nav_menu.classList.add("margin-t-2");
      if(element_nav)
        element_nav.classList.remove("nav-visible");
      if(element_nav_container)
        element_nav_container.classList.remove("nav-visible");
      // make it back normal after the fixed navbar is removed
      if(categories_col_container)
        categories_col_container.style.top = "8px";
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

function visitURL(url) {
  location.href = url;
}

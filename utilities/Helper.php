<?php

class Helper {
    // Just like Java, we create a private variable and a "getter"
    private $jsonDatabase;
    private $page_products_limit = 20;
    public $homepage_products_latest_limit = 15;

    public function __construct() {
        $this->jsonDatabase = file_get_contents(__DIR__ . '/../database.json');
        $this->jsonDatabase = json_decode($this->jsonDatabase);
    }

    // This is the getter for $jsonDatabase
    public function getJson() {
        return $this->jsonDatabase;
    }

    // Get the categories.
    // JsonDatabase is an object, which has the object website_constants
    // website_constants has an array, which is categories
    // $this is similar to the Java this
    // We will return this in encoded JSON, so we can parse it on the client side or use it later (better)
    // IMPORTANT: We could've used the approach in getSocialLinks
    // BUT, because we have a dropdown list that needs Javascript
    // It's better (not actually, but just less confusing) to let Javascript handle everything
    // instead of renedering the categories via PHP and then
    public function getCategories($encode) {
        if ($encode === true) {
            return json_encode($this->jsonDatabase->website_constants->categories);
        } else {
            return $this->jsonDatabase->website_constants->categories;
        }
    }

    public function getConditions() {
        return $this->jsonDatabase->website_constants->conditions;
    }

    public function getLocations() {
        return $this->jsonDatabase->website_constants->locations;
    }

    public function getSliders() {
        return $this->jsonDatabase->website_database->sliders;
    }

    public function getInformation() {
        return $this->jsonDatabase->website_constants->information;
    }

    public function getSocialLinks() {
        return $this->jsonDatabase->website_constants->social_links;
    }

    public function getProducts($search, $sort, $limit, $page) {
        /*
        $search: include a search object that has values to search for (Search page).
        $sort: include the sorting method, either by date or price or title (both directions).
        $limit: limiting how many products we want to retrieve (Used in Neueste Anzeige).
        $page: integer, if it's null, then we are looking for the first result, if there's a number, then the user went to a different page and we need to retrieve the products from that specified page
        */
        $products = $this->jsonDatabase->website_database->products;
        // sometimes, we would like to know if there are MORE products to show after the response we received
        $has_more = false;
        // empty is a php core function to check if the variable is set
        // empty checks if the variable has an empty value empty string, 0, NULL or False. Returns FALSE if var has a non-empty and non-zero value
        if (empty($search) === false) {
            if (empty($search->title) === false) {
                $query_title = $search->title;
                $products = $this->filterArray($products, "title", $query_title, true, true);
            }

            if (empty($search->price) === false) {
                $query_price = $search->price;
                $query_price_range = explode(",", $query_price);
                // what if the user put something in the title
                // or what if the system has some weird error
                // then the parameter would look like this ?price=,
                // [0] would be empty and [1] would be also empty
                // so we need to make sure that either one of them is NOT empty
                if(empty($query_price_range[0]) === false || empty($query_price_range[1]) === false){
                  $products = $this->filterArrayRange($products, "price", $query_price_range);
                }
            }

            if (empty($search->category) === false) {
                $query_category = $search->category;
                $products = $this->filterArray($products, "category", $query_category, false, false);
            }

            if (empty($search->locations) === false) {
                $query_locations = $search->locations;
                $query_locations = explode(",", $query_locations);
                $products = $this->filterArray($products, "location", $query_locations, false, false);
            }

            if (empty($search->conditions) === false) {
                $query_conditions = $search->conditions;
                $query_conditions = explode(",", $query_conditions);
                $products = $this->filterArray($products, "condition", $query_conditions, false, false);
            }
        }

        if (empty($sort) === false) {
            $sort_by = $sort->sort_by;
            $sort_order = $sort->sort_order;

            // if the sorting is one of the known ways, then let it be
            if(($sort_by === "title" || $sort_by === "price" || $sort_by === "created_at") && ($sort_order === "asc" || $sort_order === "desc") ){
              $products = $this->sortArray($products, $sort_by, $sort_order);
            }

        }

        if (empty($page) === false) {
            // we have pages functionality, then create "pages" and return the requested page
            // basically, if we have 50 products, divided by 19, 50 / 19 = 2.63157895
            // this means we have 3 pages
            $products_total_count = sizeof($products);
            $pages_count = $products_total_count / $this->page_products_limit;
            // but to make it 3, we need to "ceil" the 2.6 to an integer
            $pages_count = ceil($pages_count);
            // now, we need to split the array into pages arrays
            // so we can have "pages"
            // we use the core method array_chunk
            $products_pages_array = array_chunk($products, $this->page_products_limit);
            // because page is a human-readerable number, we need to make it an index
            // page 1 is index 0
            // check if the index exissts in the array, if so, go ahead, if not, return empty
            if (empty($products_pages_array[$page - 1]) === false) {
                $products = $products_pages_array[$page - 1];

                // to check the value for $has_more
                // we calculate how many products we have shown so far and how many are in total and see if it's > 0
                // first, get the count from previous pages
                $products_previous_pages_count = ($page - 1) * $this->page_products_limit;
                // secondm get the count of this current page
                $products_current_page_count = sizeof($products);
                // now the sum of both of these will be compared with the total
                $has_more = $products_total_count > ($products_previous_pages_count + $products_current_page_count);
                return json_encode(array('products' => $products, 'products_total_count' => $products_total_count, 'pages' => $pages_count, 'has_pages' => true, 'has_more' => $has_more));
            } else {
                return json_encode(array('products' => array(), 'products_total_count' => $products_total_count,'pages' => $pages_count, 'has_pages' => true, 'has_more' => false));
            }
        } else {
            $products_total_count = sizeof($products);
            // if the total count > the limit, then we have more products to load
            $has_more = $products_total_count > $limit;
            // just limit and return
            // $products is the array
            // 0 is from which index we should sstart
            // $limit is how many we want
            $products = array_slice($products, 0, $limit);
        }

        return json_encode(array('products' => $products, 'products_total_count' => $limit, 'pages' => 1, 'has_pages' => false, 'has_more' => $has_more));
    }

    // in the case of conditions & locations, we have an array of keys
    // so sometimes, we need to check if "values" is an array or just a single item
    // if it's an array, we can loop through it
    private function filterArray($array, $key, $values, $like, $case_insensitive) {
        // Create an empty array for our response
        $array_response = array();
        // Loop through the array of objects
        foreach ($array as $object) {
            // check if we have $like set to true
            // if so, then we want to check if a string CONTAINS something
            // if not, then we want to check if a string EQUALS something
            if ($like === true) {
                if (is_array($values) === true) {
                    foreach ($values as $value) {

                        if($case_insensitive === true){
                          $object_value = strtolower($object_value);
                          $value = strtolower($value);
                        }

                        if (strpos($object_value, $value) !== false) {
                            array_push($array_response, $object);
                            break;
                        }
                    }
                } else {
                    $object_value = $object->$key;
                    if($case_insensitive === true){
                      $object_value = strtolower($object_value);
                      $values = strtolower($values);
                    }
                    if (strpos($object_value, $values) !== false) {
                        array_push($array_response, $object);
                    }
                }
            } else {
                if (is_array($values) === true) {
                    foreach ($values as $value) {
                        if ($object->$key == $value) {
                            array_push($array_response, $object);
                            break;
                        }
                    }
                } else {
                    if ($object->$key == $values) {
                        array_push($array_response, $object);
                    }
                }
            }
        }
        return $array_response;
    }

    private function filterArrayRange($array, $key, $range){
      // Create an empty array for our response
      $array_response = array();
      // Loop through the array of objects
      $range_min = $range[0];
      $range_max = $range[1];
      //  the user doesn't set the maximum, le
      foreach ($array as $object) {
        if(empty($range_min) === false && empty($range_max) === false){
          // we have minimum and maximum
          if($object->$key >= $range_min && $object->$key <= $range_max){
            array_push($array_response, $object);
          }
        } else if(empty($range_min) === false && empty($range_max) === true){
          // we have minimum, we don't have max
          if($object->$key >= $range_min){
            array_push($array_response, $object);
          }
        } else if(empty($range_min) === true && empty($range_max) === false){
          // we don't have minimum, we have max
          if($object->$key <= $range_max){
            array_push($array_response, $object);
          }
        }
      }

      return $array_response;
    }

    private function sortArray($array, $sort_by, $sort_order) {
        // Check what type of sort order we are looking for
        // use ($sort_by): why? inside the usort block, we can't access outside variables
        // therefore, we need to "use" them and include them manually
        // usort update the array variable, so we don't need to use $array = usort
        if ($sort_order === "asc") {
            // asc
            usort($array, function ($a, $b) use ($sort_by) {
                return ($a->$sort_by <=> $b->$sort_by);
            });
        } else {
            // desc
            usort($array, function ($a, $b) use ($sort_by) {
                return -($a->$sort_by <=> $b->$sort_by);
            });
        }

        return $array;
    }
}

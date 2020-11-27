<?php

class Helper {
  // Just like Java, we create a private variable and a "getter"
  private $jsonDatabase;

  function __construct() {
    $this->jsonDatabase = file_get_contents(__DIR__ . '/../database.json');
    $this->jsonDatabase = json_decode($this->jsonDatabase);
  }

  // Get the categories.
  // JsonDatabase is an object, which has the object website_constants
  // website_constants has an array, which is categories
  // $this is similar to the Java this
  // We will return this in encoded JSON, so we can parse it on the client side or use it later (better)
  function getCategories(){
    return json_encode($this->jsonDatabase->website_constants->categories);
  }

  // This is the getter for $jsonDatabase
  function getJson(){
    return $this->jsonDatabase;
  }


}

?>

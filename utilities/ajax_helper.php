<?php

// Include this once, to avoid any duplications.
include_once("utilities/Helper.php");

// Create a new instance of our Helper class
$helper = new Helper();

// Save the GET value to a variable
$request_type = $_GET['request_type'];

// Check for the value
if($request_type === "categories"){
  // Return the categories
} else {

}

?>

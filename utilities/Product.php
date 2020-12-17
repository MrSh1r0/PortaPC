<?php
session_start();
include_once("Helper.php");

// Create an instance of our Helper class
$helper                      = new Helper();

// here we check for all the variables if they are SET
// this is only for ADDING product
if(isset($_POST["submit_add"]) && isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["category"]) && isset($_POST["condition"]) && isset($_POST["location"]) && isset($_POST["price"]) && isset($_FILES["images_upload"])) {
  $title = $_POST["title"];
  $description = $_POST["description"];
  $category = $_POST["category"];
  $condition = $_POST["condition"];
  $location = $_POST["location"];
  $price = $_POST["price"];
  $images_count = count($_FILES['images_upload']['name']);
  $product_id = $helper->getNextAvailableProductID();
  $images_target_dir = "../images/products/" . $product_id . "/";


  $user_name = "";
  $user_email = "";
  $user_type = "";
  $has_logged = false;

  if(isset($_SESSION["user_email"]) && isset($_SESSION["user_password"])){
    $admin_email = $_SESSION["user_email"];
    $admin_password = $_SESSION["user_password"];
    $login_response = json_decode($helper->loginAdmin($admin_email, $admin_password));
    if($login_response->result === true){
      $has_logged = true;
      $user_name = $login_response->admin_username;
      $user_email = $admin_email;
      $user_type = "admin";
    }
  }

  if($has_logged === false){
    if(isset($_POST["name"]) === true && isset($_POST["email"]) === true && empty($_POST["name"]) === false && empty($_POST["email"]) === false){
      $user_name = $_POST["name"];
      $user_email = $_POST["email"];
      $user_type = "user";
    } else {
      header("Location: ../pages/panel/product_add.php?result=failure&action=add&message=Name oder Email waren entweder nicht eingegeben oder leer.");
      exit;
    }
  }

  $owner = new stdclass();
  $owner->username = $user_name;
  $owner->user_email = $user_email;
  $owner->user_type = $user_type;

  // if the directory doesn't exist, create it
  if (!file_exists($images_target_dir)) {
    mkdir($images_target_dir, 0755, true);
  }

  // check if something is empty
  if(empty($title) === false && empty($description) === false && empty($category) === false && empty($condition) === false && empty($location) === false && empty($price) === false && $images_count > 0) {
    $uploaded_images_count = 0;
    for($i=0; $i < $images_count; $i++){
      $image_target_dir = $images_target_dir . $_FILES['images_upload']['name'][$i];
      if(move_uploaded_file($_FILES['images_upload']['tmp_name'][$i], $image_target_dir)){
        $uploaded_images_count++;
      }
    }

    // check if we have failed images
    $failed_images_count = $images_count - $uploaded_images_count;


    $product = new stdclass();
    $product->id = $product_id;
    // htmlspecialchars is used to escape any characters that may break our json file
    $product->title = htmlspecialchars($title);
    $product->description = htmlspecialchars($description);
    $product->location = $location;
    $product->price = (int) $price;
    $product->category = $category;
    $product->condition = $condition;
    $product->owner = $owner;
    // this is based on the server's time and not the client!
    $date_now = new DateTime();
    $product->created_at = $date_now->getTimestamp();
    $product->created_at_human = $date_now->format('d.m.Y');;
    $product->images = [];
    for($i=0; $i < $images_count; $i++){
      array_push($product->images, $_FILES['images_upload']['name'][$i]);
    }

    // TODO: add a token or link for this product to edit or to delete
    // now let's redirect the user back to product_add or whatever
    $message = "";
    if($failed_images_count == $images_count){
      $message = "Ihre Anzeige wurde nicht erstellt, da keine Bilder hochgeladen wurden!";
    } else if ($failed_images_count > 0){
      $helper->addProduct($product);
      $message = "Ihre Anzeige wurde erstellt, jedoch wurde[n]" . $failed_images_count . " Bilder nicht hochgeladen!";
    } else {
      $helper->addProduct($product);
      $message = "Ihre Anzeige wurde erstellt!";
    }

    header("Location: ../pages/panel/product_add.php?result=success&action=add&message=" . $message);
    exit;
  } else {
    header("Location: ../pages/panel/product_add.php?result=failure&action=add&message=Bitte vollständigen Sie alle Angaben!");
    exit;
  }
}

?>

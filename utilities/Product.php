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
  // maybe the user uses an admin email to spam?

  if($has_logged === false){
    if(isset($_POST["name"]) === true && isset($_POST["email"]) === true && empty($_POST["name"]) === false && empty($_POST["email"]) === false){
      $user_name = $_POST["name"];
      $user_email = $_POST["email"];
      // check if the user put the admin email, if so, we reject it and tell him that
      if($user_email == $helper->getAdminLogin()->admin_email){
        header("Location: ../pages/panel/product_add.php?result=failure&action=add&message=Sie dürfen dieses Email nicht benutzten!");
        exit;
      }
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
  // see https://www.php.net/manual/en/function.random-bytes.php
  // we will use two tokens/two generated strings with short & long lengths to use as an email & password (something similar, just to look like we are being secure of our product and let it make sense)
  // bytes to hex https://www.php.net/manual/en/function.bin2hex.php
  $owner->post_token_id = bin2hex(random_bytes(5));
  $owner->post_token_password = bin2hex(random_bytes(15));
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
    $product->title = $title;
    $product->description = $description;
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

    // now let's redirect the user back to product_add
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
    header("Location: ../pages/panel/product_add.php?result=success&action=add&message=" . $message . "&post_token_id=" . $owner->post_token_id . "&post_token_password=" . $owner->post_token_password . "&id=" . $product->id);
    exit;
  } else {
    header("Location: ../pages/panel/product_add.php?result=failure&action=add&message=Bitte vollständigen Sie alle Angaben!");
    exit;
  }
} else if(isset($_POST["submit_edit"]) && isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["category"]) && isset($_POST["condition"]) && isset($_POST["location"]) && isset($_POST["price"]) && isset($_FILES["images_upload"])) {
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
  // maybe the user uses an admin email to spam?

  if($has_logged === false){
    if(isset($_POST["name"]) === true && isset($_POST["email"]) === true && empty($_POST["name"]) === false && empty($_POST["email"]) === false){
      $user_name = $_POST["name"];
      $user_email = $_POST["email"];
      // check if the user put the admin email, if so, we reject it and tell him that
      if($user_email == $helper->getAdminLogin()->admin_email){
        header("Location: ../pages/panel/product_add.php?result=failure&action=add&message=Sie dürfen dieses Email nicht benutzten!");
        exit;
      }
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
  // see https://www.php.net/manual/en/function.random-bytes.php
  // we will use two tokens/two generated strings with short & long lengths to use as an email & password (something similar, just to look like we are being secure of our product and let it make sense)
  // bytes to hex https://www.php.net/manual/en/function.bin2hex.php
  $owner->post_token_id = bin2hex(random_bytes(5));
  $owner->post_token_password = bin2hex(random_bytes(15));
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
    $product->title = $title;
    $product->description = $description;
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

    // now let's redirect the user back to product_add
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
    //header("Location: ../pages/panel/product_edit.php?result=success&action=add&message=" . $message . "&post_token_id=" . $owner->post_token_id . "&post_token_password=" . $owner->post_token_password . "&id=" . $product->id);
    //exit;
  } else {
    header("Location: ../pages/panel/product_edit.php?result=failure&action=add&message=Bitte vollständigen Sie alle Angaben!");
    exit;
  }
} else if(isset($_POST["submit_delete"]) && isset($_POST["post_token_id"]) && isset($_POST["post_token_password"]) && isset($_POST["id"]) ) {
  $id = $_POST["id"];
  $post_token_id = $_POST["post_token_id"];
  $post_token_password = $_POST["post_token_password"];
  if(empty($id) === false && empty($post_token_id) === false && empty($post_token_password) === false){
    $product = $helper->getProduct($id);
    if(empty($product) === true){
      header("Location: ../pages/panel/product_delete.php?result=failure&action=delete&message=Die Anzeige kann nicht gefunden werden");
      exit;
    }

    $product_token_id = $product->owner->post_token_id;
    $product_token_password = $product->owner->post_token_password;

    if($product_token_id == $post_token_id && $product_token_password == $post_token_password){
      // it's correct, delete the directory of the pictures and delete the product from the json
      // we need to delete the files first, then the folder
      $path = "../images/products/" . $id . "/";
      // https://www.php.net/manual/en/function.glob.php
      // search for the files in that path
      // the star here is to choose all the files
      // this doesn't include the hidden files!!
      // file_exists checks if the directory actually exists
      if(file_exists($path) === true){
        $files = glob($path . "*");
        foreach($files as $file){
          // check if is a file, https://www.php.net/manual/en/function.is-file.php
          if(is_file($file) === true) {
            // delete the file, https://www.php.net/manual/en/function.unlink.php
            unlink($file);
          }
        }
        rmdir($path);
      }

      $helper->deleteProduct($id);
      header("Location: ../pages/panel/product_delete.php?result=success&action=delete&message=Die Anzeige wurde gelöscht!");
      exit;
    } else {
      header("Location: ../pages/panel/product_delete.php?result=failure&action=delete&message=Die durch den Link angegebenen Tokens sind nicht korrekt!");
      exit;
    }
  } else {
    header("Location: ../pages/panel/product_delete.php?result=failure&action=delete&message=Entweder ID oder Token sind nicht angegeben.");
    exit;
  }
}

?>

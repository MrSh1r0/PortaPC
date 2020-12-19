<?php
session_start();
include_once("Helper.php");

// Create an instance of our Helper class
$helper                      = new Helper();

// here we check for all the variables if they are SET
// this is only for ADDING product
if(isset($_POST["submit_add"]) === true  && isset($_POST["title"]) === true  && isset($_POST["description"]) === true  && isset($_POST["category"]) === true  && isset($_POST["condition"]) === true  && isset($_POST["location"]) === true  && isset($_POST["price"]) === true  && isset($_FILES["images_upload"]) === true ) {
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

  if(isset($_SESSION["user_email"]) === true  && isset($_SESSION["user_password"]) === true ){
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

    // check if we have failed images
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
      // we want a random name for the file to avoid duplication
      // https://www.php.net/manual/en/function.uniqid.php
      $file_extension = pathinfo($_FILES['images_upload']['name'][$i], PATHINFO_EXTENSION);
      $file_name = uniqid() . "." . $file_extension;
      $image_target_dir = $images_target_dir . $file_name;
      if(move_uploaded_file($_FILES['images_upload']['tmp_name'][$i], $image_target_dir)){
        $uploaded_images_count++;
        array_push($product->images, $file_name);
      }
    }

    $failed_images_count = $images_count - $uploaded_images_count;

    // now let's redirect the user back to product_add
    $message = "";
    if($failed_images_count == $images_count){
      header("Location: ../pages/panel/product_add.php?result=success&action=add&message=Ihre Anzeige wurde nicht erstellt, da keine Bilder hochgeladen wurden!");
      exit;
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
} else if(isset($_POST["submit_edit"]) === true && isset($_POST["title"]) === true  && isset($_POST["description"]) === true  && isset($_POST["category"]) === true  && isset($_POST["condition"]) === true  && isset($_POST["location"]) === true  && isset($_POST["price"]) === true  && isset($_POST["id"]) === true  && isset($_POST["post_token_password"]) === true  && isset($_POST["post_token_id"]) === true ) {
  $title = $_POST["title"];
  $description = $_POST["description"];
  $category = $_POST["category"];
  $condition = $_POST["condition"];
  $location = $_POST["location"];
  $price = $_POST["price"];
  $product_id = $_POST["id"];
  $post_token_id = $_POST["post_token_id"];
  $post_token_password = $_POST["post_token_password"];
  $product_original = $helper->getProduct($product_id);
  $does_product_exist = empty($product_original) === false;
  if($does_product_exist === false){
    header("Location: ../pages/panel/product_edit.php?result=failure&action=edit&message=Die Anzeige kann nicht gefunden werden!");
    exit;
  }

  $user_name = "";
  $user_email = "";
  $user_type = "";
  $has_logged = false;

  if(isset($_SESSION["user_email"]) === true  && isset($_SESSION["user_password"]) === true ){
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

      // if the user somehow managed to get the token and access an admin post, don't let him unless he is logged in
      if($product_original->owner->user_type == "admin"){
        header("Location: ../pages/panel/product_edit.php?result=failure&action=edit&message=Sie dürfen diese Anzeige nicht zugreifen!");
        exit;
      }

      // check if the user put the admin email, if so, we reject it and tell him that
      if($user_email == $helper->getAdminLogin()->admin_email){
        header("Location: ../pages/panel/product_edit.php?result=failure&action=edit&message=Sie dürfen dieses Email nicht benutzten!");
        exit;
      }

      $user_type = "user";
    } else {
      header("Location: ../pages/panel/product_edit.php?result=failure&action=edit&message=Name oder Email waren entweder nicht eingegeben oder leer.");
      exit;
    }
  }


  // we either have uploaded pics from before, or we have new pics
  // now we check if we have new pics
  if(empty($title) === false && empty($description) === false && empty($category) === false && empty($condition) === false && empty($location) === false && empty($price) === false){
    $owner = new stdclass();
    $owner->username = $user_name;
    $owner->user_email = $user_email;
    $owner->user_type = $user_type;
    $owner->post_token_id = $post_token_id;
    $owner->post_token_password = $post_token_password;

    $images_total = [];
    $has_pictures = false;

    if(isset($_POST["images_uploaded"]) === true && empty($_POST["images_uploaded"]) === false){
      $has_pictures = true;
      $uploaded_images = $_POST["images_uploaded"];
      foreach($product_original->images as $original_image){
        $does_original_image_exist = false;
        foreach($uploaded_images as $uploaded_image){
          if(strpos($uploaded_image, $original_image) !== false){
            $does_original_image_exist = true;
            break;
          }
        }

        if($does_original_image_exist === false){
            // doesn't exist, so delete it
            $path = "../images/products/" . $product_id . "/";
            // https://www.php.net/manual/en/function.glob.php
            // search for the files in that path
            // the star here is to choose all the files
            // this doesn't include the hidden files!!
            // file_exists checks if the directory actually exists
            if(file_exists($path . $original_image) === true && is_file($path . $original_image) === true){
              unlink($path . $original_image);
            }
        } else {
          array_push($images_total, $original_image);
        }
      }
    } else {
      // no uploaded pics, so we delete every uploaded pic from this product and we upload the new ones
      // it's correct, delete the directory of the pictures and delete the product from the json
      // we need to delete the files first, then the folder
      $path = "../images/products/" . $product_original->id . "/";
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
    }

    $uploaded_images_count = 0;
    $images_count = 0;
    $images_target_dir = "../images/products/" . $product_original->id . "/";
    if(isset($_FILES["images_upload"]) === false){
      if($has_pictures === false){
        // no uploaded pics, so tell him it's not accepted
        header("Location: ../pages/panel/product_edit.php?result=failure&action=edit&message=Ihre Anzeige wurde nicht bearbeitet, da es keine Bilder gibt!");
        exit;
      }
    } else {
      if (!file_exists($images_target_dir)) {
        mkdir($images_target_dir, 0755, true);
      }

      $images_count = count($_FILES['images_upload']['name']);
      for($i=0; $i < $images_count; $i++){
        $file_extension = pathinfo($_FILES['images_upload']['name'][$i], PATHINFO_EXTENSION);
        $file_name = uniqid() . "." . $file_extension;
        $image_target_dir = $images_target_dir . $file_name;
        if(move_uploaded_file($_FILES['images_upload']['tmp_name'][$i], $image_target_dir)){
          array_push($images_total, $file_name);
          $uploaded_images_count++;
        }
      }
    }

    // check if we have failed images
    $failed_images_count = $images_count - $uploaded_images_count;


    $product = new stdclass();
    $product->id = (int) $product_id;
    // htmlspecialchars is used to escape any characters that may break our json file
    $product->title = $title;
    $product->description = $description;
    $product->location = $location;
    $product->price = (int) $price;
    $product->category = $category;
    $product->condition = $condition;
    $product->created_at = $product_original->created_at;
    $product->created_at_human = $product_original->created_at_human;
    $product->owner = $owner;
    // this is based on the server's time and not the client!
    $date_now = new DateTime();
    $product->updated_at = $date_now->getTimestamp();
    $product->updated_at_human = $date_now->format('d.m.Y');
    $product->images = $images_total;

    $message = "";
    if($failed_images_count == $images_count){
      $message = "Ihre Anzeige wurde bearbeitet, jedoch wurden keine neuen Bilder hochgeladen!";
    } else if ($failed_images_count > 0){
      $message = "Ihre Anzeige wurde bearbeitet, jedoch wurde[n]" . $failed_images_count . " Bilder nicht hochgeladen!";
    } else {
      $message = "Ihre Anzeige wurde bearbeitet!";
    }
    $helper->editProduct($product);
    header("Location: ../pages/panel/product_edit.php?result=success&action=edit&message=" . $message);
    exit;
  } else {
    header("Location: ../pages/panel/product_edit.php?result=failure&action=edit&message=Bitte vollständigen Sie alle Angaben!");
    exit;
  }
} else if(isset($_POST["submit_delete"]) === true  && isset($_POST["post_token_id"]) === true  && isset($_POST["post_token_password"]) === true  && isset($_POST["id"]) === true  ) {
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

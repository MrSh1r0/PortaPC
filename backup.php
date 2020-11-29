<?php
/*
We will use a Helper class in PHP to get our Json content.
If we use JavaScript, our Json file will be exposed.
We want to try our best to keep it a bit secure, even if it's not the best approach.

First, include the class once. We don't want any duplicated includes of the same file (prevent any conflicts)
*/
include_once("utilities/Helper.php");

// We then create an instance of our class
$helper = new Helper();

?>

<!-- var categories = <?php echo $helper -> getCategories() ?>; -->

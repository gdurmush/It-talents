<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once "../Model/dbManager.php";
if (isset($_POST["searchProducts"])) {
    $products = searchProduct($_POST["search"]);
    if ($products){
        echo "<h1>Products </h1>";
    }
    else {
        echo "<h1>Not Found Results</h1>";
    }

    foreach ($products as $product) {
        ?>
        <h3><a href="somewhere.php"> <?= $product["name"] ?></a></h3>
        <?php
    }
    $categories = searchCategorie($_POST["search"]);
    if ($categories) {

        echo "<h1>Categories</h1>";
        foreach ($categories as $category) {
            ?>
            <h3><a href="somewhere.php"> <?= $category["name"] ?></a></h3>
            <?php
        }
    }
    $producers = searchProducer($_POST["search"]);
    if ($producers) {

        echo "<h1>Producer</h1>";
        foreach ($producers as $producer) {
            ?>
            <h3><a href="somewhere.php" ><?= $producer["name"] ?></a></h3>
            <?php
        }
    }
}
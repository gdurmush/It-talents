<?php
namespace Controller;
use Model\RatingDAO;


class ratingController
{


    public function rate(){

        if (isset($_POST["save"])) {
            $msg = "";

            if (empty($_POST["rating"]) || empty($_POST["comment"])) {
                $msg = "All fields are required!";
            } else {
                if (!preg_match('/^[1-5]+$/', $_POST["rating"]) || !is_numeric($_POST["rating"])) {
                    $msg = "Rating must be from 1 to 5!";
                }
                if (strlen($_POST["comment"]) > 100) {
                    $msg = "Comment must be maximum 100 characters!";
                }
                if ($msg == "") {

                    RatingDAO::addRating($_SESSION["logged_user_id"], $_POST["product_id"], $_POST["rating"], $_POST["comment"]);
                    include_once "View/showProduct.php";
                }
            }
        }
    }

    public function editRate(){

        if (isset($_POST["saveChanges"])) {
            $msg = "";
            if (empty($_POST["rating"]) || empty($_POST["comment"])) {
                $msg = "All fields are required!";
            } else {
                if (!preg_match('/^[1-5]+$/', $_POST["rating"]) || !is_numeric($_POST["rating"])) {
                    $msg = "Rating must be from 1 to 5!";
                }
                if (strlen($_POST["comment"]) > 100) {
                    $msg = "Comment must be maximum 100 characters!";
                }
                if ($msg == "") {
                    RatingDAO::editRating($_POST["rating_id"], $_POST["rating"], $_POST["comment"]);
                    include_once "View/myRated.php";
                }
            }
        }
    }

    public static function showStars($product_id){

        $product_stars = RatingDAO::getStarsCount($product_id);

        $starsCountArr = [];
        for ($i = 1; $i <= 5; $i++) {
            $isZero = true;
            foreach ($product_stars as $product_star) {
                if ($product_star["stars"] == $i) {
                    $starsCountArr[$i] = $product_star["stars_count"];
                    $isZero = false;
                }
            }
            if ($isZero) {
                $starsCountArr[$i] = 0;
            }
        }

        return $starsCountArr;
    }


    public function myRated()
    {
        include_once "View/myRated.php";
    }

    public function rateProduct()
    {
        include_once "View/rateProduct.php";
    }

    public function editRatedPage()
    {
        include_once "View/editRatedProduct.php";
    }
}
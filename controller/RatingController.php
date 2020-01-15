<?php
namespace controller;
use exception\BadRequestException;
use model\RatingDAO;


class ratingController
{


    public function rate(){
        UserController::validateForLoggedUser();
        $msg="";
        if (isset($_POST["save"])) {

            if (empty($_POST["comment"]) || empty($_POST["rating"])) {
                $msg = "All fields are required!";
            }elseif($this->commentValidation($_POST["comment"])){
                $msg = "Invalid comment!";
            }elseif($this->ratingValidation($_POST["rating"])){
                $msg = "Invalid rating!";
            }
            // DONE validate comment and rating


            if ($msg == "") {
                // TODO exeption and validate product id

                $ratingDAO=new RatingDAO();
                $ratingDAO->addRating($_SESSION["logged_user_id"], $_POST["product_id"], $_POST["rating"], $_POST["comment"]);
                header("Location: index.php?target=product&action=main");

            }else{
                throw new BadRequestException("$msg");
            }
        }

    }

    public function editRate(){
        UserController::validateForLoggedUser();
        if (isset($_POST["saveChanges"])) {

            if (empty($_POST["comment"]) || empty($_POST["rating"])) {
                $msg = "All fields are required!";
            }elseif($this->commentValidation($_POST["comment"])){
                $msg = "Invalid comment!";
            }elseif($this->ratingValidation($_POST["rating"])){
                $msg = "Invalid rating!";
            }

            if ($msg == "") {

                //TODO validate for rating id if is for this user and if exist on DB


                // TODO exeption
                $ratingDAO=new RatingDAO();
                $ratingDAO->editRating($_POST["rating_id"], $_POST["rating"], $_POST["comment"]);
                include_once "view/myRated.php";

            }
        }else{
            throw new BadRequestException("$msg");

        }
    }

    public function showStars($product_id){

// TODO exeption

        $ratingDAO=new RatingDAO();
        $product_stars=$ratingDAO->getStarsCount($product_id);


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



    public function commentValidation($comment){
        $err=false;
        if (strlen($comment) < 4 || strlen($comment)>200) {
            $err=true;
        }
        return $err;
    }

    public function ratingValidation($rating){
        $err=false;
        if (!is_numeric($rating) || !preg_match('/^[1-5]+$/', $rating)) {
            $err=true;
        }
        return $err;
    }

    public function myRated(){
        UserController::validateForLoggedUser();
        $ratingDAO=new RatingDAO();
        $myRatings=$ratingDAO::showMyRated($_SESSION["logged_user_id"]);
        include_once "view/myRated.php";
    }

    public function rateProduct()
    {
        UserController::validateForLoggedUser();

        include_once "view/rateProduct.php";
    }

    public function editRatedPage()
    {
        UserController::validateForLoggedUser();

        include_once "view/editRatedProduct.php";
    }
}
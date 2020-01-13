<?php
namespace controller;
use model\RatingDAO;


class ratingController
{


    public function rate(){
       $userController=new UserController();
        $userController->validateForLoggedUser();
        if (isset($_POST["save"])) {
            $msg=$this->validateCommentsAndRating($_POST["comment"],$_POST["rating"]);

            if ($msg == "") {
                try{
                    $ratingDAO=new RatingDAO();
                    $ratingDAO->addRating($_SESSION["logged_user_id"], $_POST["product_id"], $_POST["rating"], $_POST["comment"]);
                    header("Location:index.php");
                }catch (\PDOException $e){
                    include_once "view/main.php";
                    echo "Oops, error 500!";

                }
            }
        }

    }

    public function editRate(){

        if (isset($_POST["saveChanges"])) {

            $msg=$this->validateCommentsAndRating($_POST["comment"],$_POST["rating"]);
            if ($msg == "") {

                try{
                    $ratingDAO=new RatingDAO();
                    $ratingDAO->editRating($_POST["rating_id"], $_POST["rating"], $_POST["comment"]);
                    include_once "view/myRated.php";
                }catch (\PDOException $e){
                    include_once "view/main.php";
                    echo "Oops, error 500!";

                }
            }
        }
    }

    public function showStars($product_id){


        try{
            $ratingDAO=new RatingDAO();
            $product_stars=$ratingDAO->getStarsCount($product_id);
        }catch (\PDOException $e){
            include_once "view/openPage.php";
            echo "Oops, error 500!";

        }

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

    public function validateCommentsAndRating($comment,$rating){
        $msg = "";
        if (empty($rating) || empty($comment)) {
            $msg = "All fields are required!";
        }
        if (!preg_match('/^[1-5]+$/', $rating) || !is_numeric($rating)) {
            $msg = "Rating must be from 1 to 5!";
        }
        if (strlen($comment) < 4) {
            $msg = "Comment must be minimum 10 characters!";
        }
        if (strlen($comment) > 100) {
            $msg = "Comment must be maximum 100 characters!";
        }
        return $msg;

    }

    public function myRated()
    {
        include_once "view/myRated.php";
    }

    public function rateProduct()
    {
        include_once "view/rateProduct.php";
    }

    public function editRatedPage()
    {
        include_once "view/editRatedProduct.php";
    }
}
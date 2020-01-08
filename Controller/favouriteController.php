<?php
namespace Controller;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use Controller\ProductController;
use model\FavouriteDAO;

class FavouriteController{
    public function show(){
        userController::validateForLoggedUser();
        include_once "View/favourites.php";
    }
    public function add(){
        if (isset($_GET["id"])){
            if (isset($_SESSION["logged_user_id"])){
                $check = FavouriteDAO::checkIfInFavourites($_GET["id"] , $_SESSION["logged_user_id"]);

                if ($check){
                    echo "Already added in Favourites";
                }
                else{
                    FavouriteDAO::addToFavourites($_GET["id"]);


                }
            }
        }
    }
    public function delete(){
        if (isset($_GET["id"])){
            FavouriteDAO::deleteFromFavourites($_GET["id"]);
            $this->show();
        }
        else{
            echo "asdasdas";
        }
    }
}
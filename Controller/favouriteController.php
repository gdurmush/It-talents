<?php
namespace Controller;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once dirname(__FILE__) . "/../Model/DBManager.php";
use Controller\ProductController;
use model\FavouriteDAO;

class FavouriteController{
    public function show(){
        include_once "View/favourites.php";
    }
    public function add(){
        if (isset($_GET["id"])){
            $check = FavouriteDAO::checkIfInFavourites($_GET["id"]);

            if ($check){
                echo "Already added in Favourites";
            }
            else{
                FavouriteDAO::addToFavourites($_GET["id"]);


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
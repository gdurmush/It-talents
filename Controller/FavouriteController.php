<?php
namespace controller;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use model\FavouriteDAO;

class FavouriteController{
    public function show(){
        $userController=new UserController();
        if(!isset($_SESSION["logged_user_id"])){
            include_once "view/login.php";
        }else{
            include_once "view/favourites.php";
        }

    }


    public function add(){
        if (isset($_GET["id"])){
            try{
                if (isset($_SESSION["logged_user_id"])){
                    $favoriteDAO=new FavouriteDAO();
                    $check = $favoriteDAO->checkIfInFavourites($_GET["id"] , $_SESSION["logged_user_id"]);

                    if ($check){
                        echo "Already added in Favourites";
                    }
                    else{
                        $favoriteDAO->addToFavourites($_GET["id"]);
                        include_once "view/favourites.php";
                    }
                }
            }catch (\PDOException $e){
                include_once "view/openPage.php";
                echo "Oops, error 500!";

            }
        }
    }


    public function delete(){
        if (isset($_GET["id"])){
            try{
                $favoriteDAO=new FavouriteDAO();
                $favoriteDAO->deleteFromFavourites($_GET["id"]);
                $this->show();
            }catch (\PDOException $e){
                include_once "view/openPage.php";
            echo "Oops, error 500!";
            }

        }else{
            echo "Bad request!";
        }
    }
}
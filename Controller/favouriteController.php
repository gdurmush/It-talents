<?php
namespace Controller;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once dirname(__FILE__) . "/../Model/DBManager.php";
class FavouriteController{
    public function show(){
        include_once "View/favourites.php";
        $favourites = showFavourites();
        foreach ($favourites as $favourite){
            echo $favourite["product_id"];
            ?>
        <a href="index.php?target=favourite&action=delete&id=<?=$favourite["product_id"]?>"><button>Remove</button></a>
            <?php
        }
    }
    public function add(){
        if (isset($_GET["id"])){
            addToFavourites($_GET["id"]);
        }

    }
    public function delete(){
        if (isset($_GET["id"])){
            deleteFromFavourites($_GET["id"]);
            $this->show();
        }
        else{
            echo "asdasdas";
        }
    }
}
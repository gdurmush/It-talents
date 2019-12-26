<?php
namespace Controller;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once dirname(__FILE__) . "/../Model/DBManager.php";

class CartController{
    public function add(){
        if (isset($_GET["id"])){
           $check = checkIfInCart($_GET["id"]);
           if ($check){
                updateQuantityOfProduct($_GET["id"]);
           }
           else{
               try {
                   putInCart($_GET["id"]);
               }
               catch (PDOException $exception){

               }
           }
        }
    }
}
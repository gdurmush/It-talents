<?php
namespace controller;

use model\Address;
use model\AddressDAO;


class AddressController{
    public function add(){
        $err=false;
        $msg='';
        if(isset($_POST["add"])){
            if(isset($_POST["city"]) && isset($_POST["street"])){

                $address=new Address($_SESSION["logged_user_id"],$_POST["city"],$_POST["street"]);

                try{
                    $addressDAO=new AddressDAO();
                    $addressDAO->add($address);

                }catch (\PDOException $e){
                    include_once "view/main.php";
                    echo "Oops, error 500!";
                }

                header("Location: index.php?target=user&action=account");
            }else{
                $err=true;
                $msg='All field are required';
            }
        }
    }
    public function edit(){
        $err=false;
        $msg='';
        if(isset($_POST["save"])){
            if(isset($_POST["city"]) && isset($_POST["street"])){
                $address=new Address($_SESSION["logged_user_id"],$_POST["city"],$_POST["street"]);
                $address->setId($_POST["address_id"]);

                try{
                    $addressDAO=new AddressDAO();
                    $addressDAO->edit($address);

                }catch (\PDOException $e){
                    include_once "view/main.php";

                    echo "Oops, error 500!";
                }

               include_once "view/account.php";
            }else{
                $err=true;
                $msg='All field are required';
            }

        }
    }

    public function delete(){
        if(isset($_POST["deleteAddress"])){
            try{
                $addressDAO=new AddressDAO();
                $addressDAO->delete($_POST["address_id"]);

            }catch (\PDOException $e){
                include_once "view/main.php";

                echo "Oops, error 500!";
            }


            include_once "view/account.php";
        }
    }

    public function newAddress(){
        include_once "view/newAddress.php";
    }
    public function editAddress(){
        include_once "view/editAddress.php";
    }

    public static function checkUserAddress(){

        try{

            $check = new AddressDAO;
            return $check->userAddress($_SESSION["logged_user_id"]);

        }catch (\PDOException $e){
            include_once "view/main.php";
            echo "Oops, error 500!";
        }

    }
}
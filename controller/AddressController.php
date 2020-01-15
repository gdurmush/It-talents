<?php
namespace controller;

use exception\BadRequestException;
use model\Address;
use model\AddressDAO;


class AddressController{
    public function add(){
        UserController::validateForLoggedUser();
        $err=false;
        $msg='';
        if(isset($_POST["add"])){
            if(empty($_POST["city"]) || empty($_POST["street"])) {
                $msg = 'All fields are required!';
            }elseif(!$this->validateCity($_POST["city"])){
                $msg="Invalid city!";
            }
            if($msg==""){

                $address=new Address($_SESSION["logged_user_id"],$_POST["city"],$_POST["street"]);
                $addressDAO=new AddressDAO();
                $addressDAO->add($address);
                //TODO Exeption
                header("Location: index.php?target=user&action=account");
            }else{
                include_once "view/newAddress.php";
            }

        }
    }
    public function edit(){
        UserController::validateForLoggedUser();
        $err=false;
        $msg='';
        if(isset($_POST["save"])){
            if(empty($_POST["city"]) || empty($_POST["street"])) {
                $msg = 'All fields are required!';
            }elseif(!$this->validateCity($_POST["city"])){
                $msg="Invalid city!";
            }
            if($msg==""){
                $address=new Address($_SESSION["logged_user_id"],$_POST["city"],$_POST["street"]);
                $address->setId($_POST["address_id"]);

                $addressDAO=new AddressDAO();
                $addressDAO->edit($address);
                //TODO Exeption


                header("Location: index.php?target=user&action=account");
            }else{

                throw new BadRequestException("$msg");
            }

        }
    }


//DONE delete validation if this address is used for previous orders
    public function delete(){
        UserController::validateForLoggedUser();
        if(isset($_POST["deleteAddress"])){

            $addressDAO=new AddressDAO();
            $addressDAO->delete($_POST["address_id"]);
//TODO Exeption



            header("Location: index.php?target=user&action=account");
        }
    }

    public function validateCity($cityId){
        $err=false;
        //TODO Exeption
        $addressDAO=new AddressDAO();
        $addresses=$addressDAO->getCities();
        if(!in_array($cityId,$addresses)){
            $err=true;
        }
        return $err;
    }

    public function newAddress(){
        UserController::validateForLoggedUser();
        include_once "view/newAddress.php";
    }
    public function editAddress(){
        UserController::validateForLoggedUser();
        $addressDAO=new AddressDAO;
        $address=$addressDAO->getById($_POST["address_id"]);
        include_once "view/editAddress.php";

    }

    public function getCities(){
        $addressDAO=new AddressDAO;
        return $addressDAO->getCities();
    }



    public static function checkUserAddress(){
        UserController::validateForLoggedUser();


        $check = new AddressDAO;
        return $check->userAddress($_SESSION["logged_user_id"]);

    }
}
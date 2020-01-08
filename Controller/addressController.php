<?php
namespace Controller;


use Model\Address;
use Model\AddressDAO;
use model\ProductDAO;



class addressController{
    public function add(){
        $err=false;
        $msg='';
        if(isset($_POST["add"])){
            if(isset($_POST["city"]) && isset($_POST["street"])){
                $address=new Address($_SESSION["logged_user_id"],$_POST["city"],$_POST["street"]);
               AddressDAO::add($address);
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
                AddressDAO::edit($address);
               header("Location: index.php?target=user&action=account");
            }else{
                $err=true;
                $msg='All field are required';
            }

        }
    }

    public function delete(){
        if(isset($_POST["deleteAddress"])){
            AddressDAO::delete($_POST["address_id"]);
            header("Location: index.php?target=user&action=account");
        }
    }

    public function newAddress(){
        include_once "View/newAddress.php";
    }
    public function editAddress(){
        include_once "View/editAddress.php";
    }
}
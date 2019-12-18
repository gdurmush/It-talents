<?php
include_once "../Model/DBManager.php";

define("MIN_LENGTH",8);

if(isset($_POST["login"])){

    $err=false;

    if(!isset($_POST["email"]) || !isset($_POST["password"])){
        $err=true;

    }elseif(strlen($_POST["password"])<MIN_LENGTH){
        $err=true;
    }else{
        $user=existUser($_POST["email"]);
        if(password_verify($_POST["password"],$user["password"])){
            $_SESSION["logged_user_id"]=$user["id"];
            include_once "../View/main.php";

        }else{
            $err=true;

        }

    }

    if(!$err){
        include_once "../View/main.php";
    }else{
        include_once "../View/login.php";
    }
}


if(isset($_POST["register"])){

    $err=false;
    $msg='';

    if(!isset($_POST["email"]) || !isset($_POST["password"])
        || !isset($_POST["first_name"]) || !isset($_POST["last_name"])
        || !isset($_POST["phone_number"])){

        $err=true;
        $msg="All fields are required!";
    }

    if(strlen($_POST["password"])<MIN_LENGTH){
        $err=true;
        $msg="Your password must be at least 8 characters!";
    }

    if(!preg_match('/^[0-9]{10}$/', $_POST["phone_number"])) {
        $err=true;
        $msg="Invalid Number!";
    }

    if(existUser($_POST["email"])){
        $err=true;
        $msg="This email already exist!";
    }
    if(!$err){
        $user=[];
        $user["email"]=$_POST["email"];
        $user["password"]=password_hash($_POST["password"],PASSWORD_BCRYPT);
        $user["first_name"]=$_POST["first_name"];
        $user["last_name"]=$_POST["last_name"];
        $user["phone_number"]=$_POST["phone_number"];

        addUser($user);
        $_SESSION["logged_user_id"]=$user["id"];

    }




    if($err){
        include_once "../View/register.php";
    }else{
        include_once "../View/main.php";
    }
}
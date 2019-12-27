<?php

namespace Controller;


use Model\User;
use Model\UserDAO;
define("MIN_LENGTH",8);
class UserController{



    public function login(){
        $email=$_POST["email"];
        $password=$_POST["password"];
        $err=false;

        if(!isset($email) || !isset($password)){
            $err=true;

        }elseif(strlen($password)<MIN_LENGTH){
            $err=true;
        }else{
            $dao=new UserDAO();
            $result=$dao->getByEmailPassword($email);
            if($result){

                if(password_verify($_POST["password"],$result["password"])){
                    $_SESSION["logged_user_id"]=$result["id"];


                }else{
                    $err=true;

                }
            }

        }

        if(!$err){
            include_once "View/main.php";
        }else{
            include_once "View/login.php";
        }


    }

    public function register(){

        $err=false;
        $msg='';

        if(!isset($_POST["email"]) || !isset($_POST["password"])
            || !isset($_POST["first_name"]) || !isset($_POST["last_name"])
            || !isset($_POST["phone_number"]) || !isset($_POST["age"]) ){

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
        if($_POST["age"]<18) {
            $err=true;
            $msg="You must be at least 18 years old to create account!";
        }

        $dao=new UserDAO();
        $result=$dao->getByEmailPassword($_POST["email"]);
        if($result){
            $err=true;
            $msg="This email already exist!";
        }
        if(!$err){
            $user=new User();
            $user->email=$_POST["email"];
            $user->password=password_hash($_POST["password"],PASSWORD_BCRYPT);
            $user->first_name=$_POST["first_name"];
            $user->last_name=$_POST["last_name"];
            $user->age=$_POST["age"];
            $user->phone_number=$_POST["phone_number"];
            $user->is_admin=false;
            $dao->add($user);



            include_once "View/main.php";
        }else{
            include_once "View/register.php";
        }

    }
}
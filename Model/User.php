<?php

namespace Model;
class User
{
    private $id;
    private $email;
    private $password;
    private $first_name;
    private $last_name;
    private $age;
    private $phone_number;
    private $role;
    //private $date_created;


    public function __construct($email,$password,$first_name,$last_name,$age,$phone_number,$role){

        $this->email=$email;
        $this->password=$password;
        $this->first_name=$first_name;
        $this->last_name=$last_name;
        $this->age=$age;
        $this->phone_number=$phone_number;
        $this->role=$role;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }


    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }
    public function getFirstName()
    {
        return $this->first_name;
    }


    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }
    public function getLastName()
    {
        return $this->last_name;
    }



    public function getAge()
    {
        return $this->age;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }


    public function getRole()
    {
        return $this->role;
    }


}
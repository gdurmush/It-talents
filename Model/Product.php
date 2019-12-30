<?php

namespace model;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Product{
protected $id;
public $name;
protected $producerId;
public $price;
protected $typeId;
public $quantity;
public $imageUrl;


function __construct($name , $producerId , $price , $typeId , $quantity ,$imageUrl)
    {

        $this->name=$name;
        $this->producerId = $producerId;
        $this->price=$price;
        $this->typeId=$typeId;
        $this->quantity=$quantity;
        $this->imageUrl=$imageUrl;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getProducerId()
    {
        return $this->producerId;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

function show(){
   $product = findProduct($this->id);
   echo $product->name;
   ?> <img src="<?= $product->imageUrl ?>"width="150"></a>
    <form action="index.php?target=cart&action=add&id=<?=$product->id?>" method="post">
        <input type="submit" value="Add to cart" name="addToCart">
    </form>
    <form action="index.php?target=favourite&action=add&id=<?=$product->id?>" method="post">
        <input type="submit" value="Add to Favourites" name="addToFavourites">
    </form>
<?php
}

}
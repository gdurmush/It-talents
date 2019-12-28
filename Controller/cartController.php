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

    public function show(){
        include_once "View/cart.php";
        $productsInCart = showCart();
        foreach ($productsInCart as $product){
            $productInfo = findProduct($product["product_id"]);
            ?>  <img src="<?= $productInfo->imageUrl ?>"width="150"></a><?php
            echo  $productInfo->name;
            ?>
            <div class="form-group">
            <form action="index.php?target=cart&action=update" method="post">
            <input type="hidden" value="<?=$product["product_id"]?>" name="productId">
            <input type="number" value="<?=$product["quantity"] ?>" name="quantity">
            <input type="submit" name="updateQuantity" value="Update">
            </form>
            <form action="index.php?target=cart&action=delete" method="post">
                <input type="hidden" value="<?=$product["product_id"]?>" name="productId">
                <input type="submit" value="Delete" name="deleteFromCart">
            </form>
                <form action="index.php?target=favourite&action=add&id=<?=$product["product_id"]?>" method="post">
                    <input type="submit" value="Add to Favourites" name="addToFavourites">
                </form>
                <?php
                 echo $productInfo->price*$product["quantity"]. "Euro";

            ?></div>
            <?php
        }
    }
    public function update(){
        updateCartQuantity($_POST["productId"] , $_POST["quantity"]);
        $this->show();
    }
    public function delete(){
        deleteProductFromCart($_POST["productId"]);
        $this->show();
    }
}
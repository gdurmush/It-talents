<?php

include_once "View/search.php";

use Model\AddressDAO; ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"
<h1>Your Cart</h1>
      <?php
      $productsInCart = showCart();
      $totalprice = 0;
      foreach ($productsInCart as $product)
      {
      $productInfo = findProduct($product["product_id"]);
      $totalprice+=$product["quantity"]*$productInfo->price;
    ?>
    <div class="form-group">
          <img src="<?= $productInfo->imageUrl ?>"width="150"></a><?php
          echo  $productInfo->name;
          ?>
    <form action="index.php?target=cart&action=update" method="post">
        <input type="hidden" value="<?=$product["product_id"]?>" name="productId">
        <input type="number" value="<?=$product["quantity"] ?>" name="quantity">
        <input type="submit" name="updateQuantity" value="Update">
    </form>
    <a href="index.php?target=cart&action=delete&productId=<?=$product["product_id"]?>"><button>Delete</button></a>

    <a href="index.php?target=favourite&action=add&id=<?=$product["product_id"]?>"><button>Add To Favourites</button></a>
          <?php
                 echo $productInfo->price*$product["quantity"]. "Euro";
            ?></div><?php
        }
        echo "Total price : ". $totalprice . "Leva";

        $myAddresses =  AddressDAO::getAll($_SESSION["logged_user_id"]);
        ?>
    <form action="index.php?action=order&target=order" method="post">
        Delivery Address
        <select name="address">
            <?php foreach ($myAddresses as $address){
                $add = AddressDAO::getById($address->id);
                echo "<option value='$address->id'>$add->city_name , $add->street_name , Bulgaria</option>";
            }

            ?></select>
        <?php if($totalprice !=0){ ?>
        <input type="hidden" value="<?=$totalprice?>" name="totalPrice">
        <input type="submit" value="Order Items" name="order">
    </form>
<?php }




<?php
namespace View;
use model\AddressDAO;
use model\CartDAO;
use model\FavouriteDAO;
use model\ProductDAO;
include_once "View/search.php";
?>
<h1>Your Cart</h1>
      <?php
      $productsInCart = CartDAO::showCart();
      $totalprice = 0;
      foreach ($productsInCart as $product)
      {
      $productInfo = ProductDAO::findProduct($product["product_id"]);
      $totalprice+=$product["quantity"]*$productInfo->price;
    ?>
    <class="form-group">
          <img src="<?= $productInfo->imageUrl ?>"width="150"></a><?php
          echo  $productInfo->name;
          ?>
    <form action="index.php?target=cart&action=update" method="post">
        <input type="hidden" value="<?=$product["product_id"]?>" name="productId">
        <input type="number" value="<?=$product["quantity"] ?>" name="quantity">
        <input type="submit" name="updateQuantity" value="Update">
    </form>
    <a href="index.php?target=cart&action=delete&productId=<?=$product["product_id"]?>"><button>Delete</button></a>
    <?php if (FavouriteDAO::checkIfInFavourites($productInfo->id , $_SESSION["logged_user_id"])){?>
          <td><a href="index.php?target=favourite&action=delete&id=<?=$productInfo->id?>"><button>Remove From Favourites</button></a></td>

   <?php }
   else{?>
   <a href="index.php?target=favourite&action=add&id=<?=$productInfo->id?>"><button>Add To Favourites</button></a><?php
   }
                 echo $productInfo->price*$product["quantity"]. "Лв.";
            ?></div><br><?php
        }
        echo "Total price : ". $totalprice . "Лв.";

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




?>

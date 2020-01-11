<?php
namespace view;

use model\FavouriteDAO;
use model\ProductDAO;


try{
    $favouriteDAO=new FavouriteDAO();
    $favourites = $favouriteDAO->showFavourites();

    foreach ($favourites as $favourite) {
        $productDAO=new ProductDAO();
        $product = $productDAO->findProduct($favourite["product_id"])
        ?>
        <body>
    <table>
        <tr>
            <td><img src="<?= $product->imageUrl ?>" width="150"></td>
        </tr>
        <tr>
            <td><?=$product->name?></td>
        </tr>
        <tr>
            <td><a href="index.php?target=cart&action=add&id=<?= $product->id ?>">
                    <button>Add to cart</button>
                </a></td>
        </tr>
        <tr>
            <td><a href="index.php?target=favourite&action=delete&id=<?= $product->id ?>">
                    <button>Remove From Favourites</button>
                </a></td>
        </tr>
    </table>
        <?php
    }

}catch (\PDOException $e){
    include_once "view/main.php";
    echo "Oops, error 500!";

}
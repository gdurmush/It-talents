<?php
namespace View;

use model\FavouriteDAO;
use Controller\ProductController;
use model\RatingDAO;



$review=RatingDAO::getReviewsNumber($this->id);
$status=ProductController::checkIfIsInPromotion($this->id);


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="View/product.js"></script>
<div>
    <tr>
        <td><h3> <?=$this->name ?></h3></td>
    </tr>
    <tr>
        <td><img src="<?= $this->imageUrl ?>"width="150"></td>

    </tr>
    <tr>
        <td><?= $review->reviews_count ?> reviews</td>
    </tr>

    <tr>
        <td>Average grade: <?= $review->avg_stars?></td>
    </tr>


    <tr>
        <td><?= $status["is_in_stock"] ?> </td>
    </tr>

    <?php if($status["in_promotion"]){
        ?>
        <tr>
            <td>Old Price:</td>
            <td><?=$status["old_price"] ?> EURO</td>
        </tr>
        <tr>
            <td>New Price:</td>
            <td><?= $this->price ?> EURO</td>
        </tr>
        <tr>
            <td>Discount:</td>
            <td><?= $status["discount"] ?> %</td>
        </tr>
        <?php
    }else{
        ?>
        <tr>
            <td>Price:</td>
            <td><?= $this->price ?> EURO</td>
        </tr>
        <?php
    }?>


    <?php if(isset($_SESSION["logged_user_role"]) && $_SESSION["logged_user_role"]=="admin"){?>
        <tr>
            <form action="index.php?target=product&action=editProduct" method="post">
                <input type="hidden" name="product_id" value="<?= $this->id ?>">
                <input type="submit" name="editProduct" value="Edit this product">
            </form>
        </tr>
    <?php }
    else{
    ?>
    <?php if (isset($_SESSION["logged_user_role"])){
        ?>
        <tr>
            <td><a href="index.php?target=cart&action=add&id=<?=$this->id?>"><button>Добави в количка</button> </a></td>
        </tr>
        <?php
        if (FavouriteDAO::checkIfInFavourites($this->id , $_SESSION["logged_user_role"]))
        {
            ?>
            <tr>
                <td><a href="index.php?target=favourite&action=delete&id=<?=$this->id?>"><button>Премахни от любими</button></a></td>
            </tr>
            <?php
        }
        else{
            ?>
            <tr>
                <td>
                    <a href="index.php?target=favourite&action=add&id=<?=$this->id?>"><img src="icons/like.svg" width="50" height="50"></a>
                </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td><a href="index.php?target=product&action=rateProduct&id=<?=$this->id?>"><button>Оцени този продукт</button></a></td>
        </tr>
        <?php
    }
    else {
        ?>
        <tr>
            <td><a href="index.php?target=user&action=loginPage"><button>Добави в количка</button> </a></td>
        </tr>
        <tr>
            <td>
                <a href="index.php?target=user&action=loginPage"><img src="icons/like.svg" width="50" height="50"></a>
            </td>
        </tr>
</div>
        <?php
    }
    ?>
<?php }?>


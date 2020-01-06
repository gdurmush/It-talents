<?php
namespace View;
use model\FavouriteDAO;
use Model\ProductDAO;
use Controller\ProductController;
$avgStars=ProductDAO::getAVGRating($this->id);
$countOfStars=ProductController::showStars($this->id);
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
<table>
    <tr>
       <td><h3> <?=$this->name ?></h3></td>
    </tr>
    <tr>
        <td><img src="<?= $this->imageUrl ?>"width="150"></td>
        <td>Цена :<?=$this->price ?> Лв.</td>
    </tr>



            <?php if(isset($_SESSION["logged_user_role"]) && $_SESSION["logged_user_role"]=="admin"){?>
    <tr>
                <form action="index.php?target=product&action=editProduct" method="post">
                    <input type="hidden" name="productId" value="<?= $this->id ?>">
                    <input type="submit" name="editProduct" value="Edit this product">
                </form>
    </tr>
           <?php }
             else{
            ?>
    <tr>
        <td><a href="index.php?target=cart&action=add&id=<?=$this->id?>"><button>Добави в количка</button> </a></td>
    </tr>
    <?php
    if (FavouriteDAO::checkIfInFavourites($this->id))
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
</table>
           <?php }?>
<table>
    <tr><td>Average grade: <?= $avgStars->avg_stars?></td></tr>
    <?php foreach ($countOfStars as $key=>$countOfStar) {
        echo "<tr><td>Rate with $key stars:  $countOfStar</td></tr>";
    }
    ?>
</table>
</body>
</html>

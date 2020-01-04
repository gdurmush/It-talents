<?php
namespace View;
use Model\ProductDAO;
$avgStars=ProductDAO::getAVGRating($this->id);
$countOfStars=ProductDAO::getStarsCount($this->id);

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
        <td><img src="<?= $this->imageUrl ?>"width="150"></td>
    </tr>
    <tr>
        <td><a href="index.php?target=cart&action=add&id=<?=$this->id?>"><button>Add to cart</button> </a></td>
    </tr>
    <?php
    if (checkIfInFavourites($this->id)){
        ?>
        <tr>
            <td><a href="index.php?target=favourite&action=delete&id=<?=$this->id?>"><button>Remove From Favourites</button></a></td>
        </tr>
        <?php
    }
    else{
        ?>
        <tr>
        <td><a href="index.php?target=favourite&action=add&id=<?=$this->id?>"><img src="icons/like.svg" width="50" height="50"></a></td>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td><a href="index.php?target=product&action=rateProduct&id=<?=$this->id?>"><button>Rate this product</button></a></td>
    </tr>
</table>
<table>
    <tr><td>Average grade: <?= $avgStars->avg_stars?></td></tr>
    <?php foreach ($countOfStars as $countOfStar) {
        echo "<tr><td>Rate with $countOfStar->stars stars:  $countOfStar->stars_count</td></tr>";
    }
    ?>

</table>
</body>
</html>

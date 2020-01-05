<?php
namespace View;
use Controller\ratingController;
use Model\FavouriteDAO;
use Controller\ProductController;
use Model\RatingDAO;

$review=RatingDAO::getReviewsNumber($this->id);
$countOfStars=ratingController::showStars($this->id);
$comments=RatingDAO::getComments($this->id);
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
<table>
    <tr>
        <td><?= $this->name ?></td>
    </tr>
    <tr>
        <td><img src="<?= $this->imageUrl ?>"width="150"></td>
    </tr>
    <tr>
        <td><?= $review->reviews_count ?> reviews</td>
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

   

            <?php if(isset($_SESSION["logged_user_role"]) && $_SESSION["logged_user_role"]=="admin"){
                ?>
    <tr>
                <form action="index.php?target=product&action=editProduct" method="post">
                    <input type="hidden" name="product_id" value="<?= $this->id ?>">
                    <input type="submit" name="editProduct" value="Edit this product">

                </form>
    </tr>
           <?php }else{
            ?>

    <tr>
        <td><a href="index.php?target=cart&action=add&id=<?=$this->id?>"><button>Add to cart</button> </a></td>
    </tr>
    <?php
    if (FavouriteDAO::checkIfInFavourites($this->id))
    {
        ?>
        <tr>
            <td><a href="index.php?target=favourite&action=delete&id=<?=$this->id?>"><button>Remove From Favourites</button></a></td>
        </tr>
        <?php
    }
    else{
        ?>
        <td><a href="index.php?target=favourite&action=add&id=<?=$this->id?>"><img src="icons/like.svg" width="50" height="50"></a></td>

        </tr>
        <?php
        }
    ?>
    <tr>
        <td><a href="index.php?target=rating&action=rateProduct&id=<?=$this->id?>"><button>Rate this product</button></a></td>
    </tr>
</table>
           <?php }?>
<table>
    <tr>
        <td>Average grade: <?= $review->avg_stars?></td>
    <?php foreach ($countOfStars as $key=>$countOfStar) {
        echo "<tr><td>Rate with $key stars:  $countOfStar</td></tr>";
    }
    ?>
    </tr>
</table>
<hr>

<?php
if($review->reviews_count==0){
    echo"<h3>There is no comments for this product!</h3>";
}else{
    echo"<h3>Comments:</h3>";
}?>



    <?php foreach ($comments as $comment) {
        ?>
    <table>
        <tr>
            <td>Name:</td>
            <td><?= $comment->full_name ?></td>
        </tr>
        <tr>
            <td>Date:</td>
            <td><?= $comment->date ?></td>
        </tr>
        <tr>
            <td>Stars:</td>
            <td><?= $comment->stars ?> stars</td>
        </tr>
        <tr>
            <td>Opinion:</td>
            <td><?= $comment->text ?></td>
        </tr>

       </table>
        <hr>
        <?php
    } ?>

</body>
</html>

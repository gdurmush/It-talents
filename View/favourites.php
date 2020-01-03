<?php
$favourites = showFavourites();
foreach ($favourites as $favourite){
    echo $favourite["product_id"];
    ?>
    <a href="index.php?target=favourite&action=delete&id=<?=$favourite["product_id"]?>"><button>Remove</button></a>
    <?php
}
?>
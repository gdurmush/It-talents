<?php
$products = showOrders();
foreach ($products as $product){
    ?>
    <table class="form-group">
        <tr>
            <td width="80"><?=$product["name"]?></td>
            <td><img src="<?=$product["image_url"]?>" width="150"></td>
            <td><?="Quantity :". $product["quantity"]?></td>
            <td><?= "Date of order : ".substr($product["date_created"]  , 0 , 10)?></td>
        </tr>
    </table>
<?php
}
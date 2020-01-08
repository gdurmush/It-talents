<script src="View/filter.js"></script>
<?php
//echo "<h1>" .$type->name . "</h1>";
use model\ProductDAO;
$attributeNames = ProductDAO::getProductAttributes($_GET["typId"]);
foreach ($attributeNames as $attributeName){
echo $attributeName["name"]."<br>";
$attributeValues = ProductDAO::getAttributeValues($_GET["typId"] , $attributeName["name"]);
?><?php
foreach ($attributeValues as $attributeValue){
?><div data-filter="<?=$attributeName["name"] ?>">
    <div>
    <input type="checkbox" value="<?=$attributeValue["value"]?>"><?=$attributeValue["value"] . "<br>"?>
    </div>
    <?php
        }
    }
    ?><button name="filter" id="filter">Filter</button>
</div>

<select onchange="if (this.value) window.location.href=this.value">
    <option value="">Order By:</option>
    <option value="index.php?target=product&action=show&typId=<?=$_GET["typId"]?>&order=asc">MinPrice</option>
    <option value="index.php?target=product&action=show&typId=<?=$_GET["typId"]?>&order=desc">MaxPrice</option>
</select>

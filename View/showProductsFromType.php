<?php
echo "<h1>" .$type->name . "</h1>";

?>
<select onchange="if (this.value) window.location.href=this.value">
    <option value="">Order By:</option>
    <option value="index.php?target=product&action=show&typId=<?=$_GET["typId"]?>&order=asc">MinPrice</option>
    <option value="index.php?target=product&action=show&typId=<?=$_GET["typId"]?>&order=desc">MaxPrice</option>
</select>

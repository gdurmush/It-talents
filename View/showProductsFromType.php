<?php
namespace view;

use model\ProductDAO;

try{
?>


    <script src="View/filter.js"></script>


    <select onchange="if (this.value) window.location.href=this.value">
        <option value="">Order By:</option>
        <option value="index.php?target=product&action=show&typId=<?=$_GET["typId"]?>&order=asc">MinPrice</option>
        <option value="index.php?target=product&action=show&typId=<?=$_GET["typId"]?>&order=desc">MaxPrice</option>
    </select>
    </div>
    </div>
    </div>
<?php
}catch (\PDOException $e){
include_once "view/main.php";
echo "Oops, error 500!";

}

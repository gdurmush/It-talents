<?php
namespace view;



if(isset($filters)  && isset($products)&& isset($totalPages) && isset($page)) {


?>

<html lang="en">
<head>
    <link rel="icon" href="icons/favicon.png">
</head>
<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>eMAG</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<div class="container">
    <div class="row">
        <div class="col-2">
            <div class="card">
                <?php foreach ($filters->getFilter() as $filter) {
                    ?>
                    <article class="card-group-item">
                        <header class="card-header">
                            <h6 class="title"><?= $filter ?> </h6>
                        </header>
                        <div class="filter-content">
                            <div class="card-body">
                                <form>
                                    <?php foreach ($filters->getFilterValues() as $filterValue) {

                                        if ($filterValue->name == $filter) {
                                            ?>
                                            <label class="form-check">
                                                <input class="form-check-input" type="checkbox" value="">
                                                <span class="form-check-label" style="margin-left: 20px">
                                        <?= $filterValue->value ?>
                                    </span>
                                            </label>
                                        <?php }
                                    } ?>
                                    <!-- form-check.// -->

                                </form>

                            </div> <!-- card-body.// -->
                        </div>
                    </article> <!-- card-group-item.// -->
                <?php } ?>

            </div>

        </div>
        <div class="col-10">
            <div class="row">
                <?php foreach ($products as $product) {
                    ?>

                    <div class="col-3">

                        <div class="card">
                            <img class="card-img-top" src="<?= $product->image_url ?>" alt="Card image cap" height="200"
                                 width="40">
                            <div class="card-body">
                                <h5 class="card-title"><?= $product->name ?></h5>
                                <p class="card-text"><?= $product->price ?> EURO</p>
                                <a href="index.php?target=cart&action=add&id=<? $product->id ?>"
                                   class="btn btn-primary">Add to cart</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<nav aria-label="Page navigation example">
    <ul class="pagination">

        <?php if($page>1){
            $previousPage=--$page;
            ?>
            <li class="page-item"><a class="page-link" href="index.php?target=product&action=show&typId=<?= $_GET["typId"] ?>&page=<?=$previousPage?>">Previous</a></li>
            <?php
        }
        for ($i = 1; $i <= $totalPages + 1; $i++) {
            ?>
            <li class="page-item"><a class="page-link" href="index.php?target=product&action=show&typId=<?= $_GET["typId"] ?>&page=<?= $i ?>"><?= $i ?></a></li>
            <?php
        }
        if($page<$totalPages){
            $nextPage=++$page;
            ?>
            <li class="page-item"><a class="page-link" href="index.php?target=product&action=show&typId=<?= $_GET["typId"] ?>&page=<?=$nextPage?>">Next</a></li>

            <?php
        }
        ?>


    </ul>
</nav>
<?php
}else {
    include_once "index.php";
}

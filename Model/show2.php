
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
    <div class="container">
        <div class="row">
            <div class="col-xs-8">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h5><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h5>
                                </div>
                                <div class="col-xs-6">
                                    <a href="index.php">
                                        <button type="button" class="btn btn-primary btn-sm btn-block">
                                            <span class="glyphicon glyphicon-share-alt"></span> Continue shopping
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-2"><img class="img-responsive" src="<?= $productInfo->imageUrl ?>">
                            </div>
                            <div class="col-xs-4">
                                <h4 class="product-name"><strong><?= $productInfo->name?></strong></h4><h4><small>Product description</small></h4>
</div>
<div class="col-xs-6">
    <div class="col-xs-6 text-right">
        <h6><strong><?=$productInfo->price?>.00 <span class="text-muted">x</span></strong></h6>
    </div>
    <div class="col-xs-4">
        <input type="text" class="form-control input-sm" value="<?=$product["quantity"]?>">
    </div>
    <div class="col-xs-2">
        <a href="index.php?target=cart&action=delete&productId=<?=$productInfo->id?>">
            <button type="button" class="btn btn-link btn-xs">
                <span class="glyphicon glyphicon-trash"> </span>
            </button>
        </a>
    </div>
</div>
</div>
<div class="row">
    <div class="text-center">
        <div class="col-xs-9">
            <h6 class="text-right">Added items?</h6>
        </div>
        <div class="col-xs-3">
            <button type="button" class="btn btn-default btn-sm btn-block">
                Update cart
            </button>
            <button type="button" class="btn btn-primary btn-sm btn-block">
                <span class="glyphicon glyphicon-share-alt"></span> Continue shopping
            </button>
        </div>
    </div>
</div>
</div>
<div class="panel-footer">
    <div class="row text-center">
        <div class="col-xs-9">
            <h4 class="text-right">Total <strong><?=$totalprice. "лв."?></strong></h4>
        </div>
        <div class="col-xs-3">
            <button type="button" class="btn btn-success btn-block">
                Checkout
            </button>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
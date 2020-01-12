<?php
namespace view;


use controller\TypeController;
use model\TypeDAO;
use model\FavouriteDAO;
use controller\ProductController;
use model\RatingDAO;



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

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<div class="container">
    <div class="row">
        <div class="col-2">
            <div class="card">
                <article class="card-group-item">
                    <header class="card-header">
                        <h6 class="title">Brands </h6>
                    </header>
                    <div class="filter-content">
                        <div class="card-body">
                            <form>
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" value="">
                                    <span class="form-check-label">
				                        Mersedes Benz
				                    </span>
                                </label> <!-- form-check.// -->
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" value="">
                                    <span class="form-check-label">
				                        Nissan Altima
				                    </span>
                                </label>  <!-- form-check.// -->
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" value="">
                                    <span class="form-check-label">
				                        Another Brand
				                    </span>
                                </label>  <!-- form-check.// -->
                            </form>

                        </div> <!-- card-body.// -->
                    </div>
                </article> <!-- card-group-item.// -->

                <article class="card-group-item">
                    <header class="card-header">
                        <h6 class="title">Choose type </h6>
                    </header>
                    <div class="filter-content">
                        <div class="card-body">
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadio" value="">
                                <span class="form-check-label">
			                        First hand items
			                    </span>
                            </label>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadio" value="">
                                <span class="form-check-label">
			                        Brand new items
			                    </span>
                            </label>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadio" value="">
                                <span class="form-check-label">
			                        Some other option
			                    </span>
                            </label>
                        </div> <!-- card-body.// -->
                    </div>
                </article> <!-- card-group-item.// -->
            </div>

        </div>
        <div class="col-10">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <img class="card-img-top" src="..." alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <img class="card-img-top" src="..." alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <img class="card-img-top" src="..." alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <img class="card-img-top" src="..." alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <img class="card-img-top" src="..." alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

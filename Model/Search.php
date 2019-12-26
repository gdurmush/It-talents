<?php
namespace model;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Search{
    public  $search;
    private $products;
    private $categories;
    private $producers;

    function __construct($search)

    {
        $this->search = $search;
        $this->products = searchProduct($this->search);
        $this->categories = searchCategorie($this->search);
        $this->producers = searchProducer($this->search);
    }

    public function render(){
        if (isset($_POST["search"])){
            $search = new Search($_POST["search"]);
            $search->renderProducts();
            $search->renderCategories();
            $search->renderProducers();
        }

    }

    private function renderProducts(){
        if ($this->products){
            echo "<h1>Products </h1>";
        }
        else {
            echo "<h1>Not Found Results</h1>";
        }

        foreach ($this->products as $product) {
            ?>
            <h3><a href="index.php?target=product&action=show&prdId=<?=$product["id"]?>"> <?= $product["name"] ?></a></h3>
            <?php
        }
    }

    private function renderCategories(){
        if ($this->categories) {

            echo "<h1>Categories</h1>";
            foreach ($this->categories as $category) {
                ?>
                <h3><a href="index.php?target=product&action=show&id=<?=$category["id"]?>"> <?= $category["name"] ?></a></h3>
                <?php
            }
        }
    }

    private function renderProducers(){
        if ($this->producers) {

            echo "<h1>Producer</h1>";
            foreach ($this->producers as $producer) {
                ?>
                <h3><a href="index.php?target=product&action=show&id=<?= $producer["id"] ?>" ><?= $producer["name"] ?></a></h3>
                <?php
            }
        }
    }
}
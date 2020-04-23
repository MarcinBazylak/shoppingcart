<!DOCTYPE html>
<html lang="pl">
<head>
<link rel="stylesheet" href="style.css">
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Koszyk zakupowy</title>
</head>
<body>

<div class="wrapper">
<h1>Lista produktów</h1>

<?php

session_start();
if(!$_SESSION['basket']) {
   $_SESSION['basket'] = [];
}
include_once 'includes/db.php';
include_once 'classes/product.class.php';
include_once 'classes/basket.class.php';

$products = Product::getProducts();
$basket = new Basket;

if($_POST['submit']) {

   $prodId = htmlspecialchars($_POST['prod_id']);
   $quantity = htmlspecialchars($_POST['quant']);
   
   $basket->add($prodId, $quantity);

}

if($_GET['empty']) {
   $basket->empty();
}

//print_r($_SESSION['basket']);

foreach($products as $product) {
   $quantity = $product['quantity'] - $_SESSION['basket'][$product['id']]['prodQuantity'];
   echo '
   <form method="post" action="index.php">
      <input type="hidden" name="prod_id" value="'.$product['id'].'">
      <div class="product">         
         <div class="product-item">' . $product['name'] . '</div>
         <div class="product-item product-desc">' . $product['description'] . '</div>
         <div class="product-item product-desc">Cena: ' . $product['price'] . ' zł.</div>
         <div class="product-item product-desc">Dostępność: ' . $quantity . ' szt.</div>

         <div class="product-item"><input min="1" max="'.$quantity.'" class="input" name="quant" type="number" placeholder="ilość" required ';
         if($quantity == 0) {
            echo'disabled';
         }
         echo'> <input class="input" value="dodaj do koszyka" type="submit" name="submit" ';
         if($quantity == 0) {
            echo'disabled';
         }
         echo'></div>
      </div>
   </form>
   ';
}

if(count($_SESSION['basket']) > 0) {
   echo 'Produktów w koszyku: ' . count($_SESSION['basket']) . ' | ';
} else {
   echo 'Twój koszyk jest pusty | ';
}

?>
   <a href="basket.php">Pokaż koszyk</a> | <a href="index.php?empty=empty">Opróżnij koszyk</a>
</div>
   
</body>
</html>
<?PHP $mysqli->close(); ?>
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
<h1>Koszyk</h1>
<?php

session_start();
include 'includes/db.php';
include_once 'classes/basket.class.php';

$basket = new Basket;

if($_GET['empty']) {
   $basket->empty();
}

if($_GET['buy']) {
   $basket->buyAll();
}

if($_POST['submit']) {
   $basket->remove($_POST['prod_id']);
}

if(empty($_SESSION['basket'])) {
   $_SESSION['basket'] = array();
}

if(!empty($_SESSION['basket'])) {

   $totalQuant = 0;
   $totalPrice = 0;
   foreach($_SESSION['basket'] as $item) {

      $subTotalPrice = $item['prodQuantity']*$item['prodPrice'];

      echo '
   <form method="post" action="basket.php">
      <input type="hidden" name="prod_id" value="'.$item['prodId'].'">
      <div class="basket">         
         <div class="product-item product-name">' . $item['prodName'] . '</div>
         <div class="product-item product-id">Ilość: <b>' . $item['prodQuantity'] . ' szt.</b></div>
         <div class="product-item product-id">Cena: <b>' . $item['prodPrice'] . ' zł.</b></div>
         <div class="product-item product-id">Wartość: <b>' . $subTotalPrice . ' zł.</b></div>
         <div class="product-item product-input"><input class="input" value="usuń" type="submit" name="submit"></div>
      </div>
   </form>
   ';

      $totalQuant = $totalQuant + $item['prodQuantity'];
      $totalPrice = $totalPrice + $subTotalPrice;
   }

   echo '<br>Produktów w koszyku: ' . $totalQuant . ', na łączną kwotę ' . $totalPrice . ' zł.
   <br><a href="basket.php?buy=buy">Kup i zapłać</a> | <a href="basket.php?empty=empty">Opróżnij koszyk</a> | ';
} else {
   echo '<br>Twój koszyk jest pusty';
}

?>
<br><a href="index.php">Powrót do strony głównej</a>
</div>
   
</body>
</html>
<?PHP $mysqli->close(); ?>
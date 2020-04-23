<?php

   class Basket {

      public function add($id, $quantity) {

         global $mysqli;
         $result = $mysqli->query("SELECT * FROM products WHERE id='$id'");
         $row = $result->fetch_array(MYSQLI_ASSOC);
         if($result->num_rows > 0 && $row['quantity'] > 0) {

            if($quantity + $_SESSION['basket'][$id]['prodQuantity'] > $row['quantity']) {
               $quantity = $row['quantity'] - $_SESSION['basket'][$id]['prodQuantity'];
            }
            if($_SESSION['basket'][$id]) {
               $_SESSION['basket'][$id]['prodQuantity'] = $_SESSION['basket'][$id]['prodQuantity'] + $quantity;
            } else {              
               $_SESSION['basket'][$id] = [
                  'prodId' => $id,
                  'prodName' => $row['name'],
                  'prodPrice' => $row['price'],
                  'prodQuantity' => $quantity
               ];
            }
            echo 'Dodano do koszyka ' . $quantity . ' szt. ' . $row['name'];  

         }
         
      }

      public function remove($id) {

         echo 'Usunięto ' . $_SESSION['basket'][$id]['prodName'] . '.<br>';
         unset($_SESSION['basket'][$id]);
         
      }

      public function empty() {

         $_SESSION['basket'] = [];
         echo 'opróżniono koszyk<br><br>';

      }

      public function buyAll() {

         global $mysqli;
         $totalQuantity = 0;
         $totalPrice = 0;

         foreach($_SESSION['basket'] as $item) {

            $result = $mysqli->query("SELECT * FROM products WHERE id='$item[prodId]'");
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if($row['quantity'] >= $item['prodQuantity']) {
               $totalQuantity = $totalQuantity + $item['prodQuantity'];
               $totalPrice = $totalPrice + $item['prodQuantity'] * $item['prodPrice'];

               $newQuantity = $row['quantity'] - $item['prodQuantity'];
               echo $row['name'] . '<br>';
               $mysqli->query("UPDATE products SET quantity='$newQuantity' WHERE id='$item[prodId]'");
               unset($_SESSION['basket'][$item['prodId']]);

            }
            
         }
            echo 'kupiono ' . $totalQuantity . ' produktów za łączną kwotę ' . $totalPrice . ' zł.';
      }

   }

?>
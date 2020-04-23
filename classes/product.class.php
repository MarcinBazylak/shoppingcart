<?php

class Product {
   
   public static function getProducts() {

      global $mysqli;
      $result = $mysqli->query("SELECT * FROM products");
      return $result;

   }

}

?>
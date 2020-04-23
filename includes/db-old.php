<?php
// zmień nazwę tego pliku na db.php i wpisz poprawne dane w poniższej linijce aby połączyć się  z bazą danych
   $mysqli = new mysqli('localhost', 'username', 'password', 'db_name');
   $mysqli->set_charset('utf8');
?>
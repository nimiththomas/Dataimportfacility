<?php

$host='localhost';
$user='nimith';
$pass='nUctTgw4';
$db='nimith';


try {
  $dbh = new PDO("mysql:host=$host;dbname=$db",$user,$pass);

  
} catch (PDOException $e) {
    print $e->getMessage();
}



?>
<?php

$host='localhost';
$user='';
$pass='';
$db='';


try {
  $dbh = new PDO("mysql:host=$host;dbname=$db",$user,$pass);

  
} catch (PDOException $e) {
    print $e->getMessage();
}



?>

<?php
include "config.php";
QueryMeThis("INSERT INTO purchases (name,price) SELECT name,price FROM products WHERE ID = ?",["i",$_POST["buy"]]);
header("location: store.php");
?>
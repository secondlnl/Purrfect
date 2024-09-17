<?php
include "config.php";
$sql_1 = "INSERT INTO purchases (name,price) SELECT name,price FROM products WHERE ID =" . $_POST["buy"];
$conn->query($sql_1);
header("location: store.php");
?>
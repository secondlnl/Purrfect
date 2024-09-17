<?php
include "config.php";
	$prepared = mysqli_prepare($conn, "truncate purchases");
mysqli_stmt_execute($prepared);

header("location: checkout.php");

?>
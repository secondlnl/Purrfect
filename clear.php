<?php
include "config.php";
$prepared = mysqli_prepare($conn, "truncate Purchases");
mysqli_stmt_execute($prepared);

header("location: store.php");

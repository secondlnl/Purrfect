<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	echo ("Sorry something went CRAZY but mostly wrong.");
} else {
	include "config.php";

	//
	$sql = "SELECT * FROM purchases;";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// Output data of each row
		$tmp = array();
		$str = array();
		while ($row = $result->fetch_assoc()) {
			$tmp[] = $row["Name"];
			$str[] = $row["Price"];
		}
		$tt = "";
		for ($i = 0; $i < count($tmp); $i++) {
			$tt .= $tmp[$i] . ":" . $str[$i] . "\\";
		}
	}
	//
	$prprd = mysqli_prepare($conn, "INSERT INTO Orders (UserID, Date, Products) VALUES(?,?,?);");
	session_start();
	mysqli_stmt_bind_param($prprd, "sss", $_SESSION["id"], (date("Y.m.d")), $tt);
	mysqli_stmt_execute($prprd);
	mysqli_stmt_close($prprd);



	$prepared = mysqli_prepare($conn, "truncate purchases");
	mysqli_stmt_execute($prepared);
	header("location: store.php");
	mysqli_stmt_close($prepared);
	mysqli_close($conn);
}

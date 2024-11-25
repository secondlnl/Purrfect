<?php
// Declaire constants for quote, endquote Portability
define("_SERVERADDRESS", "Localhost");
define("_SERVERUSER", "root");
define("_SERVERPASS", "");
define("_DBNAME", "PURRFECTDB01");
// Establish connection with MYSQLI

$conn = new mysqli(_SERVERADDRESS, _SERVERUSER, _SERVERPASS, _DBNAME);
// Using the said database
mysqli_set_charset($conn, "latin1");
$conn->query("USE " . _DBNAME);

function querymethis($query, ...$params)
{
  $query = strtolower($query); // decapitelise the query
  if (!empty($query)) {
    if (substr_count($query, "select") == 1) {
    }else if (substr_count($query, "insert") == 1) {
    } else if (substr_count($query, "update") == 1) {
    }
  }
}




// create a prepared statement
// $stmt = mysqli_prepare($conn, "SELECT District FROM City WHERE Name=?");
// bind parameters for markers */
//mysqli_stmt_bind_param($stmt, "s", $city);
// execute query
//mysqli_stmt_execute($stmt);


/*
// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare("INSERT INTO test(id, label) VALUES (?, ?)");

// Prepared statement, stage 2: bind and execute
$stmt->bind_param("is", $id, $label); // "is" means that $id is bound as an integer and $label as a string
*/

/**if ($conn->connect_error) {
die("Connection failed: .$conn->connect_error");
} else
echo "Connection successfully"; **/
// Create database
// $sql = "CREATE DATABASE "._DBNAME;
/**if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}**/

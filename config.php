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

function QueryMeThis(string $str = "", array $param = [] )
{
  global $conn;
  if (empty(trim($str)) || !is_array($param)) {
    // Empty parameters
    die("Not afficent function parameters");
  }
  if (substr_count($str, "?") <= 0) {
    // No ? in query
    die("No params in query string.");
  }

  $i = 0;
  $types = "";
  $strings = "";
  while ($i < count($param)) {
    echo "<script>console.log( 'wat: ".$param[$i]."');</script>";
    echo "<script>console.log(".count($param).");</script>\n";
    if (strlen("".$param[$i]) >= 0) {
      $types .= $param[$i];
      $strings .= "" . $param[$i + 1] . ", ";
      if (($i + 1) == count($param)) break;
      $i = $i + 2;
    } else $i++;
  }
  $strings = rtrim($strings, ",");
  if (empty($strings) || empty($types)){
    die("<p>Arguments could not be found or parsed</p>");
  }

  // echo ("T:" . $types . "S: " . $strings . "");
  $prprd = $conn->prepare($str);
  $prprd->bind_param($types,$strings);
  $prprd->execute();
  return $prprd->get_result();
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

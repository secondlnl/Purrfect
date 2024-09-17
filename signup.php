<?php
// Include a config which *go figure* configures the connections
// XD
include "config.php";
include "header.php";
$un = $conpw = $pw = "";
$un_error = 0;
// Main event loop
if (isset($_POST["un"]) && isset($_POST["pw"]) && isset($_POST["conpw"])) {

    $un = $_POST["un"];
    $pw = $_POST["pw"];
    $conpw = $_POST["conpw"];
    if (isset($un) && isset($_POST["un"]) && !empty($un) && !empty($_POST["un"])) {
        // Check if the un is taken and if so displaying a warning
        $result = $conn->query("SELECT ID FROM Accounts WHERE Username='$un'");
        if( mysqli_num_rows($result) > 0 )
            $un_error = 1;
    }
    if (trim($pw) === trim($conpw) && $un_error != 1) { // passwords match and no error
        $prepared = mysqli_prepare($conn, "INSERT INTO Accounts(Username,Password) Values(?,?) ");
        $newpw = password_hash($pw,"argon2i");
        mysqli_stmt_bind_param($prepared, "ss", $un,$newpw);
        mysqli_stmt_execute($prepared);
        mysqli_stmt_close($prepared);
		header("location: index.php");
    }
    // $_SESSION["un"] = $un;
}
// Close connection
mysqli_close($conn);
?>
<title>Purrfect - Signup</title>
<h1>Signup time!!! &#x2665 </h1>
  <form method="post">
    <label for="un">Username:</label>
    <input type="text" name="un" required>
    <?php if($un_error == 1) echo ("<p id=error>Username $un is taken, sorry pick another one</p>");?>
    <label for="pw">Password:</label>
    <input type="password" name="pw" required minlength="6">
    <label for="conpw">Confirm password:</label>
    <input type="password" name="conpw" required minlength="6">
    <input type="submit" name="sgnp" value="Signup">
  </form>

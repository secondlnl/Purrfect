<?php
// Include a config which *go figure* configures the connections
// XD
include "config.php";
include "header.php";

if(!isset($_SESSION["un"]))
header("location: index.php");

$conpw = $pw = "";
$pw_error = $conpw_error = 0;
// Main event loop
if (isset($_POST["pw"]) && isset($_POST["conpw"])) {
    $pw = $_POST["pw"];
    $conpw = $_POST["conpw"];
    if ($conpw_error != 1 && $pw_error != 1 && !empty($pw) && isset($_SESSION["un"])) {
        $un = $_SESSION["un"];
        $prepared1 = mysqli_prepare($conn, "SELECT Password FROM Accounts WHERE Username='$un'");
        if (mysqli_stmt_execute($prepared1) == true){ // true == success
            mysqli_stmt_store_result($prepared1);
            if(mysqli_stmt_num_rows($prepared1) == 1){
                mysqli_stmt_bind_result($prepared1,$hpw);
                if (mysqli_stmt_fetch($prepared1) == true) { // if data fetched
                        if (trim(strtolower($pw)) === trim(strtolower($conpw)) && $pw_error != 1) { // passwords match and no error
                            $prepared2 = mysqli_prepare($conn, "UPDATE Accounts SET password=? WHERE id=?");
                            $newpw = password_hash($pw,"argon2i");
                            mysqli_stmt_bind_param($prepared2, "si",$newpw, $_SESSION["id"]);
                            mysqli_stmt_execute($prepared2);
                            mysqli_stmt_close($prepared2);
                        } else { $conpw_error = 1;}
						mysqli_stmt_close($prepared1);
                    }
                } else { $pw_error = 1;}
            }
        }
    }


// Close connection
mysqli_close($conn);


?>
<title>Purrfect - Reset your Password</title>
<h1> Account - Reset your Password </h1>

<form method="post">
    <?php if($pw_error == 1){ echo ("<p id=error>Password does not match $un </p>");} ?>
    <label for="pw">Password:</label>
    <input type="password" name="pw" required minlength="6">
    <label for="conpw">Confirm password:</label>
    <input type="password" name="conpw" required minlength="6">
    <?php if($conpw_error == 1){ echo ("<p id=error>The two passwords do not match </p>");} ?>
    <input type="submit" value="Reset your Password">
</form>

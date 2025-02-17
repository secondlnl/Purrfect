<?php
// Include a config which *go figure* configures the connections
// XD
include "config.php";
include "header.php";

if (isset($_SESSION["loggedin"]))
    header("location: account.php");
// VARIABLES

$un = $pw = "";
$un_error = $pw_error = 0;

if (isset($_POST["un"]) && isset($_POST["pw"])) {
    $un = trim($_POST["un"]);
    $pw = trim($_POST["pw"]);
}
// Check if the un is not valid and if so displaying a warning
if (isset($un) && isset($_POST["un"])) {
    $result = $conn->query("SELECT ID FROM Accounts WHERE Username='$un'");
    if ($result->num_rows == 0)
        $un_error = 1;
}

if ($un_error != 1 && $pw_error != 1 && !empty($un) && !empty($pw) && isset($_POST["un"]) && isset($_POST["pw"])) {
    $prepared = mysqli_prepare($conn, "SELECT ID,Username,Password FROM Accounts WHERE Username=?");
    $prepared->bind_param("s",$un);
    if (mysqli_stmt_execute($prepared) == true) { // true == success
        mysqli_stmt_store_result($prepared);
        if (mysqli_stmt_num_rows($prepared) == 1) {
            mysqli_stmt_bind_result($prepared, $id, $un, $hpw);
            if (mysqli_stmt_fetch($prepared) == true) { // if data fetched
                if (password_verify($pw, $hpw)) {
                    session_start();
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["un"] = $un;
                    // redirect to profile
                    header("location: account.php");
                } else {
                    $pw_error = 1;
                }
            }
        }
    }
    mysqli_stmt_close($prepared);
}

// Close connection
mysqli_close($conn);
?>
<title>Purrfect</title>
<h1 id="title">Hi and welcome to "Purrfect"</h1>
<h2>-- Your one stop shop for everything* cats! <em>meow</em> </h2>
<h3 id="favourtext"><sub><em>* Not everything</em><sub></h3>
<form method="post" id="grid">
    <label for="un">Username:</label>
    <input type="text" name="un" required placeholder="Username">
    <?php if ($un_error == 1) {
        echo ("<p id=error>Username is not found, maybe sign up &#x2665</p>");
    } ?>
    <label for="pw">Password:</label>
    <input type="password" name="pw" required minlength="6" placeholder="Password">
    <?php if ($pw_error == 1) {
        echo ("<p id=error>Password does not match $un </p>");
    } ?>
    <button type="submit" name="lgin">Login</button>
</form>
<p>Does it not work? Maybe an account is in order, <a href="signup.php">sign up here!!! &#x2665</a> </p>
<?php
// Include a config which *go figure* configures the connections
// XD
include "config.php";
include "header.php";

if(!isset($_SESSION["loggedin"]))
header("location: index.php");
$BUTTON_PRESSED = isset($_POST["butt"]);

if ($BUTTON_PRESSED){
    $BUTT = $_POST["butt"];
    if ($BUTT == "Sign out") {
		$prepared = mysqli_prepare($conn, "truncate purchases");
mysqli_stmt_execute($prepared);
        session_unset();
        session_destroy();
        header("location: index.php");
    } elseif ($BUTT == "Reset your Password") {
        header("location: reset.php");
    }
}


?>
<title>Purrfect - Account</title>
<h1> Account </h1>
<h3>Name: <?php echo $_SESSION["un"]?></h3>
<?php
// Fetch the profile picture path from the database
$stmt = $conn->prepare("SELECT img FROM accounts WHERE id = ?");
$stmt->bind_param("i", $_SESSION["id"]);
$stmt->execute();
$stmt->bind_result($profilePicture);
$stmt->fetch();
$stmt->close();

$conn->close(); // Close the connection

// Display the image
if ($profilePicture) {
    echo "<img src='$profilePicture' alt='pfp' width='100' height='100'>";
} else {
    echo "No profile picture found.";
}
?>

<form action="Upload.php" method="post" enctype="multipart/form-data">
    <label for="profile_pic">Upload Profile Picture:</label>
    <input type="file" name="profile_pic" id="profile_pic" accept=".png, .jpg, .jpeg">
    <br>
    <input type="submit" value="Upload">
</form>


<form method="post">
    <input type="submit" name="butt" value="Reset your Password">
    <input type="submit" name="butt" value="Sign out">
</form>

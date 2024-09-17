<?php
// Include a config which *go figure* configures the connections
// XD
include "config.php";
include "header.php";

if(!isset($_SESSION["un"]))
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
$sessionId = $_SESSION["id"];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM accounts WHERE ID = ". $_SESSION["id"]));
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Update Image Profile</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <form class="form" id = "form" action="" enctype="multipart/form-data" method="post">
      <div class="upload">
        <?php
        $id = $user["ID"];
        $name = $user["Username"];
        $image = $user["img"];
        ?>
        <img src="img/<?php echo $image; ?>" width = 125 height = 125 title="<?php echo $image; ?>">
        <div class="round">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <input type="hidden" name="name" value="<?php echo $name; ?>">
          <input type="file" name="image" id = "image" accept=".jpg, .jpeg, .png">
          <i class = "fa fa-camera" style = "color: #fff;"></i>
        </div>
      </div>
    </form>
    <script type="text/javascript">
      document.getElementById("image").onchange = function(){
          document.getElementById("form").submit();
      };
    </script>
    <?php
    if(isset($_FILES["image"]["name"])){
      $id = $_POST["id"];
      $name = $_POST["name"];

      $imageName = $_FILES["image"]["name"];
      $imageSize = $_FILES["image"]["size"];
      $tmpName = $_FILES["image"]["tmp_name"];

      // Image validation
      $validImageExtension = ['jpg', 'jpeg', 'png'];
      $imageExtension = explode('.', $imageName);
      $imageExtension = strtolower(end($imageExtension));
      if (!in_array($imageExtension, $validImageExtension)){
        echo
        "
        <script>
          alert('Invalid Image Extension');
          document.location.href = '../updateimageprofile';
        </script>
        ";
      }
      elseif ($imageSize > 1200000){
        echo
        "
        <script>
          alert('Image Size Is Too Large');
          document.location.href = '../updateimageprofile';
        </script>
        ";
      }
      else{
        $newImageName = $name . " - " . date("Y.m.d") . " - " . date("h.i.sa"); // Generate new image name
        $newImageName .= '.' . $imageExtension;
        $query = "UPDATE Accounts SET img = '$newImageName' WHERE id = $id";
        mysqli_query($conn, $query);
        move_uploaded_file($tmpName, 'img/' . $newImageName);
        echo
        "
        <script>
        document.location.href = '../updateimageprofile';
        </script>
        ";
      }
    }
    ?>
  </body>
</html>

<form method="post">
    <input type="submit" name="butt" value="Reset your Password">
    <input type="submit" name="butt" value="Sign out">
</form>

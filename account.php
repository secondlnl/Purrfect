<?php
// Include a config which *go figure* configures the connections
// XD
include "config.php";
include "header.php";

if (!isset($_SESSION["loggedin"]))
    header("location: index.php");
$BUTTON_PRESSED = isset($_POST["butt"]);

if ($BUTTON_PRESSED) {
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

<head>
    <script>
        $(document).ready(function() {
            $("#delbutt").click(function() {
                $.post("product.php", {
                    opt: "del",
                    id: $("#delbutt").val()
                    // TODO Add precidure selection to the script, add the tr.products when done processing, with the new tr 
                }, function(data) {
                    $("#me").html( data );
                });
            })
        });
        $(document).ready(function() {
            $("#addbutt").click(function() {
                $.post("product.php", {
                    opt: "add",
                    Name: $("#Name").val(),
                    Description: $("#Description").text(),
                    Price: $("#Price").val(),
                    // TODO Add precidure selection to the script, add the tr.products when done processing, with the new tr 
                }, function(data) {
                    $("#me").html( data);
                });
            })
        });
    </script>
    <script>
        function popuptoggle() {
            var x = document.getElementById("bg");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else
                x.style.display = "none";
        }

        function deltoggle(num) {
            var x = document.getElementById("del" + num);
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
</head>
<title>Purrfect - Account</title>
<div id="bg" style="display: block;">

    <div id="popup">
        <h2>Your products</h2>
        <table id="yp">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price (kr)</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody id="me">
                <?php // echo $_SESSION["id"];
                $query = "SELECT ID, Name, Price, Description FROM products WHERE SellerID = " . $_SESSION["id"] . ";";
                $res = $conn->query($query);
                if ($res->num_rows > 0) {
                    while ($prow = $res->fetch_assoc()) {
                        echo ("<tr> <td>" . $prow["Name"] . "</td> <td>" . $prow["Price"] . "</td> <td>" . $prow["Description"] . "</td> <td><button onmousedown='deltoggle(" . $prow["ID"] . ");' class='cartremove'><i class='material-icons'>&#xe872;</i></button></td> <td><button><i class='material-icons'>&#xe3c9;</i></button></td></tr>");
                        echo "<div class='del' id='del" . $prow["ID"] . "' style='display: none;'><h2>Delete the product: " . $prow["Name"] . "</h2><button type='submit' id='delbutt' onclick='deltoggle(" . $prow["ID"] . ");' class='cartadd' Value=" . $prow["ID"] . ">Yes</button><button onmousedown='deltoggle(" . $prow["ID"] . ");' class='cartremove'>No</button></div>";
                    }
                } ?>
            </tbody>
        </table>
        <form id="grid">
            <input type='text' id='Name' required="true" placeholder='Product name'></td>
            <input type='number' id='Price' placeholder='Desired price' required="true" min='0'></td>
            <textarea id='Description' placeholder='Product description' required="true"></textarea></td>
            <button id='addbutt' class='cartadd'><i class='material-icons'>&#xe145;</i></button></td>
        </form>


        <button onmousedown="popuptoggle();" class="cartremove">Close</button>
    </div>
</div>
<h1> Account </h1>
<div id="leftaccountpage">
    <h3>Name: <?php echo $_SESSION["un"] ?></h3>
    <?php
    // Fetch the profile picture path from the database
    $stmt = $conn->prepare("SELECT img FROM accounts WHERE id = ?");
    $stmt->bind_param("i", $_SESSION["id"]);
    $stmt->execute();
    $stmt->bind_result($profilePicture);
    $stmt->fetch();
    $stmt->close();



    // Display the image
    if ($profilePicture) {
        echo "<img src='$profilePicture' alt='pfp' width='100' height='100'>";
    } else {
        echo "No profile picture found.";
    }
    ?>

    <form action="Upload.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Upload profile</legend>
            <label for="profile_pic">Upload Profile Picture:</label>
            <input type="file" name="profile_pic" id="profile_pic" accept=".png, .jpg, .jpeg">
            <br>
            <input type="submit" value="Upload">
        </fieldset>
    </form>


    <form method="post">
        <input type="submit" name="butt" value="Reset your Password">
        <input type="submit" name="butt" value="Sign out">
    </form>
</div>
<div id="rightaccountpage">
    <div id="orderstable">
        <h1>Orders</h1>
        <?php
        $sqlo = "SELECT Date,Products FROM orders WHERE UserID = " . $_SESSION["id"] . ";";
        $resulto = $conn->query($sqlo);
        // Check if there are any products
        if ($resulto->num_rows > 0) {
            while ($rowo = $resulto->fetch_assoc()) {
                echo    "<details><summary>" . $rowo["Date"] . "</summary>";
                $rplc = str_replace(":", " - ", $rowo["Products"]);
                $token = strtok($rplc, "\\");
                while ($token !== false) {
                    echo "<ul><li>$token kr</li></ul>";
                    $token = strtok("\\");
                }
                echo "</details>";
            }
        }
        // Close the connection
        ?>
    </div>
    <?php
    $query4 = "SELECT Seller FROM Accounts WHERE ID = " . $_SESSION["id"] . ";";
    $r4 = $conn->query($query4);
    if ($r4->num_rows > 0) {
        while ($row4 = $r4->fetch_assoc()) {
            if ($row4["Seller"] == 1)
                echo "<button onmousedown='popuptoggle();'>Your Products</button>";
        }
    }
    // <button></button> <button></button> <button onmousedown='popuptoggle();'>Your Products</button>
    ?>
</div>





<?php $conn->close(); ?>
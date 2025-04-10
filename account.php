<?php
// Include a config which *go figure* configures the connections
// XD Henrik changed
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script>
        if (window.newresp == undefined || window.req == undefined || window.prow == undefined) {
            window.prow = "";
            window.newresp = "";
            window.req = new XMLHttpRequest();
        }
        async function product(opt, id = null) {
            req.open("POST", "productcess.php", true);
            req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            req.onreadystatechange = () => {
                // Call a function when the state changes.
                if (req.readyState === XMLHttpRequest.DONE && req.status === 200) {
                    // Request finished. Do processing here.
                    newresp = JSON.parse(req.responseText);
                    if (JSON.stringify(newresp) !== JSON.stringify(prow)) {
                        prow = newresp;
                        console.log(prow);
                        let html = "";
                        prow.forEach(e => {
                            html += `
                            <tr id="products">
                            <td>${e.name}</td>
                            <td>${e.price}</td>
                            <td>${e.description}</td>
                            <td><button id="Del" class="cartremove" onclick="product('del',${e.id});">Delete</button></td>`;
                        });
                        document.getElementById("me").innerHTML = html;
                    };
                };
            };
            if (opt.toLowerCase() === "del") { // opt del
                req.send(`opt=del&id=${id}`);
            } else if (opt.toLowerCase() === "add") { // opt add
                const name = document.getElementById("Name");
                const price = document.getElementById("Price");
                const description = document.getElementById("Description");
                name.oninput = function() {
                    document.getElementById("Error").innerHTML = "";
                }
                description.oninput = function() {
                    document.getElementById("Error").innerHTML = "";
                }
                price.oninput = function() {
                    document.getElementById("Error").innerHTML = "";
                }
                if (document.getElementById("Error").innerHTML.length <= 0 && description.value.trim() != "" && name.value.trim() != "" && price.value.trim() != "") {
                    req.send(`opt=add&name=${name.value}&price=${price.value}&description=${description.value}`);
                    name.value = "";
                    price.value = "";
                    description.value = "";
                } else {
                    console.log("error be error");
                    document.getElementById("Error").innerHTML = "Please, fill in all the fields.";
                }
            } else if (opt.toLowerCase() === "show") {
                req.send("opt=show");
            };
        };

        function popuptoggle() {
            var x = document.getElementById("bg");
            if (x.style.display === "none") {
                x.style.display = "block";
                product("show");
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
<div id="bg" style="display: none;">

    <div id="popup">
        <h2>Your products</h2>
        <table id="yp">
            <thead>
                <th>Name</th>
                <th>Price (kr)</th>
                <th>Description</th>
            </thead>
            <tbody id="me">

            </tbody>
            <tbody>
                <tr>
                    <td><input type="text" id="Name" placeholder="Product name"></td>
                    <td><input type="number" min="1" id="Price" placeholder="Desired price"></td>
                    <td><textarea id="Description"></textarea></td>
                    <td><button onclick="product('add');">+</button></td>
                </tr>
            </tbody>
        </table>
        <p id="Error"></p>


        <button onmousedown="popuptoggle();" class="cartremove">Close</button>
    </div>
</div>
<main>
    <h1> Account </h1>
    <div id="leftaccountpage">
        <h3>Name: <?php echo $_SESSION["un"] ?></h3>
        <?php
        // Fetch the profile picture path from the database
        $stmt = $conn->prepare("SELECT img FROM Accounts WHERE id = ?");
        $stmt->bind_param("i", $_SESSION["id"]);
        if ($stmt->execute()) {
            $stmt->bind_result($profilePicture);
            $stmt->fetch();
        }
        $stmt->close();



        // Display the image
        if (isset($profilePicture) && !empty(trim($profilePicture))) {
            echo "<img src='" . $profilePicture . "' alt='pfp' width='100' height='100'>";
        } else {
            echo "<img  alt='No profile picture found.' width='100' height='100'>";
        }
        ?>

        <form action="Upload.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Upload profile</legend>
                <label for="profile_pic">Upload Profile Picture:</label>
                <input type="file" name="profile_pic" id="profile_pic" accept=".png, .jpg, .jpeg" required>
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
            $resulto = QueryMeThis("SELECT Date, Products FROM Orders WHERE UserID = ? ORDER BY OrderID DESC, Date DESC", ["i", "" . $_SESSION["id"]]);
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
        $r4 = QueryMeThis("SELECT Seller FROM Accounts WHERE ID = ?", ["i", "" . $_SESSION["id"]]);
        if ($r4->num_rows > 0) {
            while ($row4 = $r4->fetch_assoc()) {
                if ($row4["Seller"] == 1)
                    echo "<button onmousedown='popuptoggle();'>Your Products</button>";
            }
        }
        ?>
    </div>
</main>




<?php $conn->close(); ?>
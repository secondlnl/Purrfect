<?php
include "config.php";
include "header.php";
?>
<title>Purrfect - store</title> <!-- Title of this shit show-->
<script>
    if (window.req == undefined || window.oldresp == undefined || window.newresp == undefined || window.cart == undefined) {
        window.req = new XMLHttpRequest();
        window.oldresp = "";
        window.newresp = "";
        window.cart = 0;
    }
    async function BuyBoughtBought(Product) {

        if (window.cart == 0) {
            const maintag = document.getElementsByTagName("main")[0];
            window.cart = 1;
            const cart = `
            <aside>
            <h2>Shopping Cart</h2>
            <form method='post' action='clear.php'>
            <button type='submit' class='cartremove'>Clear</button></form>
            <div id='cart'>
            <div class='outer'>
            <div><strong>Name</strong></div>
            <div><strong>Price (kr)</strong></div>
            </div>
            </div>
            <form method='post' action='checkout.php'>
            <button type='submit'>Checkout</button></form>
            </aside>`;
            maintag.insertAdjacentHTML("afterbegin", cart);
        }

        console.log(`buy: ${Product}`);
        req.open("POST", "storeprocessor.php", true);
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        req.onreadystatechange = () => {
            // Call a function when the state changes.
            if (req.readyState === XMLHttpRequest.DONE && req.status === 200) {
                // Request finished. Do processing here.
                // Request finished. Do processing here.
                newresp = JSON.parse(req.responseText);
                if (JSON.stringify(newresp) !== JSON.stringify(oldresp)) {
                    oldresp = newresp;
                    // console.log(prow);
                    let html = "";
                    newresp.forEach(e => {
                        html += ` <div class='outer'>
                     <div>${e.name}</div>
                     <div>${e.price}</div>
                     </div>`
                    });
                    //document.getElementById(`cart`).insertAdjacentHTML("afterend", html);
                    document.getElementById(`cart`).innerHTML = html;
                }
            }
        }
        req.send(`buy=${Product}`);
    }

    async function savecomment(pid) {
        console.log(`ahh: ${pid}`);
        req.open("POST", "commentscess.php", true);
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        req.onreadystatechange = () => {
            // Call a function when the state changes.
            if (req.readyState === XMLHttpRequest.DONE && req.status === 200) {
                // Request finished. Do processing here.
                // Request finished. Do processing here.
                newresp = JSON.parse(req.responseText);
                if (JSON.stringify(newresp) !== JSON.stringify(oldresp)) {
                    oldresp = newresp;
                    // console.log(prow);
                    let html = "";
                    newresp.forEach(e => {
                        html = `
<div class="comment" id="comment-${e.id}"><p><strong>${e.name}</strong>${e.date}</p><p>${e.text}</p><button class="cartremove" name="delete" onclick="deletecomment(${e.id});" style="float:right;margin-top:-59px;margin-right: -1px;min-width: fit-content;min-height: fit-content;"><i class="material-icons">delete_forever</i></button></div>
                            `
                    });
                    document.getElementById(`details-${pid}`).insertAdjacentHTML("afterbegin", html);

                }
            }
        }
        const comment = document.getElementById(`savecomment-${pid}`).value;
        if (!comment && comment.length === 0) {
            document.getElementById(`error-${pid}`).innerHTML = "error please input some text";
            exit;
        } else {
            console.log(`${comment}`);
            document.getElementById(`error-${pid}`).innerHTML = "";
            document.getElementById(`savecomment-${pid}`).value = "";
            req.send(`PID=${pid}&comment=${comment}`);
        }
    }
    async function deletecomment(id) {
        req.open("POST", "deletecomment.php", true);
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        req.onreadystatechange = () => {
            // Call a function when the state changes.
            if (req.readyState === XMLHttpRequest.DONE && req.status === 200) {
                // Request finished. Do processing here.
                document.getElementById(`comment-${id}`).remove();
            }
        }
        req.send(`delete=${id}`);
    }
</script>
<main class="store" id="store">
    <?php
    if (!isset($_SESSION["loggedin"])) header("location: index.php");
    if (!isset($_SESSION["id"])) {
        header("location: index.php");
    }
    //$sql = "SELECT * FROM purchases;";
    //$result = $conn->query($sql);
    // Check if there are any products
    // echo "<aside>";
    // echo "<h2>Shopping Cart</h2>";
    // echo "<form method='post' action='clear.php'>";
    // echo "<button type='submit' class='cartremove'>Clear</button></form>";

    // echo "<div class='outer'>";
    // echo "<div><strong>Name</strong></div>";
    // echo "<div><strong>Price (kr)</strong></div>";
    // echo "</div>";
    // // Output data of each row
    // while ($row = $result->fetch_assoc()) {
    //     // Display product as a receipt
    //     echo "<div class='outer'>";
    //     echo "<div>" . $row["Name"] . "</div>";
    //     echo "<div>" . $row["Price"] . "</div>";
    //     echo "</div>";
    // }
    // echo "<form method='post' action='checkout.php'>";
    // echo "<button type='submit'>Checkout</button></form></aside>";
    ?>
    <div id="box">

        <?php

        $rated = [];
        $sql = "SELECT ID, name, description, price FROM products";
        $result = $conn->query($sql);
        // Check if there are any products
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($products = $result->fetch_assoc()) {
                $lwname = trim(strtolower($products["name"]));
                // Display product as a card
                echo "<div class='card'>";
                echo "<h3 class='title'>" . $products["name"] . "</h3>";
                // Get all the products the user has purchased
                // Get the purchased items 
                $result2 = QueryMeThis("SELECT Products FROM orders WHERE UserID = ?;", ["i", "" . $_SESSION["id"]]);
                if ($result2->num_rows > 0) {
                    while ($orders = $result2->fetch_assoc()) {
                        $lworders = trim(strtolower($orders["Products"]));
                        $exorders = explode(":", $lworders);
                        foreach ($exorders as $k => $e) {
                            if (substr_count($e, $lwname) >= 1) { // Products $e have been bought
                                $result3 = QueryMeThis("SELECT Rating FROM products WHERE ID = ?;", ["i", "" . $products["ID"]]);
                                if ($result3->num_rows > 0) {
                                    while ($rating = $result3->fetch_assoc()) {
                                        if ($rating["Rating"] != 0 && !in_array($products["ID"], $rated)) {
                                            $rated[] = $products["ID"];
                                            echo "<script>console.log(" . $products["ID"] . "added)</script>";
                                            echo "<p class='rating'><strong>Rating: </strong>" . $rating["Rating"] . "</p>";
                                            echo "<form action='rating.php' method='post'>";
                                            echo "<button name='butt' type='submit' value='" . $products["ID"] . "' id='rating' class='rating' style='width:44px;height:44px;float:right;'><i class='material-icons'>&#xe838;</i></button>";
                                            echo "</form>";
                                        } else if (!in_array($products["ID"], $rated)) {
                                            echo "<form action='rating.php' method='post'>";
                                            echo "<button name='butt' type='submit' value='" . $products["ID"] . "' id='rating' class='rating' style='width:44px;height:44px;float:right;'><i class='material-icons'>&#xe83a;</i></button>";
                                            echo "</form>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // THIS WORKS OK DONT FIX
                echo "<p class='des'><strong>Description:</strong><br><em> " . htmlspecialchars($products["description"]) . "</em></p>";
                echo "<p class='price'>Price: " . $products["price"] . "kr</p>";
                $ctable = QueryMeThis("SELECT ID, Name, Text, Date FROM comments  WHERE PID = ? ORDER BY ID DESC, Date DESC;", ["i", "" . $products["ID"]]);
                // Check if there are any products
                if ($ctable->num_rows > 0) {
                    // Output data of each row
                    echo "<div class='comments'><details id='details-" . $products["ID"] . "' class='decomments'>";
                    while ($comment = $ctable->fetch_assoc()) {
                        echo "<div class='comment' id='comment-" . $comment["ID"] . "'><p><strong>" . htmlspecialchars($comment["Name"]) . "</strong> " . $comment["Date"] . "</p><p>" . htmlspecialchars($comment["Text"]) . "</p><button class='cartremove' name='delete' onclick='deletecomment(" . $comment["ID"] . ");' style='float:right;margin-top:-59px;margin-right: -1px;min-width: fit-content;min-height: fit-content;'><i class='material-icons'>delete_forever</i></button></div>";
                    }
                    echo "<summary>Comments</summary><div class='area'><label for='comment'>Have a say:</label><textarea  id='savecomment-" . $products['ID'] . "' rows='5' cols='33' placeholder='What say you about this product?'></textarea><button onclick='savecomment(" . $products['ID'] . ")' name='PID'>Save comment</button></div></details>";
                    echo "<p id='error-" . $products["ID"] . "' class='error'></p>";
                    echo "</div>";
                } else { // If no comment exists 
                    echo "<div class='comments'><details id='details-" . $products["ID"] . "' class='decomments empty' open='true' disabled='true' >";
                    echo "<summary></summary><div class='area'><label for='comment'>Have a say:</label><textarea  id='savecomment-" . $products['ID'] . "' rows='5' cols='33' placeholder='What say you about this product?'></textarea><button onclick='savecomment(" . $products['ID'] . ")' name='PID'>Save comment</button></div></details>";
                    echo "<summary style='list-style:none;'></summary></details><p id='error-" . $products["ID"] . "' class='error'></p></div>";
                }
                echo "<button onclick='BuyBoughtBought(" . $products['ID'] . ")' class='cartadd'>Add to Cart</button>";
                echo "</div>";
            }
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</main>
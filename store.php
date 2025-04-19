<?php
include "config.php";
include "header.php";
?>
<title>Purrfect - store</title> <!-- Title of this shit show-->
<script>
    if (window.req == undefined || window.oldresp == undefined || window.newresp == undefined) {
        window.req = new XMLHttpRequest();
        window.oldresp = "";
        window.newresp = "";
    }
    // function deleteproduce(value){
    //     console.debug(value);
    // }
    // function deleteable() {
    //     const texte = document.querySelectorAll("div#product.outer");
    //     texte.forEach(element => {
    //         element.addEventListener("click", (event) => {
    //             element.innerText = 0;
    //             deleteproduce(element.getAttribute("value"));

    //         });

    //     });
    //     console.debug(texte);

    // }

    function CountSum() {
        const nums = document.querySelectorAll("div#price");
        sumsum = 0;
        nums.forEach(element => {
            if (isNaN(element.innerText) == false)
                sumsum += parseInt(element.innerText);
        });
        console.debug(sumsum);
        if (sumsum > 0) {
            counter = document.getElementById("sum");
            console.debug("" + document.getElementById("sum"));
            counter.innerHTML = sumsum;
        }
    }
    async function BuyBoughtBought(Product) {
        if (document.getElementById("cart") == null) {
            const maintag = document.getElementsByTagName("main")[0];
            //window.cart = 1;
            const cart = `
            <aside>
            <h2>Shopping Cart</h2>
            <form method='post' action='clear.php'>
            <button type='submit' class='cartremove'>Clear</button></form>
            <div class='outer'>
            <div><strong>Name</strong></div>
            <div><strong>Price (kr)</strong></div>
            </div>
            <div id='cart'>
            </div>
            <div class='outer'>
            <div><strong>Sum</strong></div>
            <div><strong id='sum' class='sum'></strong></div>
            </div>
<form method='post' action='checkout.php'>
    <button type='submit' class='checkout'>Checkout</button>
</form>
</aside>`;
            maintag.insertAdjacentHTML("afterbegin", cart);
            CountSum();
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
                        html += ` <div class='outer' id='product'> 
    <div>${e.name}</div>
    <div id='price'>${e.price}</div>
</div>`
                    }); // TODO: Add product value so deleteable works.
                    //document.getElementById(`cart`).insertAdjacentHTML("afterend", html);
                    document.getElementById(`cart`).innerHTML = html;
                    CountSum();
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
<div class="comment" id="comment-${e.id}">
    <p><strong>${e.name}</strong>${e.date}</p>
    <p>${e.text}</p><button class="cartremove" name="delete" onclick="deletecomment(${e.id});" style="float:right;margin-top:-59px;margin-right: -1px;min-width: fit-content;min-height: fit-content;"><i class="material-icons">delete_forever</i></button>
</div>
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
    if (!isset($_SESSION["loggedin"]) && empty($_SESSION["loggedin"])) {
        header("location: index.php");
    }
    // TODO: Add purchases for specific user and diplay for them only
    $sql = "SELECT * FROM Purchases;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        //Check if there are any products
        echo "<aside>";
        echo "<h2>Shopping Cart</h2>";
        echo "<form method='post' action='clear.php'>";
        echo "<button type='submit' class='cartremove'>Clear</button></form>";
        echo "<div class='outer'>";
        echo "<div><strong>Name</strong></div>";
        echo "<div><strong>Price (kr)</strong></div>";
        echo "</div>";
        echo "<div id='cart'>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Display product as a receipt
            echo "<div class='outer' id='product'>";
            echo "<div>" . $row["Name"] . "</div>";
            echo "<div id='price'>" . $row["Price"] . "</div>";
            echo "</div>";
        }
        echo "</div>";
        echo "<div class='outer'>";
        echo "<div><strong class='sum'>Sum</strong></div>";
        echo "<div><strong id='sum' class='sum'>ahh</strong></div>";
        echo "</div>";
        echo "<script>CountSum();</script>";
        echo "<form method='post' action='checkout.php'>";
        echo "<button type='submit' class='checkout'>Checkout</button></form></aside>";
    }
    ?>
    <div id="box">

        <?php

        $rated = [];
        $sql = "SELECT ID, name, description, price FROM Products";
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
                $result2 = QueryMeThis("SELECT Products FROM Orders WHERE UserID = ?;", ["i", "" . $_SESSION["id"]]);
                if ($result2->num_rows > 0) {
                    while ($orders = $result2->fetch_assoc()) {
                        $lworders = trim(strtolower($orders["Products"]));
                        $exorders = explode(":", $lworders);
                        foreach ($exorders as $k => $e) {
                            if (substr_count($e, $lwname) >= 1) { // Products $e have been bought
                                $result3 = QueryMeThis("SELECT Rating FROM Products WHERE ID = ?;", ["i", "" . $products["ID"]]);
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
                $ctable = QueryMeThis("SELECT ID, Name, Text, Date FROM Comments  WHERE PID = ? ORDER BY ID DESC, Date DESC;", ["i", "" . $products["ID"]]);
                // Check if there are any products
                if ($ctable->num_rows > 0) {
                    // Output data of each row
                    echo "<div class='comments'><details id='details-" . $products["ID"] . "' class='decomments'>";
                    while ($comment = $ctable->fetch_assoc()) {
                        echo "<div class='comment' id='comment-" . $comment["ID"] . "'><p><strong>" . htmlspecialchars($comment["Name"]) . "</strong> " . $comment["Date"] . "</p><p>" . htmlspecialchars($comment["Text"]) . "</p>";
                        if ($_SESSION["un"] == $comment["Name"]) {
                            echo "<button class='cartremove' name='delete' onclick='deletecomment(" . $comment["ID"] . ");' style='float:right;margin-top:-59px;margin-right: -1px;min-width: fit-content;min-height: fit-content;'><i class='material-icons'>delete_forever</i></button></div>";
                        } else {
                            echo "</div>";
                        }
                    }
                    echo "<summary>Comments</summary><div class='area'><label for='comment'>Have a say:</label><textarea  id='savecomment-" . $products['ID'] . "' rows='5' cols='33' placeholder='What say you about this product?'></textarea><button onclick='savecomment(" . $products['ID'] . ")' name='PID' class='commentadd'>Save comment</button></div></details>";
                    echo "<p id='error-" . $products["ID"] . "' class='error'></p>";
                    echo "</div>";
                } else { // If no comment exists 
                    echo "<div class='comments'><details id='details-" . $products["ID"] . "' class='decomments empty' open='true' disabled='true' >";
                    echo "<summary></summary><div class='area'><label for='comment'>Have a say:</label><textarea  id='savecomment-" . $products['ID'] . "' rows='5' cols='33' placeholder='What say you about this product?'></textarea><button onclick='savecomment(" . $products['ID'] . ")' name='PID' class='commentadd'>Save comment</button></div></details>";
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
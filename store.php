<?php
include "config.php";
include "header.php";
?>
<title>Purrfect - store</title> <!-- Title of this shit show-->
<main class="store">
    <?php
    if (!isset($_SESSION["id"])) {
        header("location: index.php");
    }
    $sql = "SELECT * FROM purchases;";
    $result = $conn->query($sql);
    // Check if there are any products
    if ($result->num_rows > 0) {
        echo "<aside>";
        echo "<h2>Shopping Cart</h2>";
        echo "<form method='post' action='clear.php'>";
        echo "<button type='submit' class='cartremove'>Clear</button></form>";

        echo "<div class='outer'>";
        echo "<div><strong>Name</strong></div>";
        echo "<div><strong>Price (kr)</strong></div>";
        echo "</div>";
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Display product as a receipt
            echo "<div class='outer'>";
            echo "<div>" . $row["Name"] . "</div>";
            echo "<div>" . $row["Price"] . "</div>";
            echo "</div>";
        }
        echo "<form method='post' action='checkout.php'>";
        echo "<button type='submit'>Checkout</button></form></aside>";
    }

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
                    echo "<div class='comments'><details class='decomments'>";
                    while ($comment = $ctable->fetch_assoc()) {
                        echo "<div class='comment'><p><strong>" . htmlspecialchars($comment["Name"]) . "</strong> " . $comment["Date"] . "</p><p>" . htmlspecialchars($comment["Text"]) . "</p><form action='deletecomment.php' method='post'><button class='cartremove' name='delete' value='" . $comment["ID"] . "' style='float:right;margin-top:-59px;margin-right: -1px;min-width: fit-content;min-height: fit-content;'><i class='material-icons'>delete_forever</i></button></form></div>";
                    }
                    echo "<summary>Comments</summary><form action='commentscess.php' method='post'><label for='comment'>Have a say:</label><textarea required id='comment' name='comment' rows='5' cols='33' placeholder='What say you about this product?'></textarea><button type='submit' value=" . $products['ID'] . " name='PID'>Save comment</button></form></details>";
                    echo "</div>";
                } else { // If no comment exists 
                    echo "<div class='comments'><details class='decomments empty' open='true' disabled='true' >";
                    echo "<summary>Comments</summary><form action='commentscess.php' method='post'><textarea id='comment' name='comment' rows='5' cols='33' placeholder='What say you about this product?' required></textarea><button type='submit' value=" . $products['ID'] . " name='PID'>Save comment</button></form></details>";
                    echo "<summary style='list-style:none;'></summary></details></div>";
                }
                echo "<form method='post' action='storeprocessor.php'>";
                echo "<button type='submit' value=" . $products['ID'] . " name='buy' class='cartadd'>Add to Cart</button>";
                echo "</div> </form>";
            }
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</main>
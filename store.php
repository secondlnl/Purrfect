<?php
include "config.php";
include "header.php";
?>
<title>Purrfect - store</title> <!-- Title of this shit show-->
<?php

$sql = "SELECT * FROM purchases;";
$result = $conn->query($sql);
// Check if there are any products
if ($result->num_rows > 0) {
    echo "<aside>";
    echo "<h2>Shopping Cart</h2>";
    echo "<form method='post' action='clear.php'>";
    echo "<button type='submit' class='cartremove'>Clear</button></form>";

    echo "<div id='outer'>";
    echo "<div><strong>Name</strong></div>";
    echo "<div><strong>Price (kr)</strong></div>";
    echo "</div>";
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Display product as a receipt
        echo "<div id='outer'>";
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
    $sql = "SELECT ID, name, description, price FROM products";
    $result = $conn->query($sql);
    // Check if there are any products
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($products = $result->fetch_assoc()) {
            $lwname = trim(strtolower($products["name"]));
            // Display product as a card
            echo "<div id='card'>";
            echo "<h3 class='title'>" . $products["name"] . "</h3>";
            // Get all the products the user has purchased
            // Get the purchased items 
            $query2 = "SELECT Products FROM orders WHERE UserID = " . $_SESSION["id"] . ";";
            $result2 = $conn->query($query2);
            if ($result2->num_rows > 0) {
                while ($orders = $result2->fetch_assoc()) {
                    $lworders = trim(strtolower($orders["Products"]));
                    $exorders = explode(":", $lworders);
                    foreach ($exorders as $k => $e) {
                        if (substr_count($e, $lwname) >= 1) { // Products $e have been bought
                            $query3 = "SELECT Rating, RatedBy FROM products WHERE ID = " . $products["ID"] . ";";
                            $result3 = $conn->query($query3);
                            if ($result3->num_rows > 0) {
                                while ($rating = $result3->fetch_assoc()) {
                                    if ($rating["Rating"] != 0 && empty($rating["RatedBy"]) === false) {
                                        echo "<p class='rating'><strong>Rating: </strong>" . $rating["Rating"] . "</p>";
                                        echo "<p class='rating'><strong>Rated by: </strong>" . chop($rating["RatedBy"], ",") . "</p>";
                                        echo "<form action='rating.php' method='post'>";
                                        echo "<button name='butt' type='submit' value='" . $products["ID"] . "' id='rating' class='rating'><i class='material-icons'>&#xe838;</i></button>";
                                        echo "</form>";
                                    } else {
                                        echo "<form action='rating.php' method='post'>";
                                        echo "<button name='butt' type='submit' value='" . $products["ID"] . "' id='rating' style='width:44px;height:44px;float:right;margin-right:0px;margin-left:5px;margin-top:0;margin-bottom:0;'><i class='material-icons'>&#xe83a;</i></button>";
                                        echo "</form>";
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // THIS WORKS OK DONT FIX
            echo "<p class='des'><strong>Description:</strong><br><em> " . htmlspecialchars(htmlentities($products["description"])) . "</em></p>";
            echo "<p class='price'>Price: " . $products["price"] . "kr</p>";
            $comment = "SELECT Name, Text, Date FROM comments WHERE PID =" . $products["ID"];
            $ctable = $conn->query($comment);
            // Check if there are any products
            if ($ctable->num_rows > 0) {
                // Output data of each row
                echo "<div class='comments'><details class='decomments'>";
                while ($comment = $ctable->fetch_assoc()) {
                    echo "<div class='comment'><p><strong>" . htmlspecialchars($comment["Name"]) . "</strong> " . $comment["Date"] . "</p><p>" . htmlspecialchars($comment["Text"]) . "</p></div>";
                }
                echo "<summary>Comments</summary><form action='commentscess.php' method='post'><label for='comment'>Tell us your story:</label><textarea id='comment' name='comment' rows='5' cols='33' placeholder='What say you about this product?'></textarea><button type='submit' value=" . $products['ID'] . " name='PID'>Save comment</button></form></details>";
                echo "</div>";
            } else { // If no comment exists 
                echo "<div class='comments'><details class='decomments' open='true' disabled='true' >";
                echo "<summary style='list-style:none;'>No comments</summary></details></div>";
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
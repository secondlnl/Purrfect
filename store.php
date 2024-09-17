<?php

include "config.php";
include "header.php";
// $_POST["buy"] = NULL;
?>
<title>Purrfect - store</title>
<?php

$sql = "SELECT * FROM purchases;";	
	$result = $conn->query($sql);
    // Check if there are any products
    if ($result->num_rows > 0) {
		echo "<aside>";
echo "<h2>Shopping Cart</h2>";
        echo "<form method='post' action='clear.php'>";
		echo "<button type='submit'>Clear</button></form>";
			
echo "<div id='outer'>";
            echo "<div><strong>Name</strong></div>";
            echo "<div><strong>Price (kr)</strong></div>";
		echo "</div>";
		// Output data of each row
        while($row = $result->fetch_assoc()) {
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
<div class="box">

    <?php
    $sql = "SELECT id, name, description, price FROM products";
    $result = $conn->query($sql);
    // Check if there are any products
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            // Display product as a card
            echo "<div class='card'>";
            echo "<h3>" . $row["name"] . "</h3>";
            echo "<p>Description:<br><em> " . $row["description"] . "</em></p>";
            echo "<p>Price: " . $row["price"] . "kr</p>";
			echo "<form method='post' action='storeprocessor.php'>";
echo "<button type='submit' value=" . $row['id'] . " name='buy'>Add to Cart</button>";
			echo "</div> </form>";
			
        }
    }
    // Close the database connection
    $conn->close();
    ?>
</div>

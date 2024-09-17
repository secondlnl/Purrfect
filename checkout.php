<?php
include "config.php";
include "header.php";


	
echo "<aside style='
    border-top: 1px #ffffff solid !important;
    padding-left: 10px !important;
	padding-right: 10px !important;
    text-align: left !important;
    float: unset !important;
    font-size: unset !important;
	width: unset !important;
    text-align: center;
    float: right;
    color: black;
    font-size: smaller;
    /* padding: 5pt; */
    background-color: white;
    margin-right: -5pt;'>";
echo "<h2>Shopping Cart</h2>";
echo "<div id='outer'>";
            echo "<div><strong>Name</strong></div>";
            echo "<div><strong>Price (kr)</strong></div>";
		echo "</div>";
$sql = "SELECT * FROM purchases;";	
	$result = $conn->query($sql);
    // Check if there are any products
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            // Display product as a receipt
            echo "<div id='outer'>";
            echo "<div>" . $row["Name"] . "</div>";
            echo "<div>" . $row["Price"] . "</div>";
			echo "</div>";
		}
			echo "<form method='post' action='clear2.php'>";
		echo "<button id='checkout-button' type='submit'>Checkout</button></form>";
	}
	
			?>
<script>	
function handleCheckout() {
  
  // Display confirmation pop-up
  alert("Your purchase has gone through!");
}

// Add event listener to the checkout button
document.getElementById("checkout-button").addEventListener("click", handleCheckout);
</script>		

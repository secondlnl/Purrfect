<?php
include "header.php";
include "config.php";

// Retrieve search term from GET request
$searchTerm = $_GET['search'] ?? '';

// Prepare SQL query with prepared statements to prevent SQL injection
$sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";
$stmt = $conn->prepare($sql);
$param = "%" . $searchTerm . "%";
$stmt->bind_param("ss", $param, $param);

$stmt->execute();
$result = $stmt->get_result();

// Display search results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Product: " . $row['Name'] . " - " . $row['Price'] . " kr<br>";
    }
} else {
    echo "No products found for '" . htmlspecialchars($searchTerm) . "'.";
}

$stmt->close();
$conn->close();
?>
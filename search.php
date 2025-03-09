
<?php
include "header.php";
include "config.php";
// Retrieve search term from GET request
$searchTerm = $_GET['search'] ?? '';

// Prepare SQL query with prepared statements to prevent SQL injection
$sql = "SELECT * FROM Products WHERE name LIKE ? OR description LIKE ?";
$stmt = $conn->prepare($sql);
$param = "%" . $searchTerm . "%";
$stmt->bind_param("ss", $param, $param);

$stmt->execute();
$result = $stmt->get_result();

// Display search results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>" .$row['Name'] . "</strong> - " . $row['Price'] . " kr</p>";
    }
} else {
    echo "<p>No products found for '" . htmlspecialchars($searchTerm) . "'.</p>";
}

$stmt->close();
$conn->close();
?>
</main>
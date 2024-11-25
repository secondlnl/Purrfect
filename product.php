<?php
include "config.php";
session_start();
function show($conn)
{
    $query = "SELECT ID, Name, Price, Description FROM products WHERE SellerID = " . $_SESSION["id"] . ";";
    $res = $conn->query($query);
    if ($res->num_rows > 0) {
        while ($prow = $res->fetch_assoc()) {
            echo ("<tr> <td>" . $prow["Name"] . "</td> <td>" . $prow["Price"] . "</td> <td>" . $prow["Description"] . "</td> <td><button onmousedown='deltoggle(" . $prow["ID"] . ");' class='cartremove'><i class='material-icons'>&#xe872;</i></button></td> <td><button><i class='material-icons'>&#xe3c9;</i></button></td></tr>");
            echo "<div class='del' id='del" . $prow["ID"] . "' style='display: none;'><h2>Delete the product: " . $prow["Name"] . "</h2><button id='delbutt' onclick='deltoggle(" . $prow["ID"] . ");' class='cartadd' Value=" . $prow["ID"] . ">Yes</button><button onmousedown='deltoggle(" . $prow["ID"] . ");' class='cartremove'>No</button></div>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo ("Sorry something went CRAZY but mostly wrong.");
} else switch ($_POST["opt"]) {
    case 'del':
        $query = "DELETE FROM products WHERE ID = " . $_POST["id"] . "";
        $conn->query($query);
        show($conn);

        break;
    case 'add':
        $stmt = $conn->prepare("INSERT INTO products(Name, Description, Price, SellerID) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $_POST["Name"], $_POST["Description"], $_POST["Price"], $_SESSION["id"]);
        $stmt->execute();
        $stmt->close();
        show($conn);
        break;
}

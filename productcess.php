<?php
require_once("config.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "ERROR, you suck";
} else if (isset($_POST["opt"])) {

function show($conn){
    $p = 0; $n = ""; $d = ""; $i = 0;
        $showq = $conn->prepare("SELECT ID,Name,Description,Price FROM products WHERE SellerID = ?;");
        $showq->bind_param("i", $_SESSION["id"]);
        $showq->execute();
        $showq->bind_result($i, $n, $d, $p);
        $showq->store_result();
        $array = array();
        $res = array();
        while ($showq->fetch()) {
            $p = array("id" => $i, "name" => $n, "price" => $p, "description" => $d);
            $res[] = $p;
        }
        header('Content-Type: application/json');
        echo json_encode($res);
        $showq->close();
}


    switch ($_POST["opt"]) {
        case 'del':
            $delq = $conn->prepare("DELETE FROM products WHERE ID = ? AND SellerID = ?;");
            $delq->bind_param("ii", $_POST["id"], $_SESSION["id"]);
            $delq->execute();
            $delq->close();
            show($conn);
            # code...
            break;
        case 'add':
            $addq = $conn->prepare("INSERT INTO products(Name,Description,Price,SellerID) VALUES(?,?,?,?);");
            $addq->bind_param("ssii", $_POST["name"], $_POST["description"], $_POST["price"],$_SESSION["id"]);
            $addq->execute();
            $addq->close();
            show($conn);
            # code...
            break;
        case 'show':
            show($conn);
            # code...
            break;
    }
    $conn->close();
}

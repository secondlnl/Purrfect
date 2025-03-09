<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // echo ("Sorry something went CRAZY but mostly wrong.");
} else {
    include "config.php";
    function show($conn)
    {
        $p = 0;
        $n = "";
        $showq = $conn->prepare("SELECT Name,Price FROM purchases;");
        $showq->execute();
        $showq->bind_result($n, $p);
        $showq->store_result();
        $res = array();
        while ($showq->fetch()) {
            $p = array("name" => $n, "price" => $p);
            $res[] = $p;
        }
        header('Content-Type: application/json');
        echo json_encode($res);
        $showq->close();
    }
    QueryMeThis("INSERT INTO purchases (name,price) SELECT name,price FROM products WHERE ID = ?", ["i", $_POST["buy"]]);
    show($conn);
}

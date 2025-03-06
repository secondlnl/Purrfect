<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // echo ("Sorry something went CRAZY but mostly wrong.");
} else {
    include "config.php";
    function show($conn)
    {
        $t = "";
        $n = "";
        $d = "";
        $i = 0;
        $pid = $_POST["PID"];
        $showq = QueryMeThis("SELECT ID, Name, Text, Date FROM comments WHERE PID = ? ORDER BY ID DESC, Date DESC LIMIT 1;", ["i", $pid]);
        if ($showq->num_rows > 0) {
            // Output data of each row
            while ($comment = $showq->fetch_assoc()) {
                $res = array();
                $i = $comment["ID"];
                $n = $comment["Name"];
                $t = $comment["Text"];
                $d = $comment["Date"];
                $p = array("id" => $i, "name" => $n, "text" => $t, "date" => $d);
                $res[] = $p;
            }
            header('Content-Type: application/json');
            echo json_encode($res);
        }
    }
    $prprd = mysqli_prepare($conn, "INSERT INTO comments (PID, Name,Text, Date) VALUES(?,?,?,?);");
    session_start();
    $pid = $_POST["PID"];
    $un = $_SESSION["un"];
    $lcomment = $_POST["comment"];
    $date = date("Y.m.d");
    mysqli_stmt_bind_param($prprd, "isss", $pid, $un, $lcomment, $date);
    mysqli_stmt_execute($prprd);
    mysqli_stmt_close($prprd);
    show($conn);
}

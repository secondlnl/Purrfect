<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo ("Sorry something went CRAZY but mostly wrong.");
} else {
    include "config.php";
    session_start();

    //
    $sql = "SELECT id, name, description, price FROM products";
    $result = $conn->query($sql);
    //
    $prprd = mysqli_prepare($conn, "INSERT INTO comments (PID, Name,Text, Date) VALUES(?,?,?,?);");
    session_start();
    mysqli_stmt_bind_param($prprd, "isss", $_POST["PID"], $_SESSION["un"], $_POST["comment"], (date("Y.m.d")));
    mysqli_stmt_execute($prprd);
    mysqli_stmt_close($prprd);
    header("location: store.php");
    mysqli_close($conn);
}

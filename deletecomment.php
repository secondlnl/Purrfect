<?php
session_start();
if(!isset($_POST["delete"])) die("Danger, danger, failure, failure: button not present ");
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_SESSION["un"])) {
    echo ("Sorry something went CRAZY but mostly wrong.");
} else {
    include "config.php";
    QueryMeThis("DELETE FROM comments WHERE ID = ?",["i","".$_POST["delete"]]);
    header("location: store.php");
}

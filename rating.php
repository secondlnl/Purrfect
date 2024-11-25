<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo ("Sorry something went CRAZY but mostly wrong.");
} else {
    include "config.php";
    session_start();
    // retrieve the ID of 
    $butt = $_POST["butt"];
    $rt = 0;
    // C
    $boughtquery = "Select Ratedby, Rating FROM products WHERE ID = " . $butt . ";";
    $bresult = $conn->query($boughtquery);
    if ($bresult->num_rows > 0) {
        while ($b = $bresult->fetch_assoc()) {
            if ($b["Rating"] > 0)
                $rt = $b["Rating"];
            if (!substr_count($b["Ratedby"], $_SESSION["un"])) {
                $str = $b["Ratedby"] . " " . $_SESSION["un"] . ",";
                $rt++ ;
            } else $str = $b["Ratedby"];
        }
    }
    //
    $prprd = mysqli_prepare($conn, "UPDATE products SET Rating = ?, Ratedby = ? WHERE ID = " . $butt . ";");
    session_start();

    
    mysqli_stmt_bind_param($prprd, "is", $rt, $str);
    mysqli_stmt_execute($prprd);
    mysqli_stmt_close($prprd);
    mysqli_close($conn);
    header("location: store.php");
}

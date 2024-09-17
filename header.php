<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <link href="style.css" rel="stylesheet"/>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
        <link rel="icon" type="image/gif" href="favicon.gif">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <div id=head>
        <pre><strong> /\ /\
 > w < /
</strong></pre>
            <nav>
                    <a href="about.php">about</a>
<?php
session_start();
if (!isset($_SESSION["loggedin"])) echo "<a href='index.php'>login</a>";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] = true) echo "<a href='account.php'>account</a><a href='store.php'>store</a>";
?>
<form method="get" action=search.php>
<input type="text" placeholder="Search for a product" name="search">
<button type="submit" id="search"><span> <i class="fa fa-search"></i></span></button>
</form>

              </nav>
</div>

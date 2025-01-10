<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <link href="style.css" rel="stylesheet" />
  <link href="utopia.css" rel="stylesheet" />

  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
  <link rel="icon" type="image/gif" href="favicon.gif">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <div id=header>
   <img src="logo.svg" id="logo" alt="Website icon">
   <!-- <img src="paw_print.webp" id="mlogo" alt="Website icon"> -->
<!--
Paw Print webp    
Mutant Standard emoji are licensed CC BY-NC-SA 4.0 International.     
mutant.tech
-->
    <nav id="nav">
      <form id="search-form" method="get" action=search.php>
        <input type="text" id="search" name="search" placeholder="Search for a product" required>
        <div id="thing"><button type="submit" aria-label="search" id="search"><i class="material-icons">search</i></button><label for="search">Search</label></div>
      </form>
      <div id="thing"><a href=about.php aria-label="about" id="about" name="about"><i class="material-icons">&#xe88e;</i></a><label for="about">About</label></div>
      <?php
      session_start();
      // if (!isset($_SESSION["loggedin"])) header("location: index.php");

      if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] = true) echo "<div id='thing'><a href=account.php id='account' name='account'><i class='material-icons'>&#xe7fd;</i></a><label for='account'>Account</label></div><div id='thing'><a href=store.php id='store' name='store'><i class='material-icons'>&#xe54c;</i></a><label for='store'>Store</label></div>";
      ?>



    </nav>
  </div>

<!-- <body> -->
  <!-- <div class="header"> -->
    <!-- Header -->
    <!-- <div class="nav"> -->
      <!-- Navigation -->
    <!-- </div>
  </div>
  <main> -->
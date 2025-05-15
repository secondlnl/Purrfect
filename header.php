<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta charset="utf-8">
  <link href="style.css" rel="stylesheet" />
  <link href="utopia.css" rel="stylesheet" />

  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
  <link rel="icon" type="image/gif" href="favicon.gif">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <div id=header>
    <div class="text" style="display: flex; flex-direction:row; text-align:center;">
      <img src="logo.svg" id="logo" alt="Website icon">
      <h1 style="text-align: center !important;margin: auto">Purrfect</h1>
    </div>
    <nav id="nav">
      <form id="search-form" method="get" action=search.php>
        <input type="text" id="search" name="search" placeholder="Search for a product" required>
        <div id="thing"><button type="submit" aria-label="search" id="search"><i class="material-icons">search</i></button><label for="search" style="margin-left: 0px;margin-top: 0px;">Search</label></div>
      </form>
      <div id="thing"><a href=about.php aria-label="about" id="about" name="about"><i class="material-icons">&#xe88e;</i></a><label for="about">About</label></div>
      <?php
      session_start();

      if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] = true) echo "<div id='thing'><a href=account.php id='account' name='account'><i class='material-icons'>&#xe7fd;</i></a><label for='account'>Account</label></div><div id='thing'><a href=store.php id='store' name='store'><i class='material-icons'>&#xe54c;</i></a><label for='store'>Store</label></div>";
      ?>



    </nav>
  </div>
  <script src="cookie.js"></script>
  <body onload="checkCookie()"><div class="cookie"> banner?</div></body>

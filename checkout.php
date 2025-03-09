<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <script>
    function getRandomInt(min, max) {
      min = Math.ceil(min);
      max = Math.floor(max);
      return Math.floor(Math.random() * (max - min) + min); // The maximum is exclusive and the minimum is inclusive
    }
    var minutes = getRandomInt(1, 6);
    let timeLeft = (minutes * 60); // x minutes in seconds

    function updateTimer() {
      var ah = document.getElementById("popup");
      const timer = document.getElementById("timer");
      if (ah.offsetParent !== null) {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timer.textContent = `in ${minutes}:${seconds < 10 ? '0' : ''}${seconds} min`;

        if (timeLeft > 0) {
          timeLeft--;
          setTimeout(updateTimer, 1000);
        } else {
          timer.textContent = "right now!";
          ah.classList.toggle("done");
        }
      }
    }
  </script>
  <style>
    .outer {
      display: flex;
      justify-content: space-between;
    }
  </style>
</head>
<html>

<body>
  <div id="bg" style="display: none;">
    <div id="popup">
      <div id="box">📦</div>
      <p>Your products are being delivered <span id="timer"></span></p>
      <form method="post" action="clear2.php">
        <button type="submit" class="down">Okay</button>
      </form>
    </div>

  </div>
  <?php
  include "config.php";
  include "header.php";



  echo "<div style='
     
  float: unset;
  padding: 5pt;
  padding-left: 10px ;
  margin: 5pt;'>";
  echo "<h2>Shopping Cart</h2>";
  echo "<div class='outer'>";
  echo "<div><strong>Name</strong></div>";
  echo "<div><strong>Price (kr)</strong></div>";
  echo "</div>";
  $sql = "SELECT * FROM purchases;";
  $result = $conn->query($sql);
  // Check if there are any products
  if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
      // Display product as a receipt
      echo "<div class='outer'>";
      echo "<div>" . $row["Name"] . "</div>";
      echo "<div>" . $row["Price"] . "</div>";
      echo "</div>";
    }
    echo "<button onmousedown='popuptoggle(),updateTimer()'>Checkout</button></form>";
  } else {
    header("location: store.php");
  }

  ?>
</body>

</html>

<script>
  function popuptoggle() {
    var x = document.getElementById("bg");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }
</script>
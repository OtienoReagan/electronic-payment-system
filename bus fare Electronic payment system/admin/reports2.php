<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sbtbsphp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Define your SQL queries
$queries = array(
  "Total Revenue" => "SELECT SUM(booked_amount) AS Total_Revenue FROM bookings",
  "Revenue by Route" => "SELECT route_id, SUM(booked_amount) AS Revenue_By_Route FROM bookings GROUP BY route_id",
  "Revenue by Customer" => "SELECT customer_id, SUM(booked_amount) AS Revenue_By_Customer FROM bookings GROUP BY customer_id",
  "Bus Utilization" => "SELECT b.bus_no, SUM(bk.booked_amount) AS Revenue_By_Bus FROM buses b JOIN routes r ON b.bus_no = r.bus_no JOIN bookings bk ON r.route_id = bk.route_id GROUP BY b.bus_no",
  "Daily Revenue" => "SELECT DATE(booking_created) AS Day, SUM(booked_amount) AS Daily_Revenue FROM bookings GROUP BY Day",
  "Monthly Revenue" => "SELECT MONTH(booking_created) AS Month, SUM(booked_amount) AS Monthly_Revenue FROM bookings GROUP BY Month",
  
);

// Include external CSS
echo '<link rel="stylesheet" type="text/css" href="styles.css">';

// Include JavaScript for downloading TXT files
echo '<script src="scripts.js"></script>';

// Execute each query and display the results in a table
foreach ($queries as $title => $sql) {
  $result = $conn->query($sql);

  echo "<h2>$title</h2>";
  echo "<button onclick='downloadTXT(\"$title\")'>Download as TXT</button>";
  echo "<div id='report_$title' class='report-table'>";
  echo "<table>";

  // Fetch the column names
  $finfo = $result->fetch_fields();
  echo "<thead><tr>";
  foreach ($finfo as $val) {
    echo "<th>" . $val->name . "</th>";
  }
  echo "</tr></thead>";

  // Fetch the rows
  echo "<tbody>";
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      foreach ($row as $column) {
        echo "<td>" . $column . "</td>";
      }
      echo "</tr>";
    }
  } else {
    echo "<tr><td colspan='" . count($finfo) . "'>No results</td></tr>";
  }
  echo "</tbody>";
  echo "</table>";
  echo "</div>";
}

$conn->close();
?>

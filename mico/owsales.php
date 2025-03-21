<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
    <link rel="stylesheet" href="pstock.css">
    <script>
        // JavaScript function to validate the search form
        function validateForm(event) {
            const searchInput = document.forms["order"]["search"].value;
            if (searchInput.trim() === "") {
                alert("Please enter a search term before submitting.");
                event.preventDefault(); // Prevent form submission
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
     <!-- Sidebar -->
     <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="viewoperations.html">View Operations</a></li>
            <li><a href="ownerexportorder.php">Export Order</a></li>
            <!--<li><a href="delivery-location.html">Delivery Location</a></li>-->
            <li><a href="owfinancial.html">Financial Report</a></li>
            <li><a href="ownerpayment.html">Payment Status</a></li>
            
           
            <li><a href="ownersdetail.php">Supplier Details</a></li>
            <li><a href="owmarequest.php">View Request</a></li>
            <li><a href="ownerassigntask.php">Assigning Task</a></li>
            <li><a href="ownerviewfeedback.php">Staff Performance</a></li>
            <li><a href="ownerviewfeedback.php">View Feedback</a></li>
            <!--<li><a href="Home.html">My Profile</a></li>-->
            <li><a href="StDashboard.html">Logout</a></li>
        </ul>
    </aside>
     <main>
     <h1 class="head">Sale Process</h1>

<form name="order" method="get" onsubmit="return validateForm(event)">
    <div>
        <input class="" type="text" name="search" placeholder="Search Sale ID">
        <input type="submit" value="Search">
    </div>

<table>
    <thead>
        <tr>
            <th>Sale ID</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Uprise</th>
            <th>Amount</th>
            <th>Duration</th>
            <th>Record Date</th>
        </tr>
    </thead>
    <tbody>
    <?php
   include('conf.php');

   // Start session to manage login state
   session_start();

   // Initialize base SQL query to select all sales records
   $sql = "SELECT * FROM sale";

   // Check if a search term is provided
   if (isset($_GET['search']) && !empty($_GET['search'])) {
       $searchTerm = $conn->real_escape_string($_GET['search']);
       $sql .= " WHERE saleID LIKE '%$searchTerm%'";
   }

   // Execute the query
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
           echo "<tr>";
           echo "<td>" . ($row["saleID"]) . "</td>";
           echo "<td>" . ($row["pID"]) . "</td>";
           echo "<td>" . ($row["pname"]) . "</td>";
           echo "<td>" . ($row["quantity"]) . "</td>";
           echo "<td>" . ($row["uprise"]) . "</td>";
           echo "<td>" . ($row["amount"]) . "</td>";
           echo "<td>" . ($row["duration"]) . "</td>";
           echo "<td>" . ($row["rdate"]) . "</td>";
           echo "</tr>";
       }
   } else {
       echo "<tr><td colspan='8'>No records found.</td></tr>";
   }

   $conn->close();
   ?>
    </tbody>
</table>
</form>
     </main>
</body>
</html>

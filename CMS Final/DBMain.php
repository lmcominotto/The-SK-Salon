<?php
session_start();

//redirect to login form if not logged in
function redirect() {
  header('Location: admin.php');
  exit();
}

if(isset($_SESSION['id'])) {

  include 'dbh.php';

  $sql = "TRUNCATE TABLE shopping_cart";
  $cart = mysqli_query($conn, $sql);
  ?>


  <!DOCTYPE html>
  <html>
  <head>
  <style>
  ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #333;
  }

  li {
      float: left;
  }

  li a, .dropbtn {
      display: inline-block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
  }

  li a:hover, .dropdown:hover .dropbtn {
      background-color: green;
  }

  li.dropdown {
      display: inline-block;
  }

  .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
  }

  .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      text-align: left;
  }

  .dropdown-content a:hover {background-color: #f1f1f1}

  .dropdown:hover .dropdown-content {
      display: block;
  }

  </style>
  </head>
  <body>

  <ul>
    <li><a href = "includes/logout.inc.php" >Log Out</a></li>
    <li><a href="homepageAdmin.php">Edit Website</a></li>
    <li><a href="DBMain.php">Home</a></li>
    <li><a href="ScanItems.php">Scan Items</a></li>
    <li class="dropdown">
      <a href="javascript:void(0)" class="dropbtn">Customers</a>
      <div class="dropdown-content">
  	  <a href="ViewAllCustomers.php">View All Customers</a>
        <a href="NewCustomer.php">New Customer</a>
        <a href = "EditCustomer.php">Edit Customer</a>
        <a href="DeleteCustomer.php">Delete Customer</a>
      </div>
    </li>
    <li class="dropdown">
      <a href="javascript:void(0)" class="dropbtn">Inventory</a>
      <div class="dropdown-content">
  	  <a href="ViewInventory.php">View Inventory</a>
        <a href="NewItem.php">New Item</a>
        <a href="RestockItem.php">Restock Item</a>
  	  <a href="DeleteItem.php">Delete Item</a>
      </div>
    </li>
    <li class="dropdown">
      <a href="javascript:void(0)" class="dropbtn">Reports</a>
      <div class="dropdown-content">
        <a href="DailyReport.php">Daily</a>
        <a href="WeeklyReport.php">Weekly</a>
  	  <a href="MonthlyReport.php">Monthly</a>
  	  <a href="YearlyReport.php">Yearly</a>
  	  <a href="AllTimeReport.php">All Time</a>
      </div>
  </ul>

  <h3> Welcome to the Inventory Management Portal </h3><br>
  <a>&emsp; Click the <b>Scan Items</b> tab to start a new transaction. <a><br><br>
  <a>&emsp; From the <b>Customers</b> tab, you can add, delete, or view your registered customers. </a><br><br>
  <a>&emsp; From the <b>Inventory</b> tab, you can add, delete, restock, or view your inventory. </a><br><br>
  <a>&emsp; The <b>Reports</b> tab will let you generate either a daily, monthly, or yearly transaction report. </a><br><br><br>
  <a><i>*Note: Accessing this page empties your shopping cart.</i></a>

  </body>
  </html>

<?php 
  } else {
    redirect();
  }
?>
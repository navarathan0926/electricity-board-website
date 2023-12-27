<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="../css/admin_style2.css">
</head>
<body>
<header class="header">

<div class="flex">

   <a href="admin_page.php" class="logo">Admin</a>

   <nav class="navbar">
      <a href="admin_home.php">Home</a>
      <a href="powercut_schedule.php">Powercut</a>
      <a href="manage_unit_prices.php">Unit prices</a>
      <a href="manage_users.php">Manage bills</a>
      <a href="manage_complaints.php">Complaints</a>
   </nav>

   <div class="icons">
      <div id="menu-btn" class="fas fa-bars"></div>
      <div id="user-btn" class="fas fa-user-circle">
      <span class="user">
         <?php
         if(isset($_SESSION['admin_name'])){
            echo $_SESSION['admin_name']; 
            ?>
            <a href="../logout.php" class="delete-btn">logout</a>
            <?php
         }
         
         ?>
         </span>
      </div> 
   </div>
</div>

</header>
<!-- js file for admin panel  -->

<script src="../js/admin_script.js"></script>
</body>
</html>



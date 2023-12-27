<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="../css/style7.css">
</head>
<body>
<header class="header">
   <div class="header-2">
      <div class="flex">

      <a><img src="../images/Logo2.jpg" height="70" width="100"></a>
         <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="calculate_bills2.php">Calculate Bills</a>
            <a href="show_bills.php">Show Bills</a>
            <a href="complaint.php">Complaints</a>
         </nav>

         <div class="icons">
           
            <div id="menu-btn" class="fas fa-bars"></div>
            <?php  
            if(isset($_SESSION['user_id'])){  
            ?>
                  <div id="user-btn" class="fas fa-user ">
                     <span class="user">
                     <?php echo $_SESSION['username']; ?>
                     </span>
                     <a href="../logout.php" class="delete-btn">logout</a>
                  </div>
               
            <?php
            }

            
            ?>
       
           
         </div>
       
       
     
   </div>


   
</header>

<section class="home">

   <div class="content">
      <!-- <h3></h3> -->
   </div>

</section>

<script src="../js/script.js"></script>
<?php

include '../connection.php';

session_start();

if(isset($_SESSION['admin_id'])){
    $admin_id =$_SESSION['admin_id'];    
}


if(!isset($admin_id)){
   header('location:../login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <style>
      body{
         
         /* background: url(../images/bcg2.png) no-repeat; */
         /* background:linear-gradient(rgba(0,0,0,.7), rgba(0, 0, 0, 0.7)), url(../images/bg4.jpg) no-repeat;  */
      }
   </style>


</head>
<body>
   
<?php include 'admin_header.php'; ?>


<section class="dashboard">

      

   <h1 class="title">dashboard</h1>

   

   <div class="box-container">
        <div class="box4">
            <?php 
                $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
                $number_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?php echo $number_of_users; ?></h3>
            <p>Users</p>
           
        </div>
        

        <div class="box4">
            <?php 
                $select_pendings = mysqli_query($conn, "SELECT * FROM `bills` WHERE payment_status = 'Not Paid'") or die('query failed');
                $number_of_pendings = mysqli_num_rows($select_pendings);
            ?>
            <h3><?php echo $number_of_pendings; ?></h3>
            <p>Num of Pendings</p>
        </div>
        
      <div class="box4">
         <?php
            $total_pendings = 0;
            $select_pending = mysqli_query($conn, "SELECT * FROM `bills` WHERE payment_status = 'Not Paid'") or die('query failed');
            if(mysqli_num_rows($select_pending) > 0){
               while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                  $pendings= $fetch_pendings['amount'];
                  $total_pendings += $pendings;
               }
            }
         ?>
         <h3>Rs<?php echo $total_pendings; ?>/-</h3>
         <p>Total pendings</p>
      </div>

      <div class="box4">
            <?php 
            $number_of_notices=0;
                $select_notice= mysqli_query($conn, "SELECT COUNT(*) as count ,acc_num FROM `bills` WHERE payment_status = 'Not Paid' GROUP BY acc_num") or die('query failed');
                if(mysqli_num_rows($select_notice)>0){
                    while($fetch_notice=mysqli_fetch_assoc($select_notice)){
                        if($fetch_notice['count']>2){
                            $number_of_notices++;
                        }
                    }
                }
                
            ?>
         <h3><?php echo $number_of_notices; ?></h3>
         <p>Red notices</p>
      </div>
      
      <div class="box4">
         <?php 
            $select_msg = mysqli_query($conn, "SELECT * FROM `complaints` where reply is NULL") or die('query failed');
            $number_of_msg = mysqli_num_rows($select_msg);
         ?>
         <h3><?php echo $number_of_msg; ?></h3>
         <p>New Complaints</p>
      </div>

      <div class="box4">
      <?php 
            $select_msg = mysqli_query($conn, "SELECT * FROM `complaints` where reply is NOT NULL") or die('query failed');
            $number_of_msg = mysqli_num_rows($select_msg);
         ?>
         <h3><?php echo $number_of_msg; ?></h3>
         <p>Replied Complaints</p>
      </div>

   
   </div>
   

</section>





</body>
</html>


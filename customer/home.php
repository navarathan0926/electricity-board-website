<?php

include '../connection.php';

session_start();

if(isset( $_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];   
}

if(isset($_POST['issue'])){
   $pbm=$_POST['problem'];
   mysqli_query($conn, "INSERT INTO `complaints`(user_id, problem) VALUES ('$user_id', '$pbm')");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>
   <style>
      
      .box-bg{
         background-color: gray;
         padding:20px;
      }
   </style>
</head>
<body >
   <?php
      if(!isset($user_id)){
         ?>
         <div class="logi">
            <p>
            <a href="../login.php">login</a> 
            <a href="../reg.php">register</a> 
            </p>
         </div>
         <?php
      }
   ?>
   

   <?php include 'header.php'; ?>

   <section class="imges-container" >
      <div class="imges">
         <img src="../images/image2.jpg" alt="">

      </div>

      <div class="imges">
         <img src="../images/light.jpg" alt="">

      </div>
      
      <div class="imges">
         <img src="../images/images.jpg" alt="">

      </div>

   </section>

   <?php
        if(isset($_SESSION['user_id'])){
            $zone=mysqli_query($conn,"SELECT * FROM `area` WHERE `area` IN (SELECT `area` FROM `users` WHERE `user_id`='$user_id')");
            while($fetch_group=mysqli_fetch_assoc($zone)){
                $group=$fetch_group['zone'];
                $ar=$fetch_group['area'];
                $today=date("Y-m-d") ;
            }
            $find=mysqli_query($conn,"SELECT * FROM `powercut` WHERE `start_time` LIKE '%$today%' AND `zone` LIKE '%$group%' ");
            if(mysqli_num_rows($find)>0){
                while($fetch_data=mysqli_fetch_assoc($find)){
                    echo '<h1 class="bg">Your Area '.$ar.' has powercut from '.$fetch_data['start_time'].' to '.$fetch_data['end_time'].'</h1>';   
                }
            }
        }
    ?>


   <section class="products ">

         <h1 class="caption">Electricity</h1>

         <div class="box-container">
            
         </div>
         <?php 
            if(isset($_SESSION['user_id'])){
               ?>
               <div class="load-more" style="margin-top: 20px; text-align:center">
                  <a href="complaint.php" class="home-btn">Complaints </a>
               </div>
               <?php
            }
         ?>
   </section>

   <section class="container body">
      <form action=""  method="post" class="form2 ">
       
         <table class="box2">
            <tr>
               <td>
                  <h1>You can Find other Zones:</h1>
               </td>
            </tr>
            <tr>
               <td>
               <input type="text" class="box2"  name="zone" placeholder="Enter other Zone">
               </td>
            </tr>
            <tr>
               <td>
                  <input type="date" class="box2" name="date" data-date-format="yyyy-mm-dd" placeholder="dd-mm-yyyy">
               </td>
            </tr>
            <tr>
               <td>
                  <input type="submit" class="option-btn" name="schedule"  value="Powercut time">
               </td>
            </tr>
         </table>  
      </form>
   
    <?php    
    if(isset($_POST['schedule'])){
         $group=$_POST['zone'];
         $date=$_POST['date'];


         $find=mysqli_query($conn,"SELECT * FROM `powercut` WHERE `start_time` LIKE '%$date%' AND `zone` LIKE '%$group%'");
         if(mysqli_num_rows($find)>0){
            while($fetch_data=mysqli_fetch_assoc($find)){
                echo '<h1 class="bg2">'.$fetch_data['start_time'].' to '.$fetch_data['end_time'].'</h1>';
            }
         }else{
            echo '<h1 class="bg2">incorrect</h1>';
         }
      }

    ?>  
    <!-- to find Zone by using area-->
    <form action=""  method="post" class="form2">
         <table class="box2">
            <tr>
               <td>
                  <h1>find the Zone:</h1>
               </td>
            </tr>
            <tr>
               <td>
               <select name="place" class="box2" placeholdrer="select area:">
                <option value="">Select an area:</option>
               <?php
                $area=mysqli_query($conn, "SELECT * FROM `area`");
                if(mysqli_num_rows($area)>0){
                    while($fetch_area=mysqli_fetch_assoc($area)){
                        ?>
                        <option value="<?php echo $fetch_area['area'] ?>"><?php echo $fetch_area['area'] ?></option>
                        <?php
                    }
                }
               ?>  
            </select>
               </td>
            </tr>
            <tr>
               <td>
                  <input type="submit" class="option-btn" name="finding" value="Find Letter">
               </td>
            </tr>
         </table>
      </form>

      <?php
            if(isset($_POST['finding'])){
               $place=$_POST['place'];
               $area=mysqli_query($conn, "SELECT * FROM `area` WHERE `area` = '$place'");
                     if(mysqli_num_rows($area)>0){
                           while($fetch_place=mysqli_fetch_assoc($area)){
                              echo '<h1 class="bg2">'.$fetch_place['zone'].'</h1>';
                           }
                     }
         }
      ?>
   </section>


   <section class="container ">

      <div class="flex">
         <div class="form2">
            <div class="box2">
            <h3 >
            <?php
               if(isset($_SESSION['user_id'])){
                  $warn=mysqli_query($conn,"SELECT * FROM `bills` WHERE payment_status='Not Paid' AND acc_num IN(SELECT acc_num FROM `users` WHERE user_id='$user_id')");
                  if(mysqli_num_rows($warn)>2){
                        echo '<h1>You have to pay '.mysqli_num_rows($warn).' month bill.</h1>';
                  }
               }
               
            ?>
            </h3>
            <a href="show_bills.php" class="btn">To see your bill detais</a>

            <!-- <a href="../images/Lecture4.pdf" class="delete-btn" download>Download the pdf</a> -->
            </div>
         </div>
            

      </div>
   </section>

   <?php include 'footer.php'; ?>



</body>
</html>
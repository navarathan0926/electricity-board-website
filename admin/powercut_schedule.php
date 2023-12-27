<?php

include '../connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../login.php');
};

if(isset($_POST['schedule'])){


   $start=$_POST['start_time'];
   $end=$_POST['end_time'];
   $zone=$_POST['zone'];

    $schedule=mysqli_query($conn,"INSERT INTO `powercut`(start_time, end_time, zone) VALUES ('$start', '$end', '$zone')")or die('query failed');
    if($schedule){
        echo "Succesfully added.";
    }   
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Powercut Schedule</title>

   <!-- font awesome link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <style>
      body{
         /* background: url(../images/bg4.jpg) no-repeat; */
      }
   </style>

</head>
<body>
   
<?php include 'admin_header.php'; ?>



<h1 class="title">Powercut Schedule</h1>

<section class="add-schedule">


   <form action="" method="post" enctype="multipart/form-data">
      <h3>Add schedule</h3>
      <input type="datetime-local" name="start_time" class="box" required>
      <input type="datetime-local" name="end_time" class="box"  required>
      <input type="text" name="zone" class="box" required>
      <input type="submit" value="Schedule" name="schedule" class="btn">
   </form>

</section>




<!-- custom admin js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
<?php

include '../connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];


if(!isset($admin_id)){
   header('location:../login.php');
};

if(isset($_POST['set'])){


   $first=$_POST['first'];
   $second=$_POST['second'];
   $third=$_POST['third'];
   $fourth=$_POST['fourth'];
   $fifth=$_POST['fifth'];
   $sixth=$_POST['sixth'];
   $seventh=$_POST['seventh'];
   $type=$_POST['type'];
  
   $date=date('Y-m-d H:i:s');
    $set=mysqli_query($conn,"INSERT INTO `units`(first, second, third, fourth, fifth, sixth, seventh,date, type) VALUES ('$first', '$second', '$third', '$fourth', '$fifth', '$sixth', '$seventh', '$date','$type')")or die('query failed');
    if($set){
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
      /* body{
         background: url(../images/light2.jpg) no-repeat;
         background-size: cover;
         background-position: center;
      } */
   </style>


</head>
<body>
   
<?php include 'admin_header.php'; ?>



<h1 class="title">Unit prices</h1>

<section class="add-schedule">


   <form action="" method="post" >
        <h3>Add prices</h3>
        <input type="number" name="first" step=0.01 placeholder="price for 0-30 units(for bellow 60 units)" class="box" required>
        <input type="number" name="second" step=0.01 placeholder="price for 31-60 units(for bellow 60 units)" class="box" required>
        <input type="number" name="third" step=0.01 placeholder="price for 0-60 units(for above 60 units)" class="box" required>
        <input type="number" name="fourth" step=0.01 placeholder="price for 61-90 units" class="box" required>
        <input type="number" name="fifth" step=0.01 placeholder="price for 91-120 units" class="box" required>
        <input type="number" name="sixth" step=0.01 placeholder="price for 121-180 units"class="box" required>
        <input type="number" name="seventh" step=0.01 placeholder="price for above 180 units" class="box" required>
        <select name="type" class="box" >
            <option value="unitPrice" >Unit price</option>
            <option value="fixedPrice" >Fixed price</option>
        </select>
      <input type="submit" value="Set Price" name="set" class="btn">
   </form>

</section>




<!-- custom admin js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
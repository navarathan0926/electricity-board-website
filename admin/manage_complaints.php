<?php

include '../connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../login.php');
};

if(isset($_POST['send'])){

    $reply_id=$_POST['com_id'];
    $reply=$_POST['reply'];

    $schedule=mysqli_query($conn,"UPDATE `complaints` SET reply='$reply' WHERE com_id='$reply_id' ")or die('query failed');
    if($schedule){
        echo "Reply sent.";
    }   
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>manage complaints</title>

   <!-- font awesome link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body{
         /* background: url(../images/blb.jpg) no-repeat; */
      }
    </style>
   
   

</head>
<body>
   
<?php include 'admin_header.php'; ?>



<h1 class="title">Customer Compliaints</h1>

<section class="add-schedule">
    <?php
        $com_query=mysqli_query($conn,"SELECT * FROM `complaints` WHERE reply IS Null; ");
        if(mysqli_num_rows($com_query)>0){
            while($fetch_com=mysqli_fetch_assoc($com_query)){
                ?>
                <div class="box">
                <form action="" method="post" >
                    <h3>Complaint id: <?php echo $fetch_com['com_id'] ;?></h3>
                    <p>From: <?php echo $fetch_com['user_id'] ;?></p>
                    <p>Reported time: <?php echo $fetch_com['time'] ;?></p>
                    <!-- <h4>Problem: <?php echo $fetch_com['problem'] ;?></h4> -->
                    <!-- <input type="text" name="problem" class="box" value="Problem: <?php echo $fetch_com['problem']; ?>" readonly> -->
                    <textarea name="problem" class="box"  cols="30" rows="10" readonly>Problem: <?php echo $fetch_com['problem']; ?></textarea>
                    <input type="text" name="reply" class="box" placeholder="reply here">
                    <input type="hidden" name="com_id" value="<?php echo $fetch_com['com_id']; ?>">
                    <input type="submit" value="Reply" name="send" class="btn">
                </form>
                </div>
                <?php
            }
        }else{
            echo "No new Complaints reported.";
        }
    ?>

   

</section>




<!-- custom admin js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
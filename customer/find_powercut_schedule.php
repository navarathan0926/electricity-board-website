<?php

    include '../connection.php';

    session_start();

    if(isset( $_SESSION['user_id'])){
    $user_id = $_SESSION['user_id']; 
    
    }
    
    if(!isset($user_id)){
       header('location:../login.php');
    }

   


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Powercut Schedule</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   
    <style>
        
    </style>
</head>
<body>
    


    <?php include 'header.php'; ?>

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
<section class="container">
    
    <form action=""  method="post" class="form2">
        <h1>You can Find other Zones:</h1>
        <input type="text" class="box2"  name="zone" placeholder="Enter other Zone:">
        <input type="date" class="box2" name="date" data-date-format="yyyy-mm-dd" placeholder="dd-mm-yyyy">
       
        <input type="submit" class="option-btn" name="schedule" value="search">
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
        <h1>find the Zone:</h1>
        <div >

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
         </div>
        <input type="submit" class="option-btn" name="finding" value="Find Letter">
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

    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>
</html>
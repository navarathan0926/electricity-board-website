<?php
    include '../connection.php';

    session_start();

    if(isset( $_SESSION['user_id'])){
    $user_id = $_SESSION['user_id']; 
    }
    
    if(!isset($user_id)){
       header('location:../login.php');
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
    <title>help</title>
    <style>
        body{
            background-color:#dfe6e9;
        }
    </style>
   
</head>
<body>
    
<div class="logi">
    <p>
        <a href="login.php">login</a> 
        <a href="register.php">register</a> 
    </p>
</div>

    <?php include 'header.php'; ?>

    <!-- <section class="imges-container " >
      <div class="imges">
         <img src="../images/bg6.jpg" height="300px" alt="">

      </div>

      <div class="imges">
         <img src="../images/blb2.jpg" height="300px" alt="">

      </div>
      
      <div class="imges">
         <img src="../images/bg4.jpg" height="300px" alt="">

      </div>

   </section> -->
<!-- <div class="bg-image">

</div> -->
    <section id="com" class="form2">
        <div class="box2">
                <div class="blk">
                    <h1>Complaints</h1>
                    <form action="" method="post" >
                        <textarea name="problem" id="" cols="30" rows="10" ></textarea><br>
                        <input type="submit" class="delete-btn" name="issue">
                    </form>
                </div>
        </div>   
    </section>

    <section class=" form2">
        <div>
            <table>
                <tr>
                    <th>Time</th>
                    <th>Complaint</th>
                    <th>Reply</th>
                </tr>
                <?php
                $com=mysqli_query($conn,"SELECT * FROM `complaints` WHERE user_id='$user_id'");
                if(mysqli_num_rows($com)>0){
                    while($fetch_com=mysqli_fetch_assoc($com)){
                        $time=$fetch_com['time'];
                        $prob=$fetch_com['problem'];
                        $reply=$fetch_com['reply'];
                        ?>
                        <tr>
                            <td><?php echo $time; ?></td>
                            <td><?php echo $prob; ?></td>
                            <td><?php echo $reply; ?></td>
                        </tr>
                        <?php
                    }
                }else{
                    echo 'No complaints reported';
                }
                ?>
                
            </table>
            
        </div>
    </section>


    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>
</html>
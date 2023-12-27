<?php

include 'connection.php';

if(isset($_POST['submit'])){

   $acc_no = mysqli_real_escape_string($conn, $_POST['acc_no']);
   $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
   $NIC = mysqli_real_escape_string($conn, $_POST['NIC']);

   $check=mysqli_query($conn, "SELECT * FROM `account_details` WHERE `acc_num`='$acc_no' AND `NIC`='$NIC'");
   if(mysqli_num_rows($check)>0){
        while($details=mysqli_fetch_assoc($check)){
           
                $username=mysqli_real_escape_string($conn, $_POST['username']);
                $email=mysqli_real_escape_string($conn, $_POST['email']);
                $mobile=mysqli_real_escape_string($conn, $_POST['mobile']);
                $area=mysqli_real_escape_string($conn, $_POST['area']);
                $psw = mysqli_real_escape_string($conn, md5($_POST['password']));
                $cpsw = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
                $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE `email` = '$email'") or die('query failed');
                
                if($psw != $cpsw){
                    echo '<h1>Password does not match!</h1>';
                }else{
                    if(mysqli_num_rows($select_users) > 0){
                        echo '<h1>user already exist!</h1>';
                        
                    }else{  
                            mysqli_query($conn, "INSERT INTO `users`(`acc_num`, `username`, `email`, `mobile`, `area`, `password`) VALUES('$acc_no', '$username', '$email', '$mobile', '$area', '$psw')")or die('query failed');
                            header('location:login.php');      
                    }
                
                }
            
        }  
   }else{
        echo "<h1 >Please insert correct Account Nmber and NIC!</h1>";
   }

}
        
      ?>
   
         
   

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  
   <link rel="stylesheet" href="css/style7.css">

</head>
<body>



<div class="form1">

   <form action="" method="post">
        <h3>register now </h3>
        <input type="text" name="acc_no" placeholder="acc no"  required class="box" pattern="[0-9]{6}">
        <input type="text" name="fullname" placeholder="enter full name" required class="box" pattern="[A-Za-z ]{5,100}">
        <input type="text" name="NIC" placeholder="enter NIC" required class="box" pattern="[0-9]{9}[x|X|v|V]|[0-9]{12}"> 
   
        <input type="text" name="username" placeholder="enter username" required class="box" pattern="[A-Za-z]{5,100}">
        <input type="text" name="mobile" placeholder="enter your mobile number" required class="box" pattern="[0-9]{10}">
        <input type="email" name="email" placeholder="enter your email" required class="box" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
        <div class="box">
            <span>Your Area:</span>
            <select name="area">
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
        <input type="password" name="password" placeholder="enter your password" required class="box" pattern="/^[a-zA-Z0-9!@#\$%\^\&*_=+-]{8,30}$/g">
        <input type="password" name="cpassword" placeholder="confirm your password" required class="box" pattern="/^[a-zA-Z0-9!@#\$%\^\&*_=+-]{8,30}$/g">
        <input type="submit" name="submit" value="user register" class="home-btn">
        <p>already have an account? <a href="login.php">login now</a></p>
        </form>
   

</div>

</body>
</html>



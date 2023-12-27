<?php

include 'connection.php';
$fname_er = $acc_er = $Nic_er=  $psw_er= $uname_er='';
     $email_er= $mobile_er= $area_er ='';
    $acc_no = $username = $email= $NIC= $psw= $mobile= $area ='';

if(isset($_POST['submit'])){
    

    if(preg_match('/^\d+$/', $_POST['acc_no'])) {
        $acc_no = mysqli_real_escape_string($conn, $_POST['acc_no']);
    }else{
        $acc_er="Account numbers have only numbers!";
    }

    if(preg_match("/^[a-zA-Z'-]+$/", $_POST['fullname'])) {
        $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    }else{
        $fname_er="Fullname contains only letters and whute spaces!";
    }
   
    if(preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $_POST['NIC'])) {
        $NIC = mysqli_real_escape_string($conn, $_POST['NIC']);
    }else{
        $Nic_er="NIC should be in correct format";
    }
   

   $check=mysqli_query($conn, "SELECT * FROM `account_details` WHERE `acc_num`='$acc_no' AND `NIC`='$NIC'");
   if(mysqli_num_rows($check)>0){
        while($details=mysqli_fetch_assoc($check)){

                // $email=mysqli_real_escape_string($conn, $_POST['email']);
                // $mobile=mysqli_real_escape_string($conn, $_POST['mobile']);
                // $area=mysqli_real_escape_string($conn, $_POST['area']);
                
                // if(preg_match('/^[0-9]{10}+$/', $_POST['password'])) {
                //     $psw = mysqli_real_escape_string($conn, md5($_POST['password']));
                    
                // }else{
                //     $psw_er="Password should contains atleast 8 characters including upper case, lower case, numbers and special characters.";
                // }

                

                $number = preg_match('@[0-9]@', $_POST['password']);
                $uppercase = preg_match('@[A-Z]@', $_POST['password']);
                $lowercase = preg_match('@[a-z]@', $_POST['password']);
                $specialChars = preg_match('@[^\w]@', $_POST['password']);
                
                if(strlen($_POST['password']) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
                echo "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
                } else {
                    $psw = mysqli_real_escape_string($conn, md5($_POST['password']));
                }

                $cpsw = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
                $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE `email` = '$email'") or die('query failed');


                // function email_validation($mail) {
                //     return (!preg_match(
                // "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $mail))
                //         ? FALSE : TRUE;
                // }
                  
                if(preg_match('/^\w{5,}$/', $_POST['username'])) {
                    $username=mysqli_real_escape_string($conn, $_POST['username']);
                }else{
                    $uname_er="username should be atleast 5 characters and in a correct format";
                }


                if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^/", $_POST['email'])) {
                    $email=mysqli_real_escape_string($conn, $_POST['email']);
                }else{
                    $email_er="enter email in correct format";
                }

                if(preg_match('/^[0-9]{10}+$/', $_POST['mobile'])) {
                    $mobile=mysqli_real_escape_string($conn, $_POST['mobile']);
                }else{
                    $mobile_er="Mobile number has only 10 numbers";
                }

                if(preg_match("/^[a-zA-Z'-]+$/", $_POST['area'])) {
                    $area=mysqli_real_escape_string($conn, $_POST['area']);
                }else{
                    $area_er="Area name has only letters without numbers";
                }
                
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
        <input type="text" name="acc_no" placeholder="acc no"  required class="box" ><span> <?php echo $acc_er;?></span>
        <input type="text" name="fullname" placeholder="enter full name" required class="box" ><span> <?php echo $fname_er;?></span>
        <input type="text" name="NIC" placeholder="enter NIC" required class="box" ><span> <?php echo $Nic_er;?></span>
   
        <input type="text" name="username" placeholder="enter username" required class="box" ><span><?php echo $uname_er;?></span>
        <input type="text" name="mobile" placeholder="enter your mobile number" required class="box"><span> <?php echo $mobile_er;?></span>
        <input type="email" name="email" placeholder="enter your email" required class="box"><span> <?php echo $email_er;?></span>
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
               
            </select><span> <?php echo $area_er;?></span>
         </div>
        <input type="password" name="password" placeholder="enter your password" required class="box"><span> <?php echo $psw_er;?></span>
        <input type="password" name="cpassword" placeholder="confirm your password" required class="box"><span> <?php echo $psw_er;?></span>
        <input type="submit" name="submit" value="user register" class="home-btn">
        <p>already have an account? <a href="login.php">login now</a></p>
        </form>
   

</div>

</body>
</html>



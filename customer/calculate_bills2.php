<?php
    include '../connection.php';

    session_start();

    if(isset( $_SESSION['user_id'])){
    $user_id = $_SESSION['user_id']; 
    
    }

    
    $query=mysqli_query($conn,"SELECT * FROM `units` WHERE type='unitPrice' ORDER BY `date` DESC LIMIT 1");
    $fixed_price=mysqli_query($conn,"SELECT * FROM `units` WHERE type='fixedPrice' ORDER BY `date` DESC LIMIT 1");
    if(mysqli_num_rows($query)>0){
        while($level=mysqli_fetch_array($query)){
            $first=$level['first'] ;         //  0-30
            $second=$level['second'] ;      //  31-60
            $third=$level['third'] ;       //  61-90
            $fourth=$level['fourth'] ;     //  91-120
            $fifth=$level['fifth'] ;      //  121-180
            $sixth=$level['sixth'] ;      //  more than 180
            $seventh=$level['seventh'] ;

            $result_str = $result = '';
            if (isset($_POST['unit-submit'])) {
                $units = $_POST['units'];
                $days = $_POST['days'];
                if (!empty($units)) {
                    while($fetch_fixed=mysqli_fetch_assoc($fixed_price)){
                        $one=$fetch_fixed['first'];
                        $two=$fetch_fixed['second'];
                        $three=$fetch_fixed['third'];
                        $four=$fetch_fixed['fourth'];
                        $five=$fetch_fixed['fifth'];
                        $six=$fetch_fixed['sixth'];
                        $seven=$fetch_fixed['seventh'];   

                        $result = calculate_bill($units,$days,$first,$second,$third,$fourth,$fifth,$sixth,$seventh,$one,$two,$three,$four,$five,$six,$seven);
                        // $result_str = 'Total amount of ' . $units . ' for '. $days .' - ' . $result;
                        $result_str = 'Total amount of ' . $units . ' units for<br>'. $days .' days = Rs ' . $result;
                    }
                
                        
                    
                    
                }
            }
        }
    }
       
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculate Bill Amount</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    

    <?php include 'header.php'; ?>


    <section class="imges-container " >
      <div class="imges">
         <img src="../images/bg6.jpg" height="300px" alt="">

      </div>

      <div class="imges">
         <img src="../images/bg5.jpg" height="300px" alt="">
         <div class="box3">
            <p>You can be able to calculate bills yourself.</p>
        </div>
      </div>
      
      <div class="imges">
         <img src="../images/bg4.jpg" height="300px" alt="">

      </div>
     
   </section>
        


<section class="container ">


    
<?php

/**
 * To calculate electricity bill as per unit cost
 */
function calculate_bill($units,$days,$first,$second,$third,$fourth,$fifth,$sixth,$seventh,$one,$two,$three,$four,$five,$six,$seven) {




$fixed=0;
if(($days>30) && ($days<55)){
    $fixed=30;
}else if($days>=55){
    $fixed=30;
    for($i=55;$i<=$days;$i+=30){
        $fixed+=30;
    }
}


// echo $fixed;
    
if($units/$days<=2){
    if($units <= (1*$days)) {
        $bill = ($units * $first)+$fixed;
    }
    else if($units > (1*$days) && $units <= (2*$days)) {
        $temp = (1*$days) * $first;
        $remaining_units = $units - (1*$days);
        $bill = $temp + ($remaining_units * $second)+$two;
    }
}else{
    if($units > (2*$days) && $units <= (3*$days) ) {
        $temp = (2*$days) * $third;
        $remaining_units = $units - (2*$days);
        $bill = $temp + ($remaining_units * $fourth)+$four;
    }
    else if($units > (3*$days) && $units <= (4*$days) ) {
        $temp = ((2*$days) * $third) +((1*$days) * $fourth) ;
        $remaining_units = $units - (3*$days);
        $bill = $temp + ($remaining_units * $fifth)+$five;
    }
    else if($units > (4*$days) && $units <= (6*$days) ) {
        $temp = ((2*$days) * $third) + ((1*$days) * $fourth)+((1*$days) * $fifth);
        $remaining_units = $units - (4*$days);
        $bill = $temp + ($remaining_units * $sixth)+$six;
    }
    else {
        $temp = ((2*$days) * $third) + ((1*$days) * $fourth)+((1*$days) * $fifth)+((2*$days) * $sixth);
        $remaining_units = $units - (6*$days);
        $bill = $temp + ($remaining_units * $seventh)+$seven;
    }
    
}  
return number_format((float)$bill, 2, '.', '');
    
}


?>

    <div class="box-container">
        <div class="form2 wide ">
            

            <form action="" method="post" id="quiz-form" class="form2 box-bg" style="padding:50px 100px;">
                <table>
                    <tr>
                        <td>
                            <h1 >Calculate your bill</h1>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="number" name="units" class="box2" placeholder="Please enter number of Units" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="number" name="days" class="box2" placeholder="Please enter number of days" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="unit-submit" class="option-btn" value="Submit" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo '<h4 >' . $result_str.'</h4>'; ?>
                        </td>
                    </tr>
                </table>
            </form>

            
        </div>
    </div>
</section>

    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>
</html>
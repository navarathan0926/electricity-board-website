<?php

include '../connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];


if(!isset($admin_id)){
   header('location:../login.php');
};

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
                        $result_str =$result;
                    }   
                }
            }
        }
    }


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
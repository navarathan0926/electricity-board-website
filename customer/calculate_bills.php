<?php
    include '../connection.php';

    session_start();

    if(isset( $_SESSION['user_id'])){
    $user_id = $_SESSION['user_id']; 
    
    }


    $query=mysqli_query($conn,"SELECT * FROM `units` ORDER BY `date` DESC LIMIT 1");
    if(mysqli_num_rows($query)>0){
        while($level=mysqli_fetch_array($query)){
            $first=$level['first'] ;         //  0-30
            $second=$level['second'] ;      //  31-60
            $third=$level['third'] ;       //  61-90
            $fourth=$level['fourth'] ;     //  91-120
            $fifth=$level['fifth'] ;      //  121-180
            $sixth=$level['sixth'] ;      //  more than 180
            

            $result_str = $result = '';
            if (isset($_POST['unit-submit'])) {
                $units = $_POST['units'];
                if (!empty($units)) {
                    $result = calculate_bill($units,$first,$second,$third,$fourth,$fifth,$sixth);
                    $result_str = 'Total amount of ' . $units . ' - ' . $result;
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

<section class="container">


    
<?php


/**
 * To calculate electricity bill as per unit cost
 */
function calculate_bill($units,$first,$second,$third,$fourth,$fifth,$sixth) {
    
  
    if($units <= 30) {
        $bill = $units * $first;
    }
    else if($units > 30 && $units <= 60) {
        $temp = 30 * $first;
        $remaining_units = $units - 30;
        $bill = $temp + ($remaining_units * $second);
    }
    else if($units > 60 && $units <= 90 ) {
        $temp = (30 * $first) + (30 * $second);
        $remaining_units = $units - 60;
        $bill = $temp + ($remaining_units * $third);
    }
    else if($units > 90 && $units <= 120 ) {
        $temp = (30 * $first) + (30 * $second)+(30 * $third);
        $remaining_units = $units - 90;
        $bill = $temp + ($remaining_units * $fourth);
    }
    else if($units > 120 && $units <= 180 ) {
        $temp = (30 * $first) + (30 * $second)+(30 * $third)+(30 * $fourth);
        $remaining_units = $units - 120;
        $bill = $temp + ($remaining_units * $fifth);
    }
    else {
        $temp = (30 * $first) + (30 * $second)+(30 * $third)+(30 * $fourth)+(60 * $fifth);
        $remaining_units = $units - 180;
        $bill = $temp + ($remaining_units * $sixth);
    }
    return number_format((float)$bill, 2, '.', '');
}


?>

    <div class="box-container">
        <div class="form1 wide">
            

            <form action="" method="post" id="quiz-form" style="padding:50px 100px;">
                <table class="box2">
                    <tr>
                        <th><h1 >Calculate your bill</h1></th>
                    </tr>
                    <tr>
                        <td>
                            <input type="number" name="units" class="box" placeholder="Please enter no. of Units" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <input type="submit" name="unit-submit" class="option-btn" value="Submit" />
                        </td>
                    </tr>
                </table>
                <?php echo '<h1>' . $result_str.'</h1>'; ?>

            </form>

            
        </div>
    </div>
</section>

    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>
</html>
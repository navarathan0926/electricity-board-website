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
                        $result_str = 'Total amount of ' . $units . ' for '. $days .' - ' . $result;
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
if(isset($_POST['bill'])){
   $acc_num=$_POST['acc_num'];
   $date=$_POST['date'];
   $units=$_POST['units'];
   $amount=$_POST['amount'];
   
    $bill=mysqli_query($conn,"INSERT INTO `bills`(acc_num, date, units, amount) VALUES ('$acc_num', '$date', '$units', '$amount')")or die('query failed');
    if($bill){
        echo "Bill Succesfully added.";
    }   
}

if(isset($_POST['update_bill'])){
    $bill_update_id = $_POST['u_bill_id'];
    $update_acc = $_POST['u_acc_num'];
    $update_date= $_POST['u_date'];
    $update_units = $_POST['u_units'];
    $update_amount = $_POST['u_amount'];
    $update_payment_status = $_POST['u_payment_status'];
    

    mysqli_query($conn, "UPDATE `bills` SET acc_num='$update_acc', date='$update_date', units='$update_units', amount='$update_amount' , payment_status='$update_payment_status' WHERE bill_id ='$bill_update_id'") or die('query failed');
    $message[] = 'Bill details have been updated!';
}
 
 if(isset($_GET['delete_bills'])){
    $delete_id = $_GET['delete_bills'];
    mysqli_query($conn, "DELETE FROM `bills` WHERE bill_id = '$delete_id'") or die('query failed');
    header('location:manage_users.php');
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Manage users</title>

   <!-- font awesome link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!--  css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>



<h1 class="title">Powercut Schedule</h1>

<section class="add-foods">


    <form action="" method="post" >
        <h3>Add bill</h3>
        
        <input type="text" name="acc_num" placeholder="Account number" class="box" required>
        <input type="date" name="date" placeholder="Date" class="box" required>
        <input type="number" name="units" placeholder="Units" class="box" required>
        <input type="number" step="0.01" name="amount" placeholder="Bill amount" class="box" required>
        <select name="payment_status" class="box" >
            <option value="Not Paid" >Not Paid</option>
            <option value="Paid" >Paid</option>
        </select>
        <input type="submit" value="Add bill" name="bill" class="btn">
    </form>

</section>

<section class="orders">

   
   <h1 class="title">Manage Bills</h1>
   <table>
      <tr>
         <th>Bill id</th>
         <th>Account number</th>
         <th>Date</th>
         <th>Used units</th>
         <th>Bill amount</th>
         <th>Payment status</th>
         
         <th>Update</th>
      </tr>
      <?php
      
      $select_bills= mysqli_query($conn, "SELECT * FROM `bills`") or die('query failed');

      // $select_orders = mysqli_query($conn, "SELECT * FROM `order_tbl` WHERE order_date LIKE '$cur_date%  ORDER BY order_taken") or die('query failed');
      if(mysqli_num_rows($select_bills) > 0){
         while($fetch_bills = mysqli_fetch_assoc($select_bills)){
      ?>
      <tr>
      <form action="" method="post">
        <td><input type="text" name="u_bill_id" class="box" value="<?php echo $fetch_bills['bill_id']; ?>" required></td>
        <td><input type="text" name="u_acc_num" class="box" value="<?php echo $fetch_bills['acc_num']; ?>" required></td>
        <td><input type="date" name="u_date" class="box" value="<?php echo $fetch_bills['date']; ?>" required></td>
        <td><input type="number" name="u_units" class="box" value="<?php echo $fetch_bills['units']; ?>" required></td>
        <td><input type="number" step='0.01' name="u_amount" class="box" value="<?php echo $fetch_bills['amount']; ?>" required></td>
        <td><input type="text" name="u_payment_status" class="box" value="<?php echo $fetch_bills['payment_status']; ?>" required></td>

        <td>
            <input type="submit" value="Update"  name="update_bill" class="option-btn">
            <a href="manage_users.php?delete=<?php echo $fetch_bills['bill_id']; ?>" onclick="return confirm('delete this bills?');" class="delete-btn">Delete</a>
        </form>
        </td>
    </tr>
      <?php
         }
      }else{
         echo '<p class="empty">no bills added yet!</p>';
      }
      ?>
   
   </table>
      
</section>





<!-- custom admin js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
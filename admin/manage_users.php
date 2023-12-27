<?php

include '../connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];


if(!isset($admin_id)){
   header('location:../login.php');
};


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

<style>
   
</style>

</head>
<body>
   
<?php include 'admin_header.php'; ?>



<h1 class="title">Powercut Schedule</h1>

<section class="add-schedule">


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
   <table class="cen">
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
        <td class="box2"><input type="text" name="u_bill_id" class="box" value="<?php echo $fetch_bills['bill_id']; ?>" required></td>
        <td class="box2"><input type="text" name="u_acc_num" class="box" value="<?php echo $fetch_bills['acc_num']; ?>" required></td>
        <td class="box2"><input type="date" name="u_date" class="box" value="<?php echo $fetch_bills['date']; ?>" required></td>
        <td class="box2"><input type="number" name="u_units" class="box" value="<?php echo $fetch_bills['units']; ?>" required></td>
        <td class="box2"><input type="number" step='0.01' name="u_amount" class="box" value="<?php echo $fetch_bills['amount']; ?>" required></td>
        <td class="box2"><input type="text" name="u_payment_status" class="box" value="<?php echo $fetch_bills['payment_status']; ?>" required></td>

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
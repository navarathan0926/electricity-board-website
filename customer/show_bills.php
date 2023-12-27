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
    <title>Bill Details</title>
    <style>
        body{
            background-color:#dfe6e9;
        }
    </style>
</head>
<body>
    

    <?php include 'header.php'; ?>

    <section class="imges-container " >
        <div class="label">
            <h2>Bill Details</h2>
        </div>
    </section>

    <section class="myorder">
        <div class="box-container">
            <?php
            $bill_query = mysqli_query($conn, "SELECT * FROM `bills` WHERE acc_num IN(SELECT acc_num FROM `users` WHERE user_id='$user_id')") or die('query failed');
            ?>
            <div class="myview">
                <table>
                    <tr>
                        <th>Bill id</th>
                        <th>Account number</th>
                        <th>Date</th>
                        <th>Used units</th>
                        <th>Amount</th>
                        <th>Payment status</th>
                    </tr>
                    <?php
                        if(mysqli_num_rows($bill_query) > 0){
                            while($fetch_bills = mysqli_fetch_assoc($bill_query)){
                                ?>
                                <tr>
                                    <td><span><?php echo $fetch_bills['bill_id']; ?></span></td>
                                    <td><span><?php echo $fetch_bills['acc_num']; ?></span></td>
                                    <td><span><?php echo $fetch_bills['date']; ?></span></td>
                                    <td><span><?php echo $fetch_bills['units']; ?></span></td>
                                    <td><span><?php echo $fetch_bills['amount']; ?></span></td>
                                    <td><span><?php echo $fetch_bills['payment_status']; ?></span></td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                </table>
            </div>

        </div>

    
    </section>

    <!-- <section class="imges-container " >
        <div class="imges">
            <img src="../images/works.jpg" width="100%" alt="">
        </div>
    </section> -->


    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>
</html>
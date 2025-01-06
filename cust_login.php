<?php include ('header.php'); ?>
<div class="" style="background:#00238b">
<div class="w3-col  w3-container" style="width:10%"></div>
<div class="w3-col w3-margin w3-row-padding" style="width: 500px;padding-top:100px">
        <img class="w3-col w3-row-padding" style="width: 300px" src='sources/logowhite.png'>
        <h3 class="w3-col" style="width:290px;text-align:center;color:white">1st Best Car Selling Platform in Malaysia</h3>
</div>
<div class="w3-container w3-col" style="margin:0 auto; width:50%">
   

        <br>

        <form action="" class="w3-container w3-round w3-margin w3-card-4 w3-light-grey" method='POST'><br>
       
        <h2 style="text-align:center">User Login</h2><br>
      
            <label>IC Numbers</label><input class="w3-input w3-border w3-round-large" type='text' name='customer_ID'><br>
            <label>Password</label><input class="w3-input w3-border w3-round-large" type='password' name='customerPass'><br><br>
            <input class="w3-button w3-round-large w3-border" style="background: #FFBF00" type='submit' value='Login'>
            <br><br>
        </form>
   
</div>

<br><br>

</div>



<?php
if (!empty($_POST)) {
     # Memanggil fail sambungan
     include('connection.php');


    $customer_ID = $_POST['customer_ID'];
    $customerPass = $_POST['customerPass'];

    if (!$condb) {
        die("<script>alert('Connection to Oracle failed. Please check your connection settings.');</script>");
    }

    $arahan_sql_cari = "
        SELECT CUSTOMERNAME, CUSTOMER_ID, CUSTOMERPASS, CUSTOMERTELNUM 
        FROM customer 
        WHERE CUSTOMER_ID = :CUSTOMER_ID AND CUSTOMERPASS = :CUSTOMERPASS AND ROWNUM = 1
    ";

    $laksana_arahan = oci_parse($condb, $arahan_sql_cari);
    oci_bind_by_name($laksana_arahan, ':CUSTOMER_ID', $customer_ID);
    oci_bind_by_name($laksana_arahan, ':CUSTOMERPASS', $customerPass);

    oci_execute($laksana_arahan);

    if ($rekod = oci_fetch_assoc($laksana_arahan)) {
        $_SESSION['customerName'] = $rekod['CUSTOMERNAME'];
        $_SESSION['customer_ID'] = $rekod['CUSTOMER_ID'];
        $_SESSION['customerPass'] = $rekod['CUSTOMERPASS'];
        $_SESSION['customerTelNum'] = $rekod['CUSTOMERTELNUM'];
        echo "<script>window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Your IC numbers or password may be incorrect! Try again :(');
        window.history.back();</script>";
    }

    oci_free_statement($laksana_arahan);
    oci_close($condb);
}
?>



<?PHP include ('footer.php'); ?>
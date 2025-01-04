<!--Memanggil fail header-->


<?PHP include('header.php'); ?>
<!--Menyediakan form bagi daftar pengguna baru-->
<div class="" style="background:#00238b">
<div class="w3-col  w3-container" style="width:10%"></div>
  <div class="w3-col w3-margin w3-row-padding" style="width: 500px;padding-top:150px; background:#00238b">
        <img class="w3-col w3-row-padding" style="width: 300px" src='sources/logowhite.png'>
        <h3 class="w3-col" style="width:290px;text-align:center;color:white">1st Best Car Selling Platform in Malaysia</h3>
  </div>

  <div class="w3-container w3-col" style="margin:0 auto; width:50%">


    <br>
    <!-- Add an ID to the form element so that it can be easily accessed with JavaScript -->
    <form action="" class="w3-container w3-round w3-margin w3-card-4 w3-light-grey" method='POST' id='registrationForm'><br>
    <p><h2 style="text-align:center">User Registration</h2></p><br>
      Full Name <input class="w3-input w3-border w3-round-large" type='text' name='customerName' required autofocus><br>
      <!-- Remove the pattern, oninvalid, and oninput attributes from the Identity Number input field -->
      Identity Card Number <input class="w3-input w3-border w3-round-large" type='number' name='customer_ID' placeholder='example: 123456789012' required><br>
      Phone Number <input class="w3-input w3-border w3-round-large" type='text' name='customerTelNum'><br>
      Password <input class="w3-input w3-border w3-round-large" type='password' name='customerPass'><br><br>
      <input class="w3-button w3-round-large w3-border" style="background: #FFBF00" type='submit' value='Register'>
      <a href="cust_regis.php" class="w3-button w3-border w3-round-large">Reset</a><br><br>
    </form> 


    <br>
    

  </div>



<br>

<script>
  // Get a reference to the form element
  var form = document.getElementById('registrationForm');

  // Add an event listener to the form's submit event
  form.addEventListener('submit', function(event) {
    // Get a reference to the Identity Number input field
    var identityNumberInput = form.elements['customer_ID'];

    // Check if the input value is exactly 12 digits long
    if (identityNumberInput.value.length !== 12) {
      // If it's not, display an error message and prevent the form from being submitted
      alert('Please enter 12 digits Identity Card Numbers only');
      event.preventDefault();
    }
  });
</script>

<?php
# Menyemak kewujudan data POST
if (!empty($_POST)) {
    # Memanggil fail sambungan
    include('connection.php');

    # Mengambil data POST
    $customerName = $_POST['customerName'];
    $customerTelNum = $_POST['customerTelNum'];
    $customer_ID = $_POST['customer_ID'];
    $customerPass = $_POST['customerPass'];

    # -- Validasi Data --
    if (empty($customerName) || empty($customerTelNum) || empty($customer_ID) || empty($customerPass)) {
        die("<script>alert('Please complete the required information!');
        window.history.back();</script>");
    }

    # -- Validasi Customer ID --
    if (strlen($customer_ID) != 12 || !is_numeric($customer_ID)) {
        die("<script>alert('Error with the Customer IC Numbers!');
        window.history.back();</script>");
    }

    # Arahan SQL untuk menyimpan data
    $arahan_sql_simpan = "
        INSERT INTO CUSTOMER (CUSTOMER_ID, CUSTOMERNAME, CUSTOMERTELNUM, CUSTOMERPASS)
        VALUES (:CUSTOMER_ID, :CUSTOMERNAME, :CUSTOMERTELNUM, :CUSTOMERPASS)
    ";

    # Melaksanakan proses menyimpan
    $laksana_arahan = oci_parse($condb, $arahan_sql_simpan);

    # Bind parameter untuk mengelakkan SQL Injection
    oci_bind_by_name($laksana_arahan, ':CUSTOMER_ID', $customer_ID);
    oci_bind_by_name($laksana_arahan, ':CUSTOMERNAME', $customerName);
    oci_bind_by_name($laksana_arahan, ':CUSTOMERTELNUM', $customerTelNum);
    oci_bind_by_name($laksana_arahan, ':CUSTOMERPASS', $customerPass);

    # Laksana arahan SQL dalam syarat IF
    if (oci_execute($laksana_arahan, OCI_COMMIT_ON_SUCCESS)) {
        # Jika proses menyimpan berjaya, papar info dan buka laman login
        oci_free_statement($laksana_arahan);
        oci_close($condb);
        echo "<script>alert('Registration Successful');
        window.location.href='cust_login.php';</script>";
    } else {
        # Jika proses menyimpan gagal, kembali ke laman sebelumnya
        $error = oci_error($laksana_arahan);
        echo "<script>alert('Registration Failed: " . $error['message'] . "');
        window.history.back();</script>";
    }
}
?>

?>

<?PHP include ('footer.php'); ?>


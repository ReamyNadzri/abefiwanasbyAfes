<?php include('header.php'); ?>

<?PHP 
# memulakan fungsi session_start()
session_start();
# menyemak kewujudan data GET dan data POST
if (!empty($_GET) and !empty($_POST)) {
    # memanggil fail connection
    include('connection.php');

    # data validation
    if (!is_numeric($_POST['deposit']) or empty($_POST['deposit'])) {
        die("<script>alert('Error in the deposit value entered');
        window.history.back();</script>");
    }
    # data validation - had bawah
    if ($_POST['deposit'] < 1499) {
        die("<script>alert('Deposit does not reach the minimum limit of RM 1500');
        window.history.back();</script>");
    }
    # data validation - had atas
    if ($_POST['deposit'] > $_GET['initialPrice']) {
        die("<script>alert('Deposit more than the price of the car');
        window.history.back();</script>");   
    }

    # Mengira baki bayaran
    $baki_bayaran = $_GET['initialPrice'] - $_POST['deposit'];
    # mengambil tarikh dari server
    $tarikh_pembelian = date("Y-m-d");

    # mengambil data GET dan mengumpulkan kepada tatasusunan
    $data_get = array(
'numPlate' => $_GET['numPlate'],
        'carName' => $_GET['carName'],
        'carType' => $_GET['carType'],
        'color' => $_GET['color'],
        'yearManufac' => $_GET['yearManufac'],
        'initialPrice' => $_GET['initialPrice'],
        'desccar' => $_GET['desccar'],
        'transmission' => $_GET['transmission'],
        'variant' => $_GET['odometer'],
        'fuelType' => $_GET['fuelType'],
        'seat' => $_GET['seat'],
        'cc' => $_GET['cc'],
        'modelName' => $_GET['modelName'],
        'deposit' => $_POST['deposit'],
        'balancePayment' => $baki_bayaran,
        'purchaseDate' => $tarikh_pembelian
    );

    # arahan SQL untuk menyimpan data pembelian
    $arahan_sql_simpan = "INSERT INTO purchase
        (customer_ID, numPlate, purchaseDate, deposit, balancePayment)
        VALUES
        (:customer_ID, :numPlate, TO_DATE(:purchaseDate, 'YYYY-MM-DD'), :deposit, :balancePayment)";

    # Prepare the Oracle SQL query
    $stid = oci_parse($condb, $arahan_sql_simpan);

    # Bind parameters to prevent SQL injection
    oci_bind_by_name($stid, ':customer_ID', $_SESSION['customer_ID']);
    oci_bind_by_name($stid, ':numPlate', $data_get['numPlate']);
    oci_bind_by_name($stid, ':purchaseDate', $data_get['purchaseDate']);
    oci_bind_by_name($stid, ':deposit', $data_get['deposit']);
    oci_bind_by_name($stid, ':balancePayment', $data_get['balancePayment']);

    # Execute the query
    if (oci_execute($stid)) {
        # jika proses menyimpan berjaya, buka laman pembeli_resit
        echo "<script>alert('Your Purchase was Successful');
        window.location.href='purchase_invoice.php?".http_build_query($data_get)."';</script>";
    } else {
        # jika proses menyimpan gagal, kembali ke laman sebelumnya
        $e = oci_error($stid);
        echo "<script>alert('Purchase Failed: " . htmlentities($e['message']) . "');
        window.history.back();</script>";
    }

    # Free the statement and close the connection
    oci_free_statement($stid);
    oci_close($condb);
} else {
    header("location:index.php");
}
?>

<?PHP include('footer.php'); ?>

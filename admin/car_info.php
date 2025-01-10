<?PHP
# Memanggil fail header_admin.php
include('header_admin.php');
# Memanggil fail connection dari folder luaran
include('../connection.php');

#----------- Bahagian 2 : Proses penyimpan data-------
# Menyemak kewujudan data POST
if (!empty($_POST)) {
    # mengambil data POST
    $numPlate = $_POST['numPlate'];
    $carName = $_POST['carName'];
    $carType = $_POST['carType'];
    $color = $_POST['color'];
    $yearManufac = $_POST['yearManufac'];
    $initialPrice = $_POST['initialPrice'];
    $desccar = $_POST['desccar'];
    $transmission = $_POST['transmission'];
    $odometer = $_POST['odometer'];
    $variant = $_POST['variant'];
    $fuelType = $_POST['fuelType'];
    $seat = $_POST['seat'];
    $cc = $_POST['cc'];
    $model_ID = $_POST['model_ID'];
    $idimg = $_POST['idimg'];

    // Arahan untuk menyimpan data ke dalam jadual kereta
    $arahan_sql_simpan = "
    INSERT INTO car (
        NUMPLATE, CARNAME, CARTYPE, COLOR, YEARMANUFAC, INITIALPRICE, DESCCAR, 
        TRANSMISSION, ODOMETER, VARIANT, FUELTYPE, SEAT, CC, MODEL_ID, IDIMG
    ) 
    VALUES (
        :numPlate, :carName, :carType, :color, :yearManufac, :initialPrice, :desccar, 
        :transmission, :odometer, :variant, :fuelType, :seat, :cc, :model_ID, :idimg
    )
    ";

    // Melaksanakan proses menyimpan
    $laksana_arahan = oci_parse($condb, $arahan_sql_simpan);

    // Bind parameter untuk mengelakkan SQL Injection
    oci_bind_by_name($laksana_arahan, ':numPlate', $numPlate);
    oci_bind_by_name($laksana_arahan, ':carName', $carName);
    oci_bind_by_name($laksana_arahan, ':carType', $carType);
    oci_bind_by_name($laksana_arahan, ':color', $color);
    oci_bind_by_name($laksana_arahan, ':yearManufac', $yearManufac);
    oci_bind_by_name($laksana_arahan, ':initialPrice', $initialPrice);
    oci_bind_by_name($laksana_arahan, ':desccar', $desccar);
    oci_bind_by_name($laksana_arahan, ':transmission', $transmission);
    oci_bind_by_name($laksana_arahan, ':odometer', $odometer);
    oci_bind_by_name($laksana_arahan, ':variant', $variant);
    oci_bind_by_name($laksana_arahan, ':fuelType', $fuelType);
    oci_bind_by_name($laksana_arahan, ':seat', $seat);
    oci_bind_by_name($laksana_arahan, ':cc', $cc);
    oci_bind_by_name($laksana_arahan, ':model_ID', $model_ID);
    oci_bind_by_name($laksana_arahan, ':idimg', $idimg);

    // Laksana arahan SQL dalam syarat IF
    if (oci_execute($laksana_arahan, OCI_COMMIT_ON_SUCCESS)) {
        // Jika proses menyimpan berjaya, papar info dan buka laman utama
        oci_free_statement($laksana_arahan);
        oci_close($condb);
        echo "<script>alert('Car details saved successfully');
    window.location.href='some_page.php';</script>";
    } else {
        # proses menyimpan data gagal. papar mesej
        echo "<script>alert('Registration Failure');
        window.history.back();</script>";
    }
}




// Assuming $condb is your valid Oracle connection resource
// and has been included from connection.php

// ----------- bahagian 1 : memaparkan data dalam bentuk jadual

// arahan SQL mencari kereta yang masih belum dijual
$arahan_sql_cari = "
    SELECT *
    FROM car c
    INNER JOIN model m ON c.model_ID = m.model_ID
    WHERE c.numPlate NOT IN (SELECT numPlate FROM purchase)
    ORDER BY c.idimg DESC
";

// melaksanakan arahan sql cari tersebut
$laksana_sql_cari = oci_parse($condb, $arahan_sql_cari);

$execute_sql_cari = oci_execute($laksana_sql_cari);

// Note:  The results can be fetched now
// in a loop using oci_fetch_assoc()

// Example usage (fetching results in a loop):
/*
 while ($row = oci_fetch_assoc($laksana_sql_cari)) {
     // Access data using keys (e.g., $row['NUMPLATE'], $row['CARNAME'])
     // For example:
    echo $row['NUMPLATE'] . " - " . $row['CARNAME'] . "<br/>";
 }

 oci_free_statement($laksana_sql_cari);
 */
?>

<style>
    .adjust {
        width: 1000px
    }
</style>



<!-- menyediakan header bagi jadual -->
<!-- selepas header akan diselitkan dengan borang untuk mendaftar kereta baru -->

<div class="w3-container">
    <div class="w3-row">
        <div class="w3-col m6">
            <h4>LIST OF AVAILABLE CAR</h4>
        </div>
        <div class="w3-col m6">
            <a href="car_form.php" class="w3-button w3-blue w3-round-large w3-right">
                <i class="fas fa-plus"></i> Add New Car
            </a>
        </div>
    </div>
    <div class="w3-responsive">
        <table class="w3-table-all" id='saiz'>
            <thead>
                <tr class="w3-light-blue">
                    <th class="w3-center">Bil</th>
                    <th>Plate No</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Model</th>
                    <th>Color</th>
                    <th>Year</th>
                    <th>Price</th>
                    <th class="w3-hide-small">Description</th>
                    <th>Trans</th>
                    <th>ODO</th>
                    <th>Variant</th>
                    <th class="w3-hide-small">Fuel</th>
                    <th class="w3-hide-small">Seat</th>
                    <th class="w3-hide-small">CC</th>
                    <th class="w3-center">Details</th>
                    <th class="w3-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?PHP
                $bil = 0;
                while ($rekod = oci_fetch_assoc($laksana_sql_cari)) {
                    echo "<tr>
                        <td class='w3-center'>" . ++$bil . "</td>
                        <td>" . $rekod['NUMPLATE'] . "</td>
                        <td>" . $rekod['CARNAME'] . "</td>
                        <td>" . $rekod['CARTYPE'] . "</td>
                        <td>" . $rekod['MODELNAME'] . "</td>
                        <td>" . $rekod['COLOR'] . "</td>
                        <td>" . $rekod['YEARMANUFAC'] . "</td>
                        <td>" . $rekod['INITIALPRICE'] . "</td>
                        <td class='w3-hide-small'>" . $rekod['DESCCAR'] . "</td>
                        <td>" . $rekod['TRANSMISSION'] . "</td>
                        <td>" . $rekod['ODOMETER'] . "</td>
                        <td>" . $rekod['VARIANT'] . "</td>
                        <td class='w3-hide-small'>" . $rekod['FUELTYPE'] . "</td>
                        <td class='w3-hide-small'>" . $rekod['SEAT'] . "</td>
                        <td class='w3-hide-small'>" . $rekod['CC'] . "</td>
                        <td class='w3-center'>
                            <a href='car_edit_form.php?numPlate=" . $rekod['NUMPLATE'] . "' class='w3-button w3-small w3-round w3-amber'>View</a>
                        </td>
                        <td>
                            <a href='hapus.php?jadual=CAR&medan_kp=NUMPLATE&kp=" . $rekod['NUMPLATE'] . "' onClick=\"return confirm('Confirm to delete data?')\" 
                                class='w3-button w3-small w3-round w3-red'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<br>
<br>
<br>
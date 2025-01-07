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

<h4>LIST OF AVAILABLE CAR</h4>
<table class="w3-table-all" id='saiz' border='1'>
    <tr class="w3-light-blue">
        <td>Bil</td>
        <td id="adjust">Plate Number</td>

        <td>Car Name</td>
        <td>Car Type</td>
        <td>Model</td>
        <td>Car Colour</td>
        <td>Year of Manufacture</td>
        <td>Initial Price</td>
        <td>Description</td>
        <td>Transmission</td>
        <td>Odometer</td>
        <td>Variant</td>
        <td>Seat</td>
        <td>Description</td>
        

        <td><a class='w3-button w3-round-xlarge' href='images_view.php' style='width:100%;background: #FFBF00'>Select Images</a></td>
        <td></td>
    </tr>
    <tr>
        <!-- menyediakan borang untuk mendaftar kereta baru -->
        <form action='' method='POST'>
            <td>#</td>
            <td><input type='text' name='numPlate' style="width: 100px;"></td>
            <td><input type='text' name='carName'></td>
            <td><input type='text' name='carType'></td>
            <td>
                <!-- menghasilkan drop down yg dinamik (mengambil data dari jadual) -->
                <select name='model_ID' required>
                    <option disabled selected value>Category</option>
                    <?PHP

                            // arahan mencari data dari jadual model
                            $arahan_sql_carimodel = "SELECT model_ID, modelName FROM model";  // Select only needed columns

                            // melaksanakan arahan mencari tersebut
                            $laksana_sql_carimodel = oci_parse($condb, $arahan_sql_carimodel);

                            oci_execute($laksana_sql_carimodel);

                            // pembolehubah $rekod_model mengambil data baris demi baris
                            while ($rekod_model = oci_fetch_assoc($laksana_sql_carimodel)) {
                                // memaparkan nilai pemboleh ubah $rekod_model['modelName'] dalam bentuk dropdown list
                                echo "<option value='" . $rekod_model['MODEL_ID'] . "'>" . $rekod_model['MODELNAME'] . "</option>";
                            }

                            // Free the resources
                            oci_free_statement($laksana_sql_carimodel);
                    
                    ?>
                </select>
            </td>
            <td><input type='text' name='color'></td>
            <td><input type='text' name='yearManufac'></td>
            <td><input type='text' name='initialPrice'></td>
            <td><input type='text' name='desccar' style="width: 200px;height:100px"></td>
            <td><input type='text' name='transmission'></td>
            <td><input type='text' name='odometer'></td>
            <td><input type='text' name='variant'></td>
            <td><input type='text' name='fuelType'></td>
            <td><input type='text' name='seat'></td>
            <td><input type='text' name='cc'></td>
            <td>
                <!----------------------------------------------------------------------------------------------------------------------------------------------->

                <?PHP
                if (empty($_GET['idimg'])) {
                    $idimg = "Not Selected";
                } else {
                    $idimg = $_GET['idimg'];
                    $rekod['idimg'] = $idimg;
                }
                ?>
                <input text='text' name='idimg' size="3" value='<?php echo "$idimg"; ?>'>
            </td>

            <!----------------------------------------------------------------------------------------------------------------------------------------------->
            <td><input type='submit' value='Save'></td>
        </form>
    </tr>
    <?PHP

            $bil = 0;

            // pemboleh ubah $rekod mengambail semua data yang ditemui oleh $laksana_sql_cari
            while ($rekod = oci_fetch_assoc($laksana_sql_cari)) {
                //Check if fetching failed
                if (!$rekod) {
                    $e = oci_error($laksana_sql_cari);
                    if ($e) {
                        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                    }
                    break;  // break the loop if fetch fails
                }
                
                // sistem akan memaparkan data $rekod baris demi baris sehingga habis
                echo "
                <tr>
                    <td>" . ++$bil . "</td>
                    <td>" . $rekod['NUMPLATE'] . "</td>
                    <td>" . $rekod['CARNAME'] . "</td>
                    <td>" . $rekod['CARTYPE'] . "</td>
                    <td>" . $rekod['MODELNAME'] . "</td>
                    <td>" . $rekod['COLOR'] . "</td>
                    <td>" . $rekod['YEARMANUFAC'] . "</td>
                    <td>" . $rekod['INITIALPRICE'] . "</td>
                    <td>" . $rekod['DESCCAR'] . "</td>
                     <td>" . $rekod['TRANSMISSION'] . "</td>
                     <td>" . $rekod['ODOMETER'] . "</td>
                     <td>" . $rekod['VARIANT'] . "</td>
                     <td>" . $rekod['FUELTYPE'] . "</td>
                     <td>" . $rekod['SEAT'] . "</td>
                     <td>" . $rekod['CC'] . "</td>
                    <td>" . $rekod['IDIMG'] . "</td>

                    <td><a href='hapus.php?jadual=car&medan_kp=numPlate&kp=" . $rekod['NUMPLATE'] . "' onClick=\"return confirm('Confirm to delete data?')\" >Delete</a></td>
                </tr>";
            }
    ?>
</table>
<br>
<br>
<br>
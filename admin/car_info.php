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
        numPlate, carName, carType, color, yearManufac, initialPrice, desccar, 
        transmission, odometer, variant, fuelType, seat, cc, model_ID, idimg
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



# ----------- bahagian 1 : memaparkan data dalam bentuk jadual

# arahan SQL mencari kereta yang masih belum dijual
$arahan_sql_cari = "select* from car,model where car.numPlate not in (select numPlate from purchase) and car.model_ID=model.model_ID order by idimg desc";
# melaksanakan arahan sql cari tersebut
$laksana_sql_cari = mysqli_query($condb, $arahan_sql_cari);
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

                    # arahan mencari data dari jadual model 
                    $arahan_sql_carimodel = "SELECT* from model";
                    # melaksanakan arahan mencari tersebut
                    $laksana_sql_carimodel = mysqli_query($condb, $arahan_sql_carimodel);
                    # pembolehubah $rekod_model mengambil data baris demi baris 
                    while ($rekod_model = mysqli_fetch_array($laksana_sql_carimodel)) {
                        # memaparkan nilai pemboleh ubah $rekod_model['modelName'] dalam bentuk dropdown list
                        echo "<option value='" . $rekod_model['model_ID'] . "'>
                    " . $rekod_model['modelName'] . "</option>";
                    }
                    ?>
                </select>
            </td>
            <td><input type='text' name='color'></td>
            <td><input type='text' name='yearManufac' style="width:100px;"></td>
            <td><input type='text' name='initialPrice' style="width: 150px;"></td>
            <td><input type='text' name='desccar' style="width: 200px;height:100px"></td>
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
    # pemboleh ubah $rekod mengambail semua data yang ditemui oleh $laksana_sql_cari
    while ($rekod = mysqli_fetch_array($laksana_sql_cari)) {
        # sistem akan memaparkan data $rekod baris demi baris sehingga habis
        echo "
        <tr>
            <td>" . ++$bil . "</td>
            <td>" . $rekod['numPlate'] . "</td>
            <td>" . $rekod['carName'] . "</td>
            <td>" . $rekod['carType'] . "</td>
            <td>" . $rekod['modelName'] . "</td>
            <td>" . $rekod['color'] . "</td>
            <td>" . $rekod['yearManufac'] . "</td>
            <td>" . $rekod['initialPrice'] . "</td>
            <td>" . $rekod['desccar'] . "</td>
            <td>" . $_POST['transmission'] . "</td>
            <td>" . $_POST['odometer'] . "<td>
            <td>" . $_POST['variant'] . "</td>
            <td>" . $_POST['fuelType'] . "</td>
            <td>" . $_POST['seat'] . "</td>
            <td>" . $_POST['cc'] . "</td>
            <td>" . $rekod['idimg'] . "</td>

            <td><a href='hapus.php?jadual=car&medan_kp=numPlate&kp=" . $rekod['numPlate'] . "' onClick=\"return confirm('Confirm to delete data?')\" >Delete</a></td>
        </tr>";
    }
    ?>
</table>
<br>
<br>
<br>
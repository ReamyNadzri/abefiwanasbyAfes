<?php
    include("header.php");
?>
<div style="background:#00238b">
<br>

<style>
    .text{
        padding-left:20px;

    }
    .profile{
        height:600px
    }


    </style>

    <div class="w3-container w3-white w3-border w3-round-large" style="margin:0 auto; width:60%;height:650px; background-color: fff8e8;">
        <br><h2 class="text">Welcome, <?php echo $_SESSION['customerName'];?></h2>

        <div class="w3-quarter profile"><br>
            <a href='myaccount.php' class="w3-bar-item w3-button" style="width:180px; text-align:left">
                <img class="w3-circle" src="admin/sources/admin.jpg" style="height:40px;width:auto">
                
                <?php
                
                    echo "".$_SESSION['customerName']."";
                ?>
            </a>

            <br><br>
            <a href='purchase.php' class="w3-bar-item w3-button" style="width:180px; text-align:left">
                <img class="w3-circle" src="admin/sources/cart.jpg" style="height:40px;width:40px">
                My Purchases
            </a>      
        </div>

        <div class="w3-threequarter w3-border w3-white">
            
            <h4 class="text">My Purchases</h4>
            <p style="position:relative;right:-20px;top:-20px; color:grey">View your invoice here.</p>

            <?php

                include('connection.php');

                # Arahan SQL untuk mendapatkan data
                $arahan_sql_purchase = "
                    SELECT 
                        purchase.purchase_ID, purchase.customer_ID, purchase.numPlate, purchase.purchaseDate, 
                        purchase.deposit, purchase.balancePayment, customer.customerName, customer.customerTelNum, 
                        customer.customerPass, car.carName, car.carType, model.modelName, car.color, 
                        car.yearManufac, car.initialPrice, car.desccar
                    FROM 
                        purchase, customer, car, model 
                    WHERE 
                        purchase.customer_ID = :CUSTOMER_ID
                        AND purchase.customer_ID = customer.customer_ID
                        AND purchase.numPlate = car.numPlate
                        AND car.model_ID = model.model_ID
                ";

                # Menyediakan arahan SQL
                $laksana_arahan = oci_parse($condb, $arahan_sql_purchase);

                # Bind parameter untuk mengelakkan SQL Injection
    
                oci_bind_by_name($laksana_arahan, ':CUSTOMER_ID', $_SESSION['customer_ID']);

                # Melaksanakan arahan SQL
                oci_execute($laksana_arahan);

                # Semak jika terdapat baris yang dijumpai
                if (oci_fetch_all($laksana_arahan, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW) > 0) {
                    # Papar header kepada jadual
                    echo "";

                    foreach ($results as $rekod) {
                        # Mengumpukan nilai tatasusunan untuk data GET
                        $data_get = array(
                            'purchase_ID' => $rekod['PURCHASE_ID'],
                            'customer_ID' => $rekod['CUSTOMER_ID'],
                            'numPlate' => $rekod['NUMPLATE'],
                            'purchaseDate' => $rekod['PURCHASEDATE'],
                            'deposit' => $rekod['DEPOSIT'],
                            'balancePayment' => $rekod['BALANCEPAYMENT'],
                            'customerName' => $rekod['CUSTOMERNAME'],
                            'customerTelNum' => $rekod['CUSTOMERTELNUM'],
                            'customerPass' => $rekod['CUSTOMERPASS'],
                            'carName' => $rekod['CARNAME'],
                            'carType' => $rekod['CARTYPE'],
                            'modelName' => $rekod['MODELNAME'],
                            'color' => $rekod['COLOR'],
                            'yearManufac' => $rekod['YEARMANUFAC'],
                            'initialPrice' => $rekod['INITIALPRICE'],
                            'desccar' => $rekod['DESCCAR'],
                        );

                        # Memaparkan data yang ditemui semasa proses carian baris demi baris
                        echo "
                        <div class='w3-border w3-round-large text w3-margin' style='width:95%; padding-top:10px;padding-bottom:10px;'>
                        Number Plate : " . htmlspecialchars($rekod['NUMPLATE']) . "             <br>
                        Purchase Date : " . htmlspecialchars($rekod['PURCHASEDATE']) . "        <br>
                        Deposit (RM) : " . htmlspecialchars($rekod['DEPOSIT']) . "              <br>
                        Bal. Payment (RM) : " . htmlspecialchars($rekod['BALANCEPAYMENT']) . "  <br>
                        <br>
                        <a class='w3-button w3-round-large' style='background: #FFBF00' href=purchase_invoice.php?" . http_build_query($data_get) . ">Invoice<br></a>
                        <br></div> 
                    ";
                    }
                    echo "";
                } else {
                    # Jika tiada pembelian yang wujud
                    echo "<i class='text' >You did not purchase any car here.</i><br><br>";
                }

                # Tutup sumber
                oci_free_statement($laksana_arahan);
                oci_close($condb);
?>
        </div>
    </div>

    <?php
    include("footer.php");
?>
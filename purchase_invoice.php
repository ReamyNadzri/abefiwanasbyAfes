

<!-- memanggil fail header -->
 <head>

 <style>
      
 </style>
 </head>


<?PHP include('header.php'); ?>


<div class="w3-container w3-center w3-white">
    <br>
    <img  src="sources/logo.png" style="width:200px">
    <h2><b>CAR BOOKING INVOICE</b></h2>
    <hr>
    <h3>Customer Information</h3>
    <div class=" w3-col" style="width:50%;text-align:right;">
        
                <!-- Memaparkan maklumat pembeli -->
        
        <b>Customer Name : </b><br>
        <b>Customer IC Num. : </b><br>
        <b>Customer Contact : </b><br>
        <hr>
    </div>
    <div class=" w3-col" style="width:50%;text-align:left;">
    
        &ensp;<?PHP echo $_SESSION['customerName'];?><br>
        &ensp;<?PHP echo $_SESSION['customer_ID'];?><br>
        &ensp;<?PHP echo $_SESSION['customerTelNum'];?><br>
        <hr>
    </div>
</div>

<div class="w3-container w3-center w3-white">
    <h3>Car Information</h3>
    <div class=" w3-col" style="width:50%;text-align:right;">
                <!-- Memaparkan maklumat kereta yang dibeli -->
        
        <b>Num Plat Regist. : </b><br>
        <b>Car Name : </b><br>
        <b>Car Model : </b><br>
        <b>Car Color : </b><br>
        <b>Year Manufacture : </b><br>
        <b>Initial Price : </b><br>
        <b>Transmission : </b><br>
        <b>Odometer : </b><br>
        <b>Variant : </b><br>
        <b>Fuel Type : </b><br>
        <b>Seat : </b><br>
        <b>Engine CC : </b><br>
        <hr>
    
        
    </div>
    <div class=" w3-col" style="width:50%;text-align:left;">
        &ensp;<?PHP echo $_GET['numPlate'];?><br>
        &ensp;<?PHP echo $_GET['carName'];?><br>
        &ensp;<?PHP echo $_GET['carType'];?><br>
        &ensp;<?PHP echo $_GET['color'];?><br>
        &ensp;<?PHP echo $_GET['yearManufac'];?><br>
        &ensp;RM <?PHP echo $_GET['initialPrice'];?><br>
        &ensp;<?PHP echo $_GET['transmission'];?><br>
        &ensp;<?PHP echo $_GET['odometer'];?> km<br>
        &ensp;<?PHP echo $_GET['variant'];?><br>
        &ensp;<?PHP echo $_GET['fuelType'];?><br>
        &ensp;<?PHP echo $_GET['seat'];?><br>
        &ensp;<?PHP echo $_GET['cc'];?> CC<br>
        <hr>
    </div>

    <div class="w3-container w3-center w3-white">
        <h3>Purchase Information</h3>
        <div class=" w3-col" style="width:50%;text-align:right;">
                <!-- Memaparkan maklumat Pembelian -->
                
            <b>Purchase Date : </b><br>
            <b>Deposit : </b><br>
            <b>Balance of payment : </b><br>
            <hr>
        </div>
        <div class=" w3-col" style="width:50%;text-align:left;">
        &ensp;<?PHP echo $_GET['purchaseDate'];?><br>
        &ensp;RM <?PHP echo $_GET['deposit'];?><br>
        &ensp;RM <?PHP echo $_GET['balancePayment'];?><br>
        <hr>
        </div>
        "Please note that our Sales Advisor will contact you within 2 to 3 business days.<br>Make sure to check your email regularly to stay updated."
        <br><br>

        <button class='w3-btn w3-ios-grey w3-round-xlarge' id="printButton" onclick="window.print()" name='print' type='button' value='Print'>Print </button>
        <a class='w3-btn w3-ios-grey w3-round-xlarge' id="homeButton" href='index.php' style="margin-left:10px">Home </a>
    
   
</div><br><br><br>



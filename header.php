<?PHP
session_start();
date_default_timezone_set("Asia/Kuala_Lumpur");
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<link rel="stylesheet" href="style.css">
<title>Abe Fiwan Auto Sales</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!----------------------------------------------------------------------------------->
<link href="https://www-assets.carwow.co.uk/assets/favicon-32x32-b7f2b5807fce80b6dfecd4ef3bde87370863be35.png" rel="icon" sizes="16x16 32x32 48x48" type="image/png">
<link href="https://www-assets.carwow.co.uk/assets/touch-icon-ipad-retina-6b50b6b17760694522c9895a9a120383e2938b6a.png" rel="apple-touch-icon">
<link rel="stylesheet" href="https://www-assets.carwow.co.uk/assets/src/stylesheets/common-a24063fad8bc9d805fddbdd5dfd8bb554e90f6f9.css" media="all">
<link rel="stylesheet" href="https://www-assets.carwow.co.uk/assets/pages/home/index/index-ade9c3802eb18ef9e07dbabb24d276d67628fa8b.css" media="all">
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Play&display=swap" rel="stylesheet"> 



<!----------------------------------------------------------------------------------->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-ios.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link href="https://fonts.cdnfonts.com/css/product-sans" rel="stylesheet">
                


<head>
    <meta charset="utf-8">
        <title></title>
    
</head>

<style>

body {
    font-family: 'Product Sans', sans-serif;
    z-index: 9999;                             
  margin: 0;
}
h1{
    font-family: 'Product Sans', sans-serif; 
}
h2, h3, h4{
    font-family: 'Product Sans', sans-serif; 
}
p{
    font-family: 'Product Sans', sans-serif; 
}
a{
    font-family: 'Product Sans', sans-serif; 
}
.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}
.w3-tangerine {
    font-family: 'Product Sans', sans-serif;
}
w3-saya {
    font-family: 'Product Sans', sans-serif;
}
.material-icons {vertical-align:-14%}

@media print {
        #header {
            display: none; /* Hides the header when printing */
        }

        #printButton {
            display: none;
        }

        #homeButton {
            display: none;
        }
    }

</style>


<!--------Title -->
<body>

<!--------Menu -->

<div class="w3-bar w3-border w3-card-4" id="header">

    <a href="index.php" style="height:auto;width:60%;">
    <div class="w3-col w3-container" style="width:10%"></div>
        <img class="w3-col w3-margin w3-row-padding" style="height:60px; width: 155px;" src='sources/logo.png'>
    </a>
    
    <div class="w3-col" style="width:65%">
        <div style="height:25px;">
         

        </div>
       
        <a href="helppage.php" class="w3-bar-ite w3-button w3-right" ><img src='sources/new/help-web-button.png' style="padding-bottom:3px; text-align:center; width:15px"> Help</a>

        <a href="about.php" class="w3-bar-item w3-button w3-right" ><img src='sources/new/information-button.png' style="padding-bottom:3px;text-align:center; width:15px"> About</a>
        <a href="testconnection.php" class="w3-bar-item w3-button w3-right" ><img src='sources/new/information-button.png' style="padding-bottom:3px;text-align:center; width:15px"> TESTDB</a>
    
<?PHP 
if(empty($_SESSION['customerName']))  //database
{
?>

    <div class="w3-dropdown-hover w3-right">
        <button class="w3-button" ><img src='sources/new/user-shape.png' style="padding-bottom:3px;text-align:center; width:15px"> Login/Register</button>
            <div class="w3-dropdown-content w3-bar-block w3-card-4">
                <a href="cust_regis.php" class="w3-bar-item w3-button">Sign up</a>
                <a href="cust_login.php" class="w3-bar-item w3-button">Login</a>
            </div>
    </div>
<?PHP
    }
    else
    {   
?>
    <a href="logout.php" class="w3-bar-item w3-button w3-right" ><img src='sources/new/logout.png' style="padding-bottom:3px;text-align:center; width:15px"> Log Out</a>
       
    <a href='myaccount.php' class="w3-bar-item w3-right w3-button"><img src='sources/new/user-shape.png' style="padding-bottom:3px;text-align:center; width:15px"> 
       
        <?php
        echo "Hi, ".$_SESSION['customerName'];
        ?>
    </a>

<?PHP
}
?>
    <a href="index.php" class="w3-bar-item w3-button w3-right" ><img src='sources/new/home.png' style="padding-bottom:3px;text-align:center; width:18px"> Home</a>
    </div>
</div>

<!-- Memanggil fail header_admin.php -->
<?PHP include ('header_admin.php'); ?>
<!-- menyediakan borang untuk mengemaskini data admin-->
<form action='' method='POST'>
New Admin Name : <input type='text' name='nama_baru' value='<?php echo $_GET['adminName'];?>'><br><br>
New Admin ID : <input type='text' name='nokp_baru' value='<?php echo $_GET['admin_ID'];?>'><br><br>
New Phone Number : <input type='text' name='notel_baru' value='<?php echo $_GET['adminPhone'];?>'><br><br>
New Password : <input type='password' name='katalaluan_baru' value='<?php echo $_GET['adminPass'];?>'><br><br>
<input class="w3-button w3-light-blue" type='submit' value='Update'>
</form>

<?PHP 
# menyemak kewujudan data POST
if(!empty($_POST))
{
    # Memanggil fail connection dari folder luaran
    include ('../connection.php');

    # mengambil data POST
    $nama_baru=$_POST['nama_baru'];
    $nokp_baru=$_POST['nokp_baru'];
    $notel_baru=$_POST['notel_baru'];
    $katalaluan_baru=$_POST['katalaluan_baru'];
    $nokp_lama=$_GET['admin_ID'];

    # Arahan untuk mengemaskini data ke dalam jadual admin
    $arahan_sql_update="UPDATE admin SET admin_ID=:nokp_baru, adminName=:nama_baru, adminPass=:katalaluan_baru, adminPhone=:notel_baru WHERE admin_ID=:nokp_lama";

    # melaksanakan proses mengemaskini dalam syarat IF
    $stmt = oci_parse($condb, $arahan_sql_update);
    oci_bind_by_name($stmt, ':nokp_baru', $nokp_baru);
    oci_bind_by_name($stmt, ':nama_baru', $nama_baru);
    oci_bind_by_name($stmt, ':katalaluan_baru', $katalaluan_baru);
    oci_bind_by_name($stmt, ':notel_baru', $notel_baru);
    oci_bind_by_name($stmt, ':nokp_lama', $nokp_lama);

    if(oci_execute($stmt))
    {
        oci_close($condb);
        # peroses mengemaskini berjaya.
        echo "<script>alert('Update Success');
        window.location.href='admin_info.php';
        </script>";
    }
    else
    {
        # proses mengemaskini gagal
        echo "<script>alert('Update Failure');
        window.history.back();</script>";
    }
}

?>
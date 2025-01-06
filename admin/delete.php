<?PHP
# menyemak kewujudan data GET
if (!empty($_GET)) {
    # Memanggil fail connection dari folder luaran
    include('../connection.php');

    # Mengambil data GET
    $jadual = $_GET['jadual'];
    $medan_kp = $_GET['medan_kp'];
    $kp = $_GET['kp'];

    $arahan_sql_hapus = "
        DELETE FROM $jadual WHERE $medan_kp = :kp
    ";

    # Melaksanakan arahan SQL
    $laksana_arahan = oci_parse($condb, $arahan_sql_hapus);

    # Bind parameter untuk mengelakkan SQL Injection
    oci_bind_by_name($laksana_arahan, ':kp', $kp);

    # Laksana arahan SQL dalam syarat IF
    if (oci_execute($laksana_arahan, OCI_COMMIT_ON_SUCCESS)) {
        // Jika proses menghapus berjaya, papar info
        oci_free_statement($laksana_arahan);
        oci_close($condb);
        echo "<script>alert('Data deleted successfully');</script>";
        echo "<script>window.location.href='car_info.php';</script>";
    } else {
        echo "<script>alert('Delete Failure');
        window.history.back();</script>";
    }
}

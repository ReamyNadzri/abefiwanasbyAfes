<?php 
// Include the database configuration file  
include 'connection.php'; 

// Query to fetch image data
$sql = "SELECT image FROM images ORDER BY idimg DESC";
$statement = oci_parse($condb, $sql);
oci_execute($statement);

?>

<?php if ($row = oci_fetch_all($statement, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW)) { ?> 
    <div class="gallery"> 
        <?php foreach ($rows as $row) { ?> 
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['IMAGE']); ?>" /> 
        <?php } ?> 
    </div> 
<?php } else { ?> 
    <p class="status error">Image(s) not found...</p> 
<?php } 

?>

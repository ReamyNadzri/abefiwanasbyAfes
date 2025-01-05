<?php include('header.php'); ?><br>

<form action="uploadimg.php" method="post" enctype="multipart/form-data">
    <label>Select Image File:</label>
    <input type="file" name="image">
    <input type="submit" name="submit" value="Upload">
</form>

<?php 
// Include the database configuration file  
include 'connection.php'; 

// If file upload form is submitted 
$status = $statusMsg = ''; 
if (isset($_POST["submit"])) { 
    $status = 'error'; 
    if (!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif'); 
        if (in_array($fileType, $allowTypes)) { 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = file_get_contents($image); 
         
          
            if (!$condb) {
                $e = oci_error();
                die("Failed to connect to Oracle: " . htmlentities($e['message']));
            }

            // Prepare SQL to insert image into database
            $sql = "INSERT INTO images (image, datecreate) VALUES (:imgContent, SYSDATE)";
            $stmt = oci_parse($condb, $sql);
            
            // Bind the image content as a BLOB
            $blob = oci_new_descriptor($condb, OCI_D_LOB);
            oci_bind_by_name($stmt, ":imgContent", $blob, -1, OCI_B_BLOB);
            
            // Open the BLOB descriptor and write image content
            $blob->writeTemporary($imgContent, OCI_TEMP_BLOB);

            // Execute the statement
            if (oci_execute($stmt, OCI_COMMIT_ON_SUCCESS)) { 
                $status = 'success'; 
                $statusMsg = "File uploaded successfully."; 
            } else { 
                $statusMsg = "File upload failed, please try again."; 
            }

            // Free resources
            $blob->free();
            oci_free_statement($stmt);
            oci_close($condb);
        } else { 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    } else { 
        $statusMsg = 'Please select an image file to upload.'; 
    } 
} 
 
// Display status message 
echo $statusMsg; 
?>

<br>
<?php include('footer.php'); ?>

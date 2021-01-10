<html>
<body>
<?php
	
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".\r\n";
		echo "-----------------------------------------------\r\n";
        $uploadOk = 1;
    } else {
        echo "File is not an image.\r\n";
		echo "-----------------------------------------------\r\n";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.\r\n";
	echo "-----------------------------------------------\r\n";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 4096000) {
    echo "Sorry, your file is too large.\r\n";
	echo "-----------------------------------------------\r\n";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.\r\n";
	echo "-----------------------------------------------\r\n";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.\r\n";
	echo "-----------------------------------------------\r\n";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.\r\n";
		echo "-----------------------------------------------\r\n";
    }
}

$SCREEN_NAME = $_POST["screenname"];
$RADI = $_POST["radio"];
$command = "sudo -u root /var/www/app/twflood_php.sh ".escapeshellarg($SCREEN_NAME)." ".escapeshellarg($RADI)." ".escapeshellarg($target_file). " > output.log 2>&1 &";
exec($command, $output, $return);

if ( !$return ) {
    echo "Script run Successfully!\r\n";
} else {
    echo "Script run failed!\r\n";
}

?>
</body>
</html>

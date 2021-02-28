<h1>Profile</h1>

<h3>Username: </h3>
<?php $user = getUserByEmailOrUsername(null, $_SESSION["username"]);
    print $user["username"];
?>
<h3>Photo: </h3>
<img src="photos/<?php print $user['photo']; ?>" width="250px">
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="photo">
<button type="submit" name="upload-photo" value="upload-photo">Change photo</button>
</form>

<?php
    $phpFileUploadErrors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
);
    if (isset($_POST["upload-photo"])){
        if(isset($_FILES["photo"])){
            if($_FILES["photo"]){
                if($_FILES["photo"]["error"] == 0){
                    switch ($_FILES["photo"]["type"]){
                        case 'image/jpg':
                        case 'image/jpeg':
                        case 'image/png':
                        case 'image/bmp':
                        case 'image/gif':                
                            $photoName = uniqid().$_FILES["photo"]["name"];
                            $photoSaved = move_uploaded_file($_FILES["photo"]["tmp_name"], "photos/".$photoName);
                            if($photoSaved){
                                $updatePhoto = changePhoto($user["id"], $photoName);
                                if ($updatePhoto){
                                    header("location:index.php?page=2");
                                }else{
                                    unlink("photos/".$photoName);
                                    print $_FILES["photo"]["error"];
                                };
                            }else{
                                print $_FILES["photo"]["error"];
                            };
                        default:
                            print "The uploaded file is not a supported";
                    };
                }
            }
        }
    }
?>
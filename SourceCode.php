<?php



function sanitize_file_name($filename)
{
    return $filename;
}

function uploaded_picture($foto)
{
    $default_directory = __DIR__ . "/images";
    if (!is_dir($default_directory)) {
        mkdir($default_directory);
    }
    $profilepicture = $foto;
    $new_file_name = sanitize_file_name($profilepicture['name']);
    $new_file_path = $default_directory . "/" . $new_file_name;

    if (empty($profilepicture)) {
        die("ERROR: File is not selected. ");
    }
    if ($profilepicture['error']) {
        die("ERROR: " . $profilepicture['error']);
    }
    if ($profilepicture['size'] > 500000) {
        die("ERROR: File is too large than expected.");
    }

    $i = 1;
    while (file_exists($new_file_path)) {
        $i = $i + 1;
        $new_file_name = $i . '_' . $new_file_name;
        $new_file_path = $default_directory . "/" . $new_file_name;
    }

    if (move_uploaded_file($profilepicture['tmp_name'], $new_file_path)) {
        $imageSrc = str_replace(__DIR__, '', $new_file_path);
        echo "<body>
              <h2>You profile image was updated! </h2>
              <img src= $imageSrc alt=\"ProfImag\" style=\"width:128px;height:128px;\">
              </body>";
    }
}

function profilePic()
{
    echo '<div style="margin-bottom: 15px;">';
    echo '<h4>';
    echo 'Change your profile picture (Max. 5 Mb)';
    echo '</h4><br>';
    echo '<form enctype="multipart/form-data" action="" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
    <input name="profile_pic" type="file" size="25" /><br><br>
    <input type="submit" value="Upload" />
	</form>';
    echo '</div>';
    if (isset($_FILES['profile_pic'])) {
        uploaded_picture($_FILES['profile_pic']);
    }
}

profilePic();
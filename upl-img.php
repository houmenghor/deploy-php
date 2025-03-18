<?php 
    // $file = $_FILES['txt-file'];
    // $imgName = $file['name'];
    // $ext  = pathinfo($imgName, PATHINFO_EXTENSION);
    // $newName = time();
    // $tmp = $file['tmp_name'];
    // move_uploaded_file($tmp,'img/'.$newName.'.'.$ext);

  

    $thumbnail = rand(1, 10000) . '-' . $_FILES['txt-file']['name'];
    $ext  = pathinfo($thumbnail, PATHINFO_EXTENSION);
    move_uploaded_file($_FILES['txt-file']['tmp_name'], 'img/' . $thumbnail.'.'.$ext);
    $msg['imgName'] = $thumbnail.'.'.$ext;
    echo json_encode($msg);

    // if (isset($_FILES['txt-file'])) {
    //     $file = $_FILES['txt-file'];
    //     $imgName = $file['name'];
    //     $ext = pathinfo($imgName, PATHINFO_EXTENSION);
    //     $newName = time();
    //     $tmp = $file['tmp_name'];
    
    //     // Check if the file was uploaded successfully
    //     if ($file['error'] === UPLOAD_ERR_OK) {
    //         $destination = 'img/' . $newName . '.' . $ext;
    //         if (move_uploaded_file($tmp, $destination)) {
    //             echo "File uploaded successfully!";
    //         } else {
    //             echo "Failed to move the uploaded file.";
    //         }
    //     } else {
    //         echo "File upload error: " . $file['error'];
    //     }
    // } else {
    //     echo "No file uploaded.";
    // }

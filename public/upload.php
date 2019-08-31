<?php

// Upload Dir
$uploadDir = "./upload/";

// TODO:
// check if authorized

if (!empty($_POST['image']) && !empty($_POST['message'])){
    // Do upload
    $imageName = time() . '.png';
    $img = $_POST['image']; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
    $img = str_replace(' ', '+', str_replace('data:image/png;base64,', '', $img));
    $data = base64_decode($img);
    file_put_contents($uploadDir . $imageName, $data);
    var_dump($imageName, $_POST['message']);
}else{
    http_response_code(400);
}

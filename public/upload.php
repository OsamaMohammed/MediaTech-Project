<?php
require 'include/include_all.php';

// Upload Dir
$uploadDir = "./upload/";

if (!empty($_POST['image']) && !empty($_POST['message'])){

    //SQL
    $conn = OSASQL::connect();
    $sql = "INSERT INTO posts(user_id, comments, image, upload_time) VALUES (?,?,?,?)";
    
    // Do upload
    $imageName = time() . '.png';
    $img = $_POST['image']; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
    $img = str_replace(' ', '+', str_replace('data:image/png;base64,', '', $img));
    $data = base64_decode($img);
    file_put_contents($uploadDir . $imageName, $data);
    
    // Insert into MySQL
    $date = date('Y-m-d H:i:s');
    $conn->prepare($sql)->execute([$user_id, $_POST['message'], $imageName, $date]);

    preg_match_all('(#[A-Za-z_0-9]+)', $_POST['message'], $matches);
    print_r($matches);
}else{
    http_response_code(400);
}

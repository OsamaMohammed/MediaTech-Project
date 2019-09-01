<?php
require 'include/include_all.php';

function postImage($imgName, $fullName, $username, $comment, $uploadTime){
    return "<div class='card'><div class='card-image'><figure class='image is-3by3'><img src='/upload/$imgName'></figure></div><div class='card-content'><div class='media'><div class='media-content'><p class='title is-4'>$fullName</p><p class='subtitle is-6'>@$username</p></div></div><div class='content'>$comment<br><time datetime='2016-1-1'>$uploadTime</time></div></div></div>";
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 0;
$perPage = 3;
$offset = $page * $perPage;

$conn = OSASQL::connect();//ORDER BY id DESC
$stmt = $conn->query("SELECT * FROM posts ORDER BY ID DESC LIMIT $offset, $perPage;");
$stmt->execute();
while ($row = $stmt->fetch()) {
    // var_dump($row);
    echo postImage($row['image'], $user['full_name'], $user['username'], $row['comments'], $row['upload_time']);
}

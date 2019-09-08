<?php
require 'include/include_all.php';

function clickableHashtags($message){
    return preg_replace("/(^|\s)#([A-Za-z_0-9]+)/", '$1<a href="/index.php?tag=$2">#$2</a>', $message);
}

function postImage($imgName, $fullName, $username, $comment, $uploadTime){
    return "<div class='card'><div class='card-image'><figure class='image is-3by3'><img src='/upload/$imgName'></figure></div><div class='card-content'><div class='media'><div class='media-content'><p class='title is-4'>$fullName</p><p class='subtitle is-6'>@$username</p></div></div><div class='content'>$comment<br><time datetime='2016-1-1'>$uploadTime</time></div></div></div>";
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 0;
$perPage = 3;
$offset = $page * $perPage;

if (isset($_GET['tag'])){
    // Serve Hashtag posts
    foreach(OSASQL::getHashtagPosts($_GET['tag'], $offset, $perPage) as $row) {
        echo postImage($row['image'], $row['full_name'], $row['username'], clickableHashtags($row['comments']), $row['upload_time']);
    }
}else{
    // Serve regular posts
    foreach(OSASQL::getUserPosts($user_id, $offset, $perPage) as $row) {
        echo postImage($row['image'], $row['full_name'], $row['username'], clickableHashtags($row['comments']), $row['upload_time']);
    }
}
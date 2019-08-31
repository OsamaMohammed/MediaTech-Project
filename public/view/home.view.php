<?php

function postImage($imgName, $fullName, $username, $comment, $uploadTime){
    return "<div class='card'><div class='card-image'><figure class='image is-3by3'><img src='/upload/$imgName'></figure></div><div class='card-content'><div class='media'><div class='media-content'><p class='title is-4'>$fullName</p><p class='subtitle is-6'>@$username</p></div></div><div class='content'>$comment<br><time datetime='2016-1-1'>$uploadTime</time></div></div></div>";
}

echo postImage('logo.png', "Osamah Saadallah", "osamah_mohammed", 'Comment HERE', date("D, d M Y H:i:s"));

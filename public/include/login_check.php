<?php

// check login and create global var
if (isset($_COOKIE['token']) && !empty($_COOKIE['token'])){
    $data = OSAJWT::decodeToken($_COOKIE['token']);
    if ($data){
        $user_id = $data->urid;
        $conn = OSASQL::connect();
        $sql = "select * from users where id = ?";
        // $user = $conn->prepare($sql)->execute();
        $user = $conn->query("select * from users where id = $user_id")->fetch();
    }else{
        echo("401 Unauthorized, please login");
        exit;
    }
}else{
    echo("401 Unauthorized, please login");
    exit;
  }
  
<?php
require 'include/include_all.php';
function getHashtags($message){
    preg_match_all('/(?:\s|^)#([A-Za-z_0-9]+)/', $message, $matches);
    if (count($matches[1]) == 0){
        return [];
    }
    $matches = array_unique($matches[1]);
    return $matches;
}


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
    $post_id = $conn->lastInsertId();

    // HashTags
    $hashtags = getHashtags($_POST['message']);
    print_r($hashtags);
    if (count($hashtags) != 0){
        // Get all IDs
        $str = implode('","', $hashtags);
        $conn = OSASQL::connect();
        $stmt = $conn->query("SELECT * FROM hashtag_names WHERE text IN (\"$str\")");
        $stmt->execute();
        $dbTags = [];
        foreach($stmt->fetchAll() as $tag){
            $dbTags[$tag['id']] = $tag['text'];
        }
        $hashIds = array();
        foreach($hashtags as $tag){
            $key = array_search($tag, $dbTags);
            if ($key === false){
                // create hashtag
                $conn = OSASQL::connect();
                $sql = "INSERT INTO hashtag_names(text) VALUES (?)";
                $conn->prepare($sql)->execute([$tag]);
                $key = $conn->lastInsertId();
            }
            $hashIds[] = $key;
        }
        
        // Insert all hashIds into database
        $str = "(?, $post_id)";
        for($i=1;$i<count($hashIds);$i++){
            $str .= ",(?, $post_id) ";
        }
        $conn = OSASQL::connect();
        $sql = "INSERT INTO hashtags(hashtag_id, post_id) VALUES " . $str . ";";
        $res = $conn->prepare($sql)->execute($hashIds);
    
    }

    /** !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
}else{
    http_response_code(400);
}

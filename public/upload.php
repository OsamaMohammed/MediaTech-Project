<?php
/**
 * API Calls Here
 */
require 'include/include_all.php';

/** Configurations */
// Upload Dir
$uploadDir = "./upload/";

/**
 * Extract all unique hashtags from message
 *
 * @param string $message
 * @return array
 */
function getHashtags($message){
    preg_match_all('/(?:\s|^)#([A-Za-z_0-9]+)/', $message, $matches);
    if (count($matches[1]) == 0){
        return [];
    }
    $matches = array_unique($matches[1]);
    return $matches;
}

/** Upload image handling */
if (!empty($_POST['image']) && !empty($_POST['message'])){

    //SQL
    $conn = OSASQL::connect();
    $sql = "INSERT INTO posts(user_id, comments, image, upload_time) VALUES (?,?,?,?)";
    
    // Do upload
    $imageName = time() . '.png';
    $img = $_POST['image'];
    $img = str_replace(' ', '+', str_replace('data:image/png;base64,', '', $img));
    $data = base64_decode($img);
    if (file_put_contents($uploadDir . $imageName, $data) === FALSE){
        http_response_code(400);
        echo "Error uploading file";
        exit;
    }
    
    // Insert into database
    $date = date('Y-m-d H:i:s');
    $conn->prepare($sql)->execute([$user_id, $_POST['message'], $imageName, $date]);
    $post_id = $conn->lastInsertId();

    // HashTags
    $hashtags = getHashtags($_POST['message']);
    if (count($hashtags) != 0){
        // Get all IDs from DB
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
                // insert hashtag into db
                $key = OSASQL::insertHash($tag);
            }
            $hashIds[] = $key;
        }
        
        // Insert all hashIds into database
        OSASQL::insertPostHash($hashIds, $post_id);
    }

}else{
    http_response_code(400);
}

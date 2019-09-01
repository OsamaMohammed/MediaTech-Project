<pre>
    
<?php
require 'include/include_all.php';

function getHashtags($message){
    preg_match_all('/(?:\s|^)#([A-Za-z_0-9]+)/', $message, $matches);
    $matches = array_unique($matches[1]);
    return $matches;
}
function clickableHashtags($message){
    return preg_replace("/(^|\s)#([A-Za-z_0-9]+)/", '$1<a href="/hashtag.php?tag=$2">#$2</a>', $message);
}

$m = "#fadsf df #rw435 #rw435 #rw435 $3422  4323#asd asd #sdassda_aswq4e24 #asd";
print_r($m);
echo "<br>";
$m = clickableHashtags($m);
print_r($m);
exit;

$hashtags = getHashtags($m);
print_r($hashtags);
exit;
$post_id = 1;

// Get all IDs
$str = implode('","', $hashtags);
$conn = OSASQL::connect();
$stmt = $conn->query("SELECT * FROM hashtag_names WHERE text IN (\"$str\")");
$stmt->execute();
foreach($stmt->fetchAll() as $tag){
    $dbTags[$tag['id']] = $tag['text'];
}
// print_r($dbTags);
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

print_r($hashIds);

// insert all hashIds into database
$str = "(?, $post_id)";
for($i=1;$i<count($hashIds);$i++){
    $str .= ",(?, $post_id) ";
}
$conn = OSASQL::connect();
$sql = "INSERT INTO hashtags(hashtag_id, post_id) VALUES " . $str . ";";
// die($sql);
$res = $conn->prepare($sql)->execute($hashIds);

// insert
/*
$conn = OSASQL::connect();
$sql = "INSERT INTO posts(user_id, comments, image, upload_time) VALUES (?,?,?,?)";
$conn->prepare($sql)->execute([$user_id, $_POST['message'], $imageName, $date]);
*/
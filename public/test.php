<pre>
    
<?php
require 'include/include_all.php';

$m = "fadsf df #rw435 #rw435 #rw435 $3422  4323 asd asd #sdassda_aswq4e24 #";
preg_match_all('/#([A-Za-z_0-9]+)/', $m, $matches);
$matches = array_unique($matches[1]);
print_r($matches); // All hashtags
$post_id = 1;

// Get all IDs
$str = implode('","', $matches);
print_r($str);
$conn = OSASQL::connect();
$stmt = $conn->query("SELECT * from hashtag_names where text in (\"$str\")");
$stmt->execute();
$result = array();
while ($row = $stmt->fetch()) {
    $result[] = $row;
}
print_r($result);



// insert
/*
$conn = OSASQL::connect();
$sql = "INSERT INTO posts(user_id, comments, image, upload_time) VALUES (?,?,?,?)";
$conn->prepare($sql)->execute([$user_id, $_POST['message'], $imageName, $date]);
*/
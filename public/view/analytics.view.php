<pre>

<?php

$conn = OSASQL::connect();//ORDER BY id DESC
$stmt = $conn->query("SELECT user_id, count(id) AS PostNumbers FROM posts GROUP BY user_id ORDER BY PostNumbers DESC LIMIT 3;");
$stmt->execute();
$result = array();
while ($row = $stmt->fetch()) {
    $result[] = $row;
}
var_dump($result);

?>

</pre>
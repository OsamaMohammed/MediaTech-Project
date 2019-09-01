<div class="box">
    <h1>Top 3 Active Users</h1>
    <table class="table">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Posts Count</th>
            </tr>
        </thead>
        <tbody>
<?php
$conn = OSASQL::connect(); //ORDER BY id DESC
$stmt = $conn->query("SELECT 
posts.user_id, users.username, count(posts.id) AS PostNumbers 
from posts INNER JOIN users ON posts.user_id=users.id
group by user_id order by PostNumbers desc limit 3;");
$stmt->execute();
$result = array();

while ($row = $stmt->fetch()) {
    $result[] = $row;
    echo "<tr><td>" . $row['username'] . "</td><td>" . $row['PostNumbers'] . "</td></tr>";
}
?>
        </tbody>
    </table>
</div>
<hr>
<div class="box">

    <h1>Top 3 Hashtags</h1>
    <table class="table">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Posts Count</th>
            </tr>
        </thead>
        <tbody>
<?php

// Work inprogress

?>
        </tbody>
    </table>


</div>
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
// Printing out top 3 users
foreach(OSASQL::getTopUsers() as $row) {
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

// Printing out top 3 used hashtags
foreach(OSASQL::getTopHashtags() as $row) {
    $text = $row['text'];
    echo "<tr><td><a href='/index.php?tag=$text'>$text</a></td><td>" . $row['Used'] . "</td></tr>";
}

?>
        </tbody>
    </table>


</div>
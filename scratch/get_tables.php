<?php
$db = mysqli_connect('localhost', 'root', 'harry71Nahid920*', 'main');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
$result = $db->query("SHOW TABLES");
if ($result) {
    while($row = $result->fetch_array()) {
        echo $row[0] . "\n";
    }
} else {
    echo "Error: " . $db->error;
}
mysqli_close($db);

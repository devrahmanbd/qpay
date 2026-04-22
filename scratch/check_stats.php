<?php
$db = mysqli_connect('localhost', 'root', 'harry71Nahid920*', 'main');
if (!$db) die("Conn fail");

$res = $db->query("SELECT status, count(*) as count FROM api_payments GROUP BY status");
while($row = $res->fetch_assoc()) {
    echo "Status " . $row['status'] . ": " . $row['count'] . "\n";
}

$res = $db->query("SELECT status, count(*) as count FROM transactions GROUP BY status");
while($row = $res->fetch_assoc()) {
    echo "Transactions Status " . $row['status'] . ": " . $row['count'] . "\n";
}

mysqli_close($db);

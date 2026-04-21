<?php
$db = mysqli_connect('localhost', 'root', 'harry71Nahid920*', 'main');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// 1. Manually trigger a log to test the helper if needed, 
// but here we just check if any exist from our previous curl attempts.
$result = $db->query("SELECT * FROM device_logs ORDER BY id DESC LIMIT 5");
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo json_encode($row) . "\n";
    }
} else {
    echo "No logs found in device_logs table.\n";
}

mysqli_close($db);

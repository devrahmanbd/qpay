<?php

// Database credentials from app/Config/Database.php for Production
$hostname = 'localhost';
$username = 'clou_qpay1';
$password = 'harry71Nahid920*';
$database = 'clou_qpay1';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = 'admin@cloudman.one';
$key = 'fVSARTobNKvglddV9QhKlPFTsFcLUD884mmh1wjg';

echo "Database: $database\n";
echo "Checking records for Email: $email and Key: $key\n";

$sql = "SELECT id, uid, user_email, device_key FROM devices WHERE user_email = ? AND device_key = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $key);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Device Found in PRODUCTION:\n";
    while($row = $result->fetch_assoc()) {
        print_r($row);
        
        // Check associated user
        $uid = $row['uid'];
        $user_sql = "SELECT id, email FROM users WHERE id = ?";
        $u_stmt = $conn->prepare($user_sql);
        $u_stmt->bind_param("i", $uid);
        $u_stmt->execute();
        $u_res = $u_stmt->get_result();
        if ($u_res->num_rows > 0) {
            echo "User for UID $uid found.\n";
            print_r($u_res->fetch_assoc());
        } else {
            echo "CRITICAL: User for UID $uid NOT FOUND in PRODUCTION users table.\n";
        }
    }
} else {
    echo "Device NOT FOUND in PRODUCTION with the provided credentials.\n";
    
    // Check if the email exists at all in devices
    echo "\nChecking if email $email exists in any devices record:\n";
    $sql2 = "SELECT id, user_email, device_key FROM devices WHERE user_email = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("s", $email);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while($row = $result2->fetch_assoc()) {
        print_r($row);
    }
}

$conn->close();

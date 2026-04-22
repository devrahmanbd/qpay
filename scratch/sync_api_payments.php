<?php
/**
 * Backfill script to sync completed API payments to the legacy transactions table
 * for dashboard visibility.
 */

$db = mysqli_connect('localhost', 'root', 'harry71Nahid920*', 'main');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Starting synchronization...\n";

// Find completed api_payments that are NOT in the transactions table
$sql = "SELECT ap.* 
        FROM api_payments ap
        LEFT JOIN transactions t ON ap.ids = t.ids
        WHERE ap.status = 2 AND t.ids IS NULL";

$result = $db->query($sql);

if (!$result) {
    die("Query error: " . $db->error);
}

$count = 0;
while ($row = $result->fetch_assoc()) {
    $ids = $row['ids'];
    $uid = $row['merchant_id'];
    $type = $row['payment_method'];
    $transaction_id = $row['transaction_id'];
    $amount = $row['amount'];
    $created_at = $row['created_at'];
    $updated_at = $row['updated_at'];

    $insert_sql = "INSERT INTO transactions (ids, uid, type, transaction_id, amount, status, created_at, updated_at) 
                   VALUES ('$ids', '$uid', '$type', '$transaction_id', '$amount', 2, '$created_at', '$updated_at')";
    
    if ($db->query($insert_sql)) {
        echo "[OK] Synced Payment ID: $ids (Amount: $amount)\n";
        $count++;
    } else {
        echo "[ERROR] Failed to sync $ids: " . $db->error . "\n";
    }
}

echo "\nSynchronization complete. Total records synced: $count\n";

mysqli_close($db);

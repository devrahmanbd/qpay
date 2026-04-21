<?php
$file = 'app/Controllers/Api/V1/PaymentController.php';
$content = file_get_contents($file);
$tokens = token_get_all($content);

$level = 0;
$line = 1;
foreach ($tokens as $token) {
    if (is_array($token)) {
        $line = $token[2];
        $text = $token[1];
    } else {
        $text = $token;
    }

    if ($text == '{') {
        $level++;
        echo "Line $line: { (Level: $level)\n";
    } elseif ($text == '}') {
        $level--;
        echo "Line $line: } (Level: $level)\n";
    }
}

if ($level != 0) {
    echo "\nFINAL LEVEL: $level (MISMATCH!)\n";
} else {
    echo "\nBraces match.\n";
}

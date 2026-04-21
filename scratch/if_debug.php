<?php
$file = 'app/Controllers/Api/V1/PaymentController.php';
$content = file_get_contents($file);
$tokens = token_get_all($content);

$level = 0;
$line = 1;
foreach ($tokens as $token) {
    if (is_array($token)) {
        $type = $token[0];
        $text = $token[1];
        $line = $token[2];
    } else {
        $type = null;
        $text = $token;
    }

    if ($text == '{') {
        $level++;
    } elseif ($text == '}') {
        $level--;
    }

    if ($type === T_IF && $level == 1) {
        echo "Line $line: IF statement found at Class level (Level 1)!\n";
    }
}
echo "Check complete.\n";

<?php

if (!function_exists('encrypt_ids')) {
    /**
     * Legacy substitution cipher used in qpay-sub
     */
    function encrypt_ids($data) {
        $map = [
            'a' => 'k', 'A' => 'K', 'b' => 'l', 'B' => 'L', 'c' => 'm', 'C' => 'M',
            'd' => 'n', 'D' => 'N', 'e' => 'o', 'E' => 'O', 'f' => 'p', 'F' => 'P',
            'g' => 'q', 'G' => 'Q', 'h' => 'r', 'H' => 'R', 'i' => 's', 'I' => 'S',
            'j' => 't', 'J' => 'T', 'k' => 'u', 'K' => 'U', 'l' => 'v', 'L' => 'V',
            'm' => 'w', 'M' => 'W', 'n' => 'x', 'N' => 'X', 'o' => 'y', 'O' => 'Y',
            'p' => 'z', 'P' => 'Z', 'q' => 'a', 'Q' => 'A', 'r' => 'b', 'R' => 'B',
            's' => 'c', 'S' => 'C', 't' => 'd', 'T' => 'D', 'u' => 'e', 'U' => 'E',
            'v' => 'f', 'V' => 'F', 'w' => 'g', 'W' => 'G', 'x' => 'h', 'X' => 'H',
            'y' => 'i', 'Y' => 'I', 'z' => 'j', 'Z' => 'J',
        ];
        return strtr($data, $map);
    }
}

if (!function_exists('decrypt_ids')) {
    /**
     * Reverse legacy substitution cipher
     */
    function decrypt_ids($data) {
        $map = [
            'a' => 'k', 'A' => 'K', 'b' => 'l', 'B' => 'L', 'c' => 'm', 'C' => 'M',
            'd' => 'n', 'D' => 'N', 'e' => 'o', 'E' => 'O', 'f' => 'p', 'F' => 'P',
            'g' => 'q', 'G' => 'Q', 'h' => 'r', 'H' => 'R', 'i' => 's', 'I' => 'S',
            'j' => 't', 'J' => 'T', 'k' => 'u', 'K' => 'U', 'l' => 'v', 'L' => 'V',
            'm' => 'w', 'M' => 'W', 'n' => 'x', 'N' => 'X', 'o' => 'y', 'O' => 'Y',
            'p' => 'z', 'P' => 'Z', 'q' => 'a', 'Q' => 'A', 'r' => 'b', 'R' => 'B',
            's' => 'c', 'S' => 'C', 't' => 'd', 'T' => 'D', 'u' => 'e', 'U' => 'E',
            'v' => 'f', 'V' => 'F', 'w' => 'g', 'W' => 'G', 'x' => 'h', 'X' => 'H',
            'y' => 'i', 'Y' => 'I', 'z' => 'j', 'Z' => 'J',
        ];
        return strtr($data, array_flip($map));
    }
}

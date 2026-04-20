<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_encryption {

    protected $character_map;

    public function __construct() {
        // Initialize the character map
        $this->character_map = array(
            'a' => 'k', 'A' => 'K',
            'b' => 'l', 'B' => 'L',
            'c' => 'm', 'C' => 'M',
            'd' => 'n', 'D' => 'N',
            'e' => 'o', 'E' => 'O',
            'f' => 'p', 'F' => 'P',
            'g' => 'q', 'G' => 'Q',
            'h' => 'r', 'H' => 'R',
            'i' => 's', 'I' => 'S',
            'j' => 't', 'J' => 'T',
            'k' => 'u', 'K' => 'U',
            'l' => 'v', 'L' => 'V',
            'm' => 'w', 'M' => 'W',
            'n' => 'x', 'N' => 'X',
            'o' => 'y', 'O' => 'Y',
            'p' => 'z', 'P' => 'Z',
            'q' => 'a', 'Q' => 'A',
            'r' => 'b', 'R' => 'B',
            's' => 'c', 'S' => 'C',
            't' => 'd', 'T' => 'D',
            'u' => 'e', 'U' => 'E',
            'v' => 'f', 'V' => 'F',
            'w' => 'g', 'W' => 'G',
            'x' => 'h', 'X' => 'H',
            'y' => 'i', 'Y' => 'I',
            'z' => 'j', 'Z' => 'J',
        );
    }

    public function encrypt($data) {
        // Apply substitution cipher during encryption
        $data = strtr($data, $this->character_map);

        return $data;
    }

    public function decrypt($data) {
        // Reverse the substitution cipher during decryption
        $character_map_reverse = array_flip($this->character_map);
        $decrypted_data = strtr($data, $character_map_reverse);

        return $decrypted_data;
    }
}

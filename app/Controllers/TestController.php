<?php
namespace App\Controllers;
class TestController extends BaseController {
    public function index() {
        echo json_encode(['status' => 1, 'message' => 'Test OK']);
    }
}

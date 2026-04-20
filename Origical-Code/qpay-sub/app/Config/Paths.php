<?php

namespace Config;

class Paths
{
    public $systemDirectory = __DIR__ . '/../system';
    public $appDirectory = __DIR__ . '/..';
    public $writableDirectory = __DIR__ . '/../../writable';
    public $testsDirectory = __DIR__ . '/../../tests';
    public $viewDirectory;

    public function __construct()
    {
        $paymentFormVersion = 'Viewsuddok';
        
        $this->viewDirectory = __DIR__ . '/../' . $paymentFormVersion;
    }
}

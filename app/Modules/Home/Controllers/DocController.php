<?php

namespace Home\Controllers;

use App\Controllers\BaseController;


class DocController extends BaseController
{
    public $data = [];
    public $model;
    public function __construct()
    {
    }

    public function index()
    {
        $this->template->set_layout('general');
        return  $this->template->view('developers/index')->render();
    }
    public function docs()
    {
        return view('Home\Views\developers\docs');
    }

    public function integrations()
    {
        $this->template->set_layout('general');
        $this->template->set('title', 'Integrations & SDKs');
        return $this->template->view('developers/integrations')->render();
    }
}

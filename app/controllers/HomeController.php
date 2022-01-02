<?php

class HomeController extends Controller {

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function index() {

        $data = [
            'title' => 'Homepage',
        ];

        $this->view('index', $data);
    }
}
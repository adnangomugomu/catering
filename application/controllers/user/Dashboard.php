<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'index' => 'user/dashboard/index',
            'index_js' => 'user/dashboard/index_js',
            'title' => 'Dashboard',
        ];

        $this->templates->load($data);
    }

    public function session()
    {
        session();
    }
}

/* End of file Dashboard.php */

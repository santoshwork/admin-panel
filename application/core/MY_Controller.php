<?php

class MY_Controller extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('session');

        if (!$this->session->userdata('username'))
        {
            redirect(base_url());
        }
    }
}
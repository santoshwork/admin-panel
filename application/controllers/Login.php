<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct()
	  {        
		  parent::__construct();
		  $this->load->database();
		  $this->load->library('form_validation');
		  $this->load->helper('date');
		  $this->load->model('userdata');        
	   } 
	 
	public function index()
	{
		$this->data['page'] = 'login';
        $this->load->view('layout/template', $this->data);
	}
	public function submit_data()
	{
		
		if($this->input->post('submit'))
		{		
		  $this->form_validation->set_rules('uname', 'User Name', 'required|max_length[50]');
		  $this->form_validation->set_rules('password', 'Password', 'required|max_length[16]');
		 if ($this->form_validation->run() == FALSE)
		  {
			echo "404";

		  }
		  else
		  {
			  $userData         = array();
			  $userData['username']= $this->input->post('uname',TRUE);
			  $userData['password']	=$this->input->post('password',TRUE);
			  
			  //User Login			
			  $result=$this->userdata->loginAccess($userData);
			  if($result==1) echo "200";
			  else if($result==0) echo "201";
		  }
		}
	}	
	
}

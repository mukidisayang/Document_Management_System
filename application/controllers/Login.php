<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	function __construct(){
		parent::__construct();
        session_start();
		$this->load->helper('url');
	}

	public function index()
	{



		if(isset($_SESSION['google_data'])){

			$title="SCL : Document Management System";

			$data['title'] = ucfirst($title); // Capitalize the first letter

			$this->load->view('header', $data);
			$this->load->view('account');
			$this->load->view('google_login');
			$this->load->view('footer', $data);
		}
		else{
			$this->load->view('login');
		}

	}




}

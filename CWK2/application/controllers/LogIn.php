<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LogIn extends CI_Controller {

	public function index()
	{
		$this->load->view('pages/login_view');
	}
}

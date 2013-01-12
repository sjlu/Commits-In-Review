<?php

class Welcome extends CI_Controller
{

	function index()
	{
		$this->load->view('include/header');

		$code = $this->input->get('code');
		if (!empty($code))
		{
			$this->load->model('github_model');
			$access_token = $this->github_model->get_access_token($code);
			// what to do with this access token?
		}
		else
			$this->load->view('welcome');

		$this->load->view('include/footer');
	}

}

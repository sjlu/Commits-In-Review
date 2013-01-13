<?php

class Welcome extends CI_Controller
{

	/**
	 * index()
	 * Does a lot of stuff.
	 */
	function index()
	{
		$this->load->view('include/header');

		if ($code = $this->input->get('code'))
		{
			$this->load->model('github_model');

			$this->load->library('session');
			if (!$access_token = $this->session->userdata('access_token'))
				$access_token = $this->github_model->get_access_token($code);

			if (!$access_token)
				$this->load->view('welcome', array('error' => true));

			$this->session->set_userdata('access_token', $access_token);

			// what to do with this access token?
			$username = $this->github_model->get_username($access_token);
			$repositories = $this->github_model->get_repositories($access_token);
			$this->github_model->get_commits($access_token, $repositories, $username);
		}
		else
			$this->load->view('welcome');

		$this->load->view('include/footer');
	}

}

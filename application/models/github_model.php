<?php

class Github_model extends CI_Model 
{
	private $client_id = null;
	private $client_secret = null;

	function __construct()
	{
		parent::__construct();
		$this->config->load('github');
		$this->client_id = $this->config->item('github_id');
		$this->client_secret = $this->config->item('github_secret'); 
	}

	function get_access_token($code)
	{
		if (empty($code))
			return false;

		$this->load->library('curl');
		$response = $this->curl->simple_post('https://github.com/login/oauth/access_token', array(
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
			'code' => $code
		));		

		parse_str($response, $response); // retarded php

		if (isset($response['error']))
			return false;

		return $response['access_token'];
	}
}
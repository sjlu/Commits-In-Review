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

		$this->load->library('curl');
	}

	function get_access_token($code)
	{
		if (empty($code))
			return false;

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

	function get_username($token)
	{
		$response = $this->curl->simple_get('https://api.github.com/user', array(
			'access_token' => $token,
		));

		$response = json_decode($response);

		return $response->login;
	}

	function get_repositories($token)
	{
		$response = $this->curl->simple_get('https://api.github.com/user/repos', array(
			'access_token' => $token,
			'type' => 'all',
			'sort' => 'updated',
			'direction' => 'desc'
		));

		$response = json_decode($response);	

		$repositories = array();
		foreach ($response as $repository)
			$repositories[] = array(
				'name' => $repository->name,
				'url' => substr($repository->commits_url, 0, -6)
			);

		return $repositories;
	}

	function get_commits($token, $repositories, $username_filter = null)
	{
		$commits = array();
		foreach ($repositories as $repository)
		{
			$request_parameters = array(
				'access_token' => $token,
				'since' => date('c', strtotime('-1 year'))
			);

			if (!is_null($username_filter))
				$request_parameters['author'] = $username_filter;

			$response = $this->curl->simple_get($repository['url'], $request_parameters);
			$response = json_decode($response);

			if (count($response))
				foreach ($response as $commit)
					$commits[] = array(
						'repository' => $repository,
						'message' => $commit->commit->message,
						'url' => $commit->commit->url,
						'timestamp' => date('U', strtotime($commit->commit->author->date))
					);
		}

		function compare_timestamp($a, $b)
		{
			return $b['timestamp'] - $a['timestamp'];
		}

		usort($commits, 'compare_timestamp');

		return $commits;
	}
}
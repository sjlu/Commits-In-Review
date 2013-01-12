<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (ENVIRONMENT == 'production')
{
	$config['github_id'] = 'ab445319b519bc615a9b';
	$config['github_secret'] = '401e1f170385ef152104501f0d85c635d95269a0';
}
else
{
	$config['github_id'] = 'c768df9cb9a46c69e042';
	$config['github_secret'] = '224977f748ea0a19b6bd41a23fc73e8191deb6eb';
}
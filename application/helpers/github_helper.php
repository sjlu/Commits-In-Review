<?php
/**
 * This generates a nice Github OAuth URL
 */
function github_oauth_url()
{
   $CI =& get_instance();
   $CI->config->load('github');
   $id = $CI->config->item('github_id');

   return 'https://github.com/login/oauth/authorize?client_id=' . $id;
}
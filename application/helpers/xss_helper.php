<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('print_out'))
{
	function print_out($str = '')
	{
		echo htmlentities($str, ENT_QUOTES, 'UTF-8');
	}
}
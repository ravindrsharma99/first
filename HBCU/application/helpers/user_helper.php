<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('curl_function'))
{
    function curl_function($params=null,$url=null)
    {
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$params);  //Post Fields
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = [
		'Content-Type: application/json'
		];
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		$result=json_decode($server_output);
		return $result;
    }   
}
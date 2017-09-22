<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function postFile($url,$data){
	$opts = array(
	    'http' => array (
    	'method' => 'POST',
        'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
    	'content' => http_build_query($data)
	  )
	);
	$context = stream_context_create($opts);
	$string=file_get_contents($url,false,$context);
	return $string;
}

function getcURL($url){
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	$result=curl_exec($ch);
	curl_close($ch);
	$result=json_decode($result);
	return $result;
}

function postcURL($url, $data = array()){
	$data=http_build_query($data);
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTREDIR, 3);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));
	$result=curl_exec($ch);
	curl_close($ch);
	return $result;
}
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Description
* This class load autoload composer
*/

class Composer{
	function __construct(){
		include("./vendor/autoload.php");
	}	
}
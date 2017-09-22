<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
// use namespace
use Restserver\Libraries\REST_Controller;
/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */

class Search_key extends REST_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->helper('curl');
		$this->load->helper('htmldom');
		$this->load->library('composer');
	}

	public function index_get(){
		$key_word = $this->get("kata");
		if (!empty($key_word)) {

			$key_word = urldecode($key_word);
			$data_to_post= array('q' => $key_word);
			$response = Requests::post('http://opac.uin-suka.ac.id', array(), $data_to_post);
			
			$html_object = str_get_html($response->body);
			$content 	 = $html_object->find('div[id=c] div[lang]');
			$data = [];
			foreach ($content as $key => $value) {
				$judul 		 = strip_tags($value->find('h2', 0)->innertext);
				$ket 		 = strip_tags($value->find('span', 0)->innertext);
				$lokasi 	 = str_replace('&nbsp;&gt;&nbsp;', '>', strip_tags($value->find('small', 0)->innertext));
				$data[] 	 = array(
					 'judul' => utf8_encode($judul),
					 'des'   => utf8_encode($ket),
					 'lokasi'=> utf8_encode($lokasi) 
				);
			}

			if (empty($data)) {
				$data[0]  = array('judul' => 'Not Found!' , 'des' => 'Not Found', 'lokasi' => 'Not Found');
				$response = array('status' => 'not', 'data' => $data);
			}else{
				$response = array(
					'status' => 'ok',
					'data'   => $data
				);
			}

			$this->response($response, 200);		
		}else{
			$data = array('status' => 'fail' , 'error' => 'no keyword');
			$this->response($data, 502);
		}
	}
}
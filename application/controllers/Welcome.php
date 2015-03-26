<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
        
        parent::__construct();
        $this->load->model('main_model');
 


    }
	public function index()
	{
		$this->main_model->mesas_libres();
	}
}

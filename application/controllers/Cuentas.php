<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuentas extends CI_Controller {

	    public function __construct() {
        parent::__construct();
        
        $this->load->model('cuentas_model','cuentas');
        
        
    }

	public function index()
	{
		$data['cuentas'] = $this->cuentas->index();
        $this->load->view('cuentas', $data);
	}

}

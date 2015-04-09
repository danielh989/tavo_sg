<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('main_model');
        $this->load->helper(array('url'));
  }

	public function index()
	{
		$data['mesas_activas']=$this->main_model->mesas_activas();
		$this->load->view('main',$data);
	}

	public function getMesas()
	{
		echo json_encode($this->main_model->mesas_libres());
	}

	public function crearSesionOrden(){
		print_r($_POST);
	}
}

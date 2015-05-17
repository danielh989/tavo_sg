<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mesas extends CI_Controller
{
    public function __construct()
    {
      parent::__construct();
      $this->load->model('mesas_model', 'mesas');
    }
    
    public function index()
    {
      $data['mesas'] = $this->mesas->index();
      $this->load->view('common/header');
      $this->load->view('mesas', $data);
    }
    
    public function add()
    {
			if ($this->input->post())
			{
				$this->mesas->add($this->input->post());
			} 
			else
			{
				show_404('page');
			}
    }
    
    public function delete()
    {    
			if ($this->input->post('id_mesa'))
			{
				$this->mesas->delete($this->input->post('id_mesa'));
			} 
			else
			{
				show_404('page');
			}
    }
    
    public function libres()
    {
      $this->encode($this->mesas->libres());
    }
    
    private function encode($data)
    {
      header('Content-type: application/json');
      print json_encode($data);
    }
}

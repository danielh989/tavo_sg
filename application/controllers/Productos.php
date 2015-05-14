<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller
{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('productos_model', 'productos');
    }
    
    public function index() {
        $data['productos'] = $this->productos->index();
        $this->load->view('common/header');
        $this->load->view('productos', $data);
    }
    
    public function getJSON() {
        $id_cat = $this->input->post('id_cat');
        $this->encode($this->productos->index($id_cat));
    }
    
    public function add() {
        if ($this->productos->add($this->input->post())) {
            $this->encode(array('st' => 1));
        } 
        else {
            $this->encode(array('st' => 0));
        }
    }

    public function delete($id){
        $this->productos->delete($id);
        redirect('/productos', 'refresh');
    }
    
    private function encode($data) {
        header('Content-type: application/json');
        print json_encode($data);
    }
}

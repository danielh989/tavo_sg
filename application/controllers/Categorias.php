<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller
{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('categorias_model', 'categorias');
    }
    
    public function index() {
        
        $data['categorias'] = $this->categorias->index();
        
        $this->load->view('common/header');
        $this->load->view('categorias', $data);
    }
    
    public function getJSON() {
        $this->encode($this->categorias->index());
    }
    
    public function add() {
        if ($this->input->post()) {
            $this->categorias->add($this->input->post());
        } 
        else {
            show_404('page');
        }
    }
    
    public function delete() {
        if ($this->input->post('id_categoria')) {
            
            $this->categorias->delete($this->input->post('id_categoria'));
        } 
        else {
            show_404('page');
        }
    }
    
    private function encode($data) {
        header('Content-type: application/json');
        print json_encode($data);
    }
}

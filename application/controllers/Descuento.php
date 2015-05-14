<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Descuento extends CI_Controller
{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('descuento_model', 'descuento');
    }
    
    public function index() {
        
        $data['descuento'] = $this->descuento->index();
        $this->load->view('common/header');
        $this->load->view('descuento', $data);
    }
    
    public function update() {
        
        if ($this->input->post('descuento')) {
            $this->descuento->update($this->input->post('descuento'));
            redirect('/descuento');
        } 
        else {
            show_404('page');
            
            break;
        }
    }
}

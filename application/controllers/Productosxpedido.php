<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productosxpedido extends CI_Controller
{
    
    /**
     * Inicializa modelos, helpers y librerias
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        
        $this->load->model('productosxpedido_model', 'productosxpedido');
        
        //$this->output->enable_profiler(TRUE);
        
        
    }
    
    public function index() {
        
        show_404('page');
    }
    
    public function delete() {
        if ($this->input->post('id_pedido')) {
            $this->productosxpedido->delete($this->input->post('id_pedido'), $this->input->post('id_producto'));
        } 
        else {
            show_404('page');
        }
    }
    
    public function deleteDevuelto() {
        if ($this->input->post('id_pedido')) {
            $this->productosxpedido->deleteDevuelto($this->input->post('id_pedido'), $this->input->post('id_producto'));
        } 
        else {
            show_404('page');
        }
    }
    
    public function devolver() {
        if ($this->input->post('id_pedido')) {
            $this->productosxpedido->devolver($this->input->post('id_pedido'), $this->input->post('id_producto'));
        } 
        else {
            show_404('page');
        }
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller
{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('pedidos_model', 'pedidos');
        $this->load->model('mesas_model', 'mesas');
        $this->load->model('productosxpedido_model', 'productosxpedido');
        $this->load->library('session');
    }
    
    public function index() {
        $data['mesas_activas'] = $this->mesas->activas();
        $this->load->view('common/header');
        $this->load->view('pedidos', $data);
    }
    
    public function detalle($id_pedido = null) {
        
        if (!$id_pedido) {
            
            show_404('page');
            
            break;
        }
        
        // Detalles del pedido
        $data['detalle'] = $this->pedidos->detalle($id_pedido);
        $data['devoluciones'] = $this->productosxpedido->devueltos($id_pedido);
        $this->session->set_flashdata('id_pedido', $id_pedido);
        
        // Total acumulado del pedido
        $data['total'] = $this->productosxpedido->sumTotal($id_pedido);
        
        //Total formateado paral a vista
        $data['total_f'] = array_filter(explode('.', $data['total']));
        
        // Productos del pedido
        $data['productos'] = $this->productosxpedido->index($id_pedido);
        
        if ($data['detalle']->estado == 'Cerrado') {
            $this->load->view('common/header');
            $this->load->view('detalle_pedido_simple', $data);
        } 
        else {
            $this->load->view('common/header');
            $this->load->view('detalle_pedido', $data);
        }
    }
    
    public function add() {
        $productos = json_decode(json_encode($_POST['productos']));
        $this->pedidos->add($_POST['id_mesa'], $productos);
    }
    
    public function pagar() {
        
        if ($this->input->post()) {
            $efectivo = $this->input->post('efectivo');
            $debito = $this->input->post('debito');
            
            $id_pedido = $this->session->flashdata('id_pedido');
            $this->pedidos->pagar($id_pedido, $efectivo, $debito);
            redirect('/', 'refresh');
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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller
{
    
    /**
     * Inicializa modelos, helpers y librerias
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('cuentas'); 
        $this->load->model('descuento'); 
        $this->load->model('categorias'); 
        $this->load->model('mesas'); 
        $this->load->model('pedidos'); 
        $this->load->model('productos'); 
        $this->load->model('productosxpedido'); 
        
        //$this->output->enable_profiler(TRUE);
        
        
    }
    
    public function cuentas() {
        

        $data['cuentas'] = $this->cuentas->index();
        $this->load->view('cuentas', $data);
    }
    
    public function submit_descuento() {


        
        if ($this->input->post('descuento')) {
            $this->descuento->update($this->input->post('descuento'));
            redirect('/main/descuento_familiar');
        } 
        else {
            show_404('page');
            
            break;
        }
    }
    
    public function descuento_familiar() {
        
        $data['descuento'] = $this->descuento->index();
        
        $this->load->view('descuento_familiar', $data);
    }
    
    public function editar_categorias() {
        
        $data['categorias'] = $this->categorias->index();
        
        $this->load->view('editar_categorias', $data);
    }
    
    public function submit_categoria() {
        if ($this->input->post()) {
            $this->categorias->add($this->input->post());
        } 
        else {
            show_404('page');
        }
    }
    
    public function eliminar_categoria() {
        if ($this->input->post('id_categoria')) {
            
            $this->categorias->delete($this->input->post('id_categoria'));
        } 
        else {
            show_404('page');
        }
    }
    
    public function editar_mesas() {
        
        $data['mesas'] = $this->mesas->index();
        
        $this->load->view('editar_mesas', $data);
    }
    
    public function submit_mesa() {
        
        if ($this->input->post()) {
            $this->mesas->add($this->input->post());
        } 
        else {
            show_404('page');
        }
    }
    
    public function eliminar_mesa() {
        
        if ($this->input->post('id_mesa')) {
            $this->mesas->delete($this->input->post('id_mesa'));
        } 
        else {
            show_404('page');
        }
    }
    
    /**
     * Carga la vista con las mesas con ordenes activas
     *
     * @return void
     */
    public function index() {
        $data['mesas_activas'] = $this->mesas->activas();
        $this->load->view('main', $data);
    }
    
    /**
     * Retorna las mesas disponibles
     *
     * @return json object
     */
    public function getMesas() {
        $this->encode($this->mesas->libres());
    }
    
    /**
     * Retorna las categorias
     *
     * @return json object
     */
    public function getCategorias() {
        $this->encode($this->categorias->index());
    }
    
    /**
     * Retorna los productos de una categoria
     *
     * @return json object
     */
    public function getProductosXCategoria() {
        $id_cat = $this->input->post('id_cat');
        $this->encode($this->productos->index($id_cat));
    }
    
    public function crear_pedido() {
        $productos = json_decode(json_encode($_POST['productos']));
        $this->pedidos->add($_POST['id_mesa'], $productos);
    }
    
    /**
     * Carga la vista con el CRUD de productos
     *
     * @return void
     */
    public function productos() {
        $data['productos'] = $this->productos->index();
        $this->load->view('productos', $data);
    }
    
    /**
     * Carga la vista de un pedido con sus detalles
     *
     * @param $id_pedido String -> ID del pedido
     * @return void
     */
    public function pedido($id_pedido) {
        
        // Detalles del pedido
        if (!$data['detalle'] = $this->pedidos->detalle($id_pedido)) {
            
            show_404('page');
            
            break;
        }
        $data['devoluciones'] = $this->productosxpedido->devueltos($id_pedido);
        $this->session->set_flashdata('id_pedido', $id_pedido);
        
        // Total acumulado del pedido
        $data['total'] = $this->productosxpedido->sumTotal($id_pedido);
        
        //Total formateado paral a vista
        $data['total_f'] = array_filter(explode('.', $data['total']));
        
        // Productos del pedido
        $data['productos'] = $this->productosxpedido->index($id_pedido);
        
        if ($data['detalle']->estado == 'Cerrado') {
            $this->load->view('detalle_pedido', $data);
        } 
        else {
            $this->load->view('pedido', $data);
        }
    }
    
    public function agregar_producto() {
        if ($this->productos->add($this->input->post())) {
            $this->encode(array('st' => 1));
        } 
        else {
            $this->encode(array('st' => 0));
        }
    }
    
    public function eliminar_producto_pedido() {
        if ($this->input->post('id_pedido')) {
            $this->productosxpedido->delete($this->input->post('id_pedido'), $this->input->post('id_producto'));
        } 
        else {
            show_404('page');
        }
    }
    
    public function eliminar_producto_devuelto() {
        if ($this->input->post('id_pedido')) {
            $this->productosxpedido->deleteDevuelto($this->input->post('id_pedido'), $this->input->post('id_producto'));
        } 
        else {
            show_404('page');
        }
    }
    
    public function devolver_producto_pedido() {
        if ($this->input->post('id_pedido')) {
            $this->productosxpedido->devolver($this->input->post('id_pedido'), $this->input->post('id_producto'));
        } 
        else {
            show_404('page');
        }
    }
    
    public function pagar_pedido() {
        
        if ($this->input->post()) {
            $efectivo = $this->input->post('efectivo');
            $debito = $this->input->post('debito');
            
            $id_pedido = $this->session->flashdata('id_pedido');
            $this->pedidos->pagar($id_pedido, $efectivo, $debito);
            redirect('/main/', 'refresh');
        } 
        else {
            show_404('page');
        }
    }
    
    /**
     * Convertir datos en un objeto JSON
     *
     * @param $data String -> Datos a convertir
     * @return json objeto
     */
    private function encode($data) {
        header('Content-type: application/json');
        print json_encode($data);
    }
}

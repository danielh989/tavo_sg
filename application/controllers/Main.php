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
        $this->load->model('main_model');
        $this->load->helper(array('url'));
        $this->load->library('session');
    }
    
    public function cuentas() {
        
        $data['cuentas'] = $this->main_model->getCuentas();
        $this->load->view('cuentas', $data);
    }
    
    public function submit_descuento() {
        
        $this->main_model->submit_descuento($this->input->post('descuento'));
        redirect('/main/descuento_familiar');
    }
    
    public function descuento_familiar() {
        
        $data['descuento'] = $this->main_model->getDescuento();
        
        $this->load->view('descuento_familiar', $data);
    }
    
    public function editar_categorias() {
        
        $data['categorias'] = $this->main_model->getCategorias();
        
        $this->load->view('editar_categorias', $data);
    }
    
    public function submit_categoria() {
        
        $this->main_model->submit_categoria($this->input->post());
    }
    
    public function eliminar_categoria() {
        
        $this->main_model->eliminar_categoria($this->input->post('id_categoria'));
    }
    
    public function editar_mesas() {
        
        $data['mesas'] = $this->main_model->getMesas();
        
        $this->load->view('editar_mesas', $data);
    }
    
    public function submit_mesa() {
        
        $this->main_model->submit_mesa($this->input->post());
    }
    
    public function eliminar_mesa() {
        
        $this->main_model->eliminar_mesa($this->input->post('id_mesa'));
    }
    
    /**
     * Carga la vista con las mesas con ordenes activas
     *
     * @return void
     */
    public function index() {
        $data['mesas_activas'] = $this->main_model->mesas_activas();
        $this->load->view('main', $data);
    }
    
    /**
     * Retorna las mesas disponibles
     *
     * @return json object
     */
    public function getMesas() {
        $this->encode($this->main_model->mesas_libres());
    }
    
    /**
     * Retorna las categorias
     *
     * @return json object
     */
    public function getCategorias() {
        $this->encode($this->main_model->categorias());
    }
    
    /**
     * Retorna los productos de una categoria
     *
     * @return json object
     */
    public function getProductosXCategoria() {
        $id = $this->input->post('id_cat');
        $this->encode($this->main_model->productos_x_categoria($id));
    }
    
    public function crear_pedido() {
        $productos = json_decode(json_encode($_POST['productos']));
        $this->main_model->crear_pedido($_POST['id_mesa'], $productos);
    }
    
    /**
     * Carga la vista con el CRUD de productos
     *
     * @return void
     */
    public function productos() {
        $data['productos'] = $this->main_model->listar_productos();
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
        $data['detalle'] = $this->main_model->detalle_pedido($id_pedido);
        $data['devoluciones'] = $this->main_model->productos_devueltos($id_pedido);
        $this->session->set_flashdata('id_pedido', $id_pedido);
        
        // Total acumulado del pedido
        $total = $this->main_model->total_pedido($id_pedido);

        $data['total'] = explode('.', $total);
        
        // Formateo del precio para la vista
        $data['total'] = array_filter($data['total']);
        
        // Productos del pedido
        $data['productos'] = $this->main_model->productos_pedido($id_pedido);
        
        $this->load->view('pedido', $data);
    }
    
    public function agregar_producto() {
        if ($this->main_model->agregar_producto($this->input->post())) {
            $this->encode(array('st' => 1));
        } 
        else {
            $this->encode(array('st' => 0));
        }
    }
    
    public function eliminar_producto_pedido() {
        $this->main_model->eliminar_producto_pedido($this->input->post('id_pedido'), $this->input->post('id_producto'));
    }
    
    public function eliminar_producto_devuelto() {
        $this->main_model->eliminar_producto_devuelto($this->input->post('id_pedido'), $this->input->post('id_producto'));
    }
    
    public function devolver_producto_pedido() {
        $this->main_model->devolver_producto_pedido($this->input->post('id_pedido'), $this->input->post('id_producto'));
    }
    
    public function pagar_pedido() {
        
        // Formateando los valores para la db
        $rawCash = explode(' ', $this->input->post('efectivo'));
        $rawDebit = explode(' ', $this->input->post('debito'));
        $efectivo = (float)str_replace(',', '.', str_replace('.', '', end($rawCash)));
        $debito = (float)str_replace(',', '.', str_replace('.', '', end($rawDebit)));
        
        $id_pedido = $this->session->flashdata('id_pedido');
        $this->main_model->pagar_pedido($id_pedido, $efectivo, $debito);
        redirect('/main/', 'refresh');
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

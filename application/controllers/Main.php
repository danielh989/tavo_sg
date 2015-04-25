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

	public function getCategorias(){
		echo json_encode($this->main_model->categorias());
	}

	public function getProductosXCategoria(){
		$id = $this->input->post('id_cat');
		echo json_encode($this->main_model->productos_x_categoria($id));
	}

	public function crear_pedido(){
		$productos = json_decode(json_encode($_POST['productos']));
		$this->main_model->crear_pedido($_POST['id_mesa'],$productos);
	}

	public function productos(){
		
		$data['productos']=$this->main_model->listar_productos();
		$this->load->view('productos',$data);
	}

	public function pedido($id_pedido){
		# Detalles del pedido
		$data['detalle'] = $this->main_model->detalle_pedido($id_pedido);
		
		# Total acumulado del pedido
		$total = $this->main_model->total_pedido($id_pedido);
		$data['total'] = explode('.', $total); // Formateo del precio para la vista

		# Productos del pedido
		$data['productos'] = $this->main_model->productos_pedido($id_pedido);

		$this->load->view('pedido', $data);
	}
}

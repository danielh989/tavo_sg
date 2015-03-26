<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model {


	    public function __construct() {
        parent::__construct();
        
    }
    
    public function mesas_activas() {

    	//Mesas con pedidos activos

    	$this->db->select('mesas.id as id_mesa, mesas.nombre, mesas.numero, pedidos.id as id_pedido');
    	$this->db->join('pedidos', 'pedidos.id_mesa = mesas.id', 'inner');
    	$this->db->where('pedidos.estado','Activo');
    	$query=$this->db->get('mesas');
    	var_dump($query->result());
 
        
        
    }


}
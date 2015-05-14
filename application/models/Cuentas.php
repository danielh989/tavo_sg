<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuentas extends CI_Model
{
    
    public function __construct() {
        
        parent::__construct();
    }
    
    public function index() {
        
        $this->db->select('cuentas.*,
            pedidos.*,
            mesas.numero as numero_mesa,
            mesas.nombre as nombre_mesa');
        
        $this->db->join('pedidos', 'cuentas.id_pedido = pedidos.id', 'inner');
        $this->db->join('mesas', 'pedidos.id_mesa = mesas.id', 'inner');
        
        return $this->db->get('cuentas')->result();
    }
}
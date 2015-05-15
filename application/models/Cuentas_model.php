<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuentas_model extends CI_Model
{
    
    public function __construct() {
        
       // $this->output->enable_profiler(TRUE);
        parent::__construct();
        $this->load->helper('date');
    }
    
    public function index($fecha = null) {
        
        if (!$fecha) {
            
            $fecha = date('Y-m-d');
        } 
        else {
            
            //La fecha viene de la vista con formato VE, la cambiamos para que la reconozca MySQL
           $fecha = $this->convertirFecha($fecha);
        }
        
        $this->db->select('cuentas.*,
            pedidos.*,
            mesas.numero as numero_mesa,
            mesas.nombre as nombre_mesa');
        $this->db->where('date(pedidos.fecha)', $fecha);
        
        $this->db->join('pedidos', 'cuentas.id_pedido = pedidos.id', 'inner');
        $this->db->join('mesas', 'pedidos.id_mesa = mesas.id', 'inner');
        $this->db->order_by('pedidos.fecha', 'DESC');
        
        return $this->db->get('cuentas')->result();
    }
    
    public function totales($fecha = null) {
        
        if (!$fecha) {
            $fecha = date('Y-m-d');
        } 
        else {
            $fecha = $this->convertirFecha($fecha);
        }
        
        $this->db->select('sum(efectivo) as efectivo, 
                           sum(debito) as debito, 
                           sum(total_devuelto) as perdida, 
                           sum(efectivo+debito) as pagado, 
                           sum(total_pagar) as total_pagar', false);
        
        $this->db->join('pedidos', 'cuentas.id_pedido=pedidos.id', 'inner');
        $this->db->where('date(pedidos.fecha)', $fecha);
        $query = $this->db->get('cuentas');
        return $query->row();
    }
    
    public function convertirFecha($fecha) {
        $fecha = DateTime::createFromFormat('d/m/Y', $fecha);
        return $fecha->format('Y-m-d');
    }
}

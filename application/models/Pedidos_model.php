<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos_model extends CI_Model
{
    
    public function __construct() {
        
        parent::__construct();
    }
    
    public function detalle($id) {
        
        //Muestra detalles de un pedido dado
        $this->db->select('pedidos.*, mesas.numero');
        $this->db->where('pedidos.id', $id);
        $this->db->join('mesas', 'pedidos.id_mesa = mesas.id');
        $query = $this->db->get('pedidos');
        return $query->row();
    }
    
    public function add($id_mesa, $productos) {
        
        //Genera un pedido primeramente con el numero de mesa, luego intenta asignar productos a ese pedido y si no encuentra productos, devuelve la transaccion.
        
        $this->db->set('id_mesa', $id_mesa);
        
        $this->db->trans_start();
        $this->db->insert('pedidos');
        
        $id_pedido = $this->db->insert_id();
        
        if ($productos) {
            
            foreach ($productos as $row) {
                
                for ($i = 0; $i < $row->cantidad; $i++) {
                    
                    $this->db->query("CALL insertar_producto_pedido($id_pedido,$row->id)");
                }
            }
            
            $this->db->trans_complete();
        } 
        else {
            $this->db->trans_rollback();
        }
    }
    
    public function pagar($id_pedido, $efectivo, $debito, $des_bool) {
        
        $this->db->query("CALL cerrar_pedido($id_pedido,$efectivo,$debito,$des_bool)");
    }
    
    public function switchMesa($id_pedido, $id_mesa_nueva) {
        
        //Cambia un pedido de mesa
        
        $this->db->set('id_mesa', $id_mesa_nueva);
        $this->db->where('id', $id_pedido);
        $this->db->update('pedidos');
    }

    public function valorDescuento(){
        $this->db->select('valor');
        $this->db->where('id',1);
        return $this->db->get('varios')->row();
    }
}

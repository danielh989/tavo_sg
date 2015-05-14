<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mesas extends CI_Model
{
    
    public function __construct() {

        //$this->output->enable_profiler(TRUE);
        
        parent::__construct();
    }
    public function index() {
        return $this->db->get('mesas')->result();
    }
    
    public function add($post) {
        
        $this->db->db_debug = FALSE;
        
        if (empty($post['id'])) {
            $this->db->set($post);
            $this->db->insert('mesas');
        } 
        else {
            $this->db->set($post);
            $this->db->where('id', $post['id']);
            $this->db->update('mesas');
        }
        
        echo json_encode($this->db->error());
    }
    public function delete($id) {
        
        $this->db->db_debug = FALSE;
        
        $this->db->where('id', $id);
        $this->db->delete('mesas');
        
        echo json_encode($this->db->error());
    }
    
    public function activas() {
        
        //Mesas con pedidos activos
        
        $this->db->select('mesas.id as id_mesa, mesas.nombre, mesas.numero, pedidos.id as id_pedido');
        $this->db->join('pedidos', 'pedidos.id_mesa = mesas.id', 'inner');
        $this->db->where('pedidos.estado', 'Activo');
        $query = $this->db->get('mesas');
        return $query->result();
    }
    
    public function libres() {
        
        //Mostrar las mesas que no tienen un pedido activo
        
        $this->db->where('mesas.id not in (select id_mesa from pedidos where estado="Activo")');
        $query = $this->db->get('mesas');
        return $query->result();
    }
}

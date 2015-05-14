<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Model
{
    
    public function __construct() {
        
        parent::__construct();
    }
    
    public function index($id_cat=null) {
        if($id_cat){
            $this->db->where('id_cat', $id_cat);
        }
        $this->db->select('productos.id, productos.nombre, categorias.nombre as categoria, productos.id_cat, productos.descripcion, productos.precio');
        $this->db->join('categorias', 'productos.id_cat = categorias.id', 'inner');
        $this->db->order_by('productos.id_cat');
        $query = $this->db->get('productos');
        return $query->result();
    }

       public function add($data) {
        if (empty($data["id"])) {
            $this->db->set($data);
            return $this->db->insert('productos');
        } 
        else {
            $this->db->set($data);
            $this->db->where('id', $data['id']);
            return $this->db->update('productos');
        }
    }
    
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('productos');
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias_model extends CI_Model
{
    
    public function __construct() {
        
        parent::__construct();
    }
    
    public function index() {
        return $this->db->get('categorias')->result();
    }
    
    public function add($post) {
        
        $this->db->db_debug = FALSE;
        
        if (empty($post['id'])) {
            $this->db->set($post);
            $this->db->insert('categorias');
        } 
        else {
            $this->db->set($post);
            $this->db->where('id', $post['id']);
            $this->db->update('categorias');
        }
        
        echo json_encode($this->db->error());
    }
    
    public function delete($id) {
        
        //Se deben deshablitar los mensajes de error para poder capturarlos con la funcion de abajo
        $this->db->db_debug = FALSE;
        
        $this->db->where('id', $id);
        $this->db->delete('categorias');
        
        echo json_encode($this->db->error());
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Descuento extends CI_Model
{
    
    public function __construct() {
        
        parent::__construct();
    }
    
    public function index() {
        $this->db->where('id', 1);
        return $this->db->get('varios')->row();
    }
    
    public function update($valor) {
        
        $this->db->set('valor', $valor);
        $this->db->where('id', 1);
        $this->db->update('varios');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productosxpedido extends CI_Model
{
    
    public function __construct() {
        
        parent::__construct();
    }
    
    public function index($id_pedido) {
        
        //Muestra los productos asociados a un pedido dado, agrupados por producto reflejando cantidad y precio por cantidad
        $this->db->select('productosXpedido.id, productosXpedido.id_pedido, productosXpedido.id_producto');
        $this->db->select('count(productosXpedido.id_producto) as cantidad, sum(productosXpedido.precio) as precio_total, productos.nombre');
        $this->db->join('productos', 'productosXpedido.id_producto = productos.id', 'inner');
        $this->db->where('productosXpedido.id_pedido', $id_pedido);
        $this->db->where('productosXpedido.devuelto IS NULL');
        $this->db->group_by('id_producto');
        $query = $this->db->get('productosXpedido');
        
        return $query->result();
    }
    
    public function sumTotal($id) {
        $this->db->select('sum(productosXpedido.precio) as total');
        $this->db->where('productosXpedido.id_pedido', $id);
        $this->db->where('productosXpedido.devuelto IS NULL');
        
        $query = $this->db->get('productosXpedido');
        return $query->row()->total;
    }
    
    public function add($id_pedido, $id_producto) {
        
        //Agrega un producto a un pedido
        $this->db->query("CALL insertar_producto_pedido($id_pedido, $id_producto)");
    }
    
    public function delete($id_pedido, $id_producto) {
        
        //Remueve un producto de un pedido dado
        $this->db->where('id_pedido', $id_pedido);
        $this->db->where('id_producto', $id_producto);
        $this->db->where('devuelto IS NULL');
        
        //Para eliminar un producto por vez
        $this->db->limit(1);
        
        $this->db->delete('productosXpedido');
    }
    
    public function devolver($id_pedido, $id_producto) {
        
        //Marca un producto como devuelto, es decir como perdida
        $this->db->where('id_pedido', $id_pedido);
        $this->db->where('id_producto', $id_producto);
        $this->db->where('devuelto IS NULL');
        $this->db->set('devuelto', 'Si');
        
        //Para devolver un producto por vez
        $this->db->limit(1);
        
        $this->db->update('productosXpedido');
    }
    
    public function deleteDevuelto($id_pedido, $id_producto) {
        
        //Elimina una devolucion en un pedido
        $this->db->where('id_pedido', $id_pedido);
        $this->db->where('id_producto', $id_producto);
        $this->db->where('devuelto', 'Si');
        
        //Para eliminar un producto por vez
        $this->db->limit(1);
        
        $this->db->delete('productosXpedido');
    }
    
    public function devueltos($id_pedido) {
        
        //Lista las devoluciones de un pedido, a su vez las agrupa segun el producto para determinar la cantidad y el precio por cantidad
        
        $this->db->select('productosXpedido.id, productosXpedido.id_pedido, productosXpedido.id_producto');
        $this->db->select('count(productosXpedido.id_producto) as cantidad, sum(productosXpedido.precio) as precio_total, productos.nombre');
        $this->db->join('productos', 'productosXpedido.id_producto = productos.id', 'inner');
        $this->db->where('productosXpedido.id_pedido', $id_pedido);
        $this->db->where('productosXpedido.devuelto', 'Si');
        $this->db->group_by('id_producto');
        $query = $this->db->get('productosXpedido');
        
        return $query->result();
    }
}

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
    	return $query->result();
 
        
        
    }


    public function mesas_libres (){

    	//Mostrar las mesas que no tienen un pedido activo

    	$this->db->where('mesas.id not in (select id_mesa from pedidos where estado="Activo")');
    	$query=$this->db->get('mesas');
    	var_dump($query->result());
    }

    public function detalle_pedido($id) {

    	//Muestra detalles de un pedido dado
    	$this->db->where('id',$id);
    	$query=$this->db->get('pedidos');
    	var_dump($query->result());
        
    }

    public function productos_pedido($id_pedido){

    	//Muestra los productos asociados a un pedido dado, agrupados por producto reflejando cantidad y precio por cantidad

    	$this->db->select('productosXpedido.id, productosXpedido.id_pedido, productosXpedido.id_producto');
    	$this->db->select('count(productosXpedido.id_producto) as cantidad, sum(productosXpedido.precio) as precio_total, productos.nombre');
    	$this->db->join('productos','productosXpedido.id_producto = productos.id','inner');
    	$this->db->where('productosXpedido.id_pedido',$id_pedido);
    	$this->db->group_by('id_producto');
    	$query=$this->db->get('productosXpedido');
    	var_dump($query->result());

    }

    public function cerrar_pedido($id_pedido){
    	$this->db->query("CALL cerrar_pedido($id_pedido)");
    }

    public function insertar_producto_pedido($id_pedido, $id_producto){
    	$this->db->query("CALL insertar_producto_pedido($id_pedido, $id_producto)");
    }


    public function eliminar_producto_pedido($id_pedido, $id_producto){
    	$this->db->where('id_pedido', $id_pedido);
    	$this->db->where('id_producto', $id_producto);
    	$this->db->limit(1); //Para eliminar un producto por vez
		$this->db->delete('productosXpedido'); 
    }

    public function categorias(){
        $query=$this->db->get('categorias');
        return $query->result();
    }


    public function productos_x_categoria($id_cat){
        $this->db->where('id_cat',$id_cat);
        $query=$this->db->get('productos');
        return $query->result();
    }







}
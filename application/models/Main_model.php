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
        return $query->result();
    }

    public function detalle_pedido($id) {
    	//Muestra detalles de un pedido dado
        $this->db->select('pedidos.*, mesas.numero');
        $this->db->from('pedidos');
        $this->db->where('pedidos.id', $id);
        $this->db->join('mesas', 'pedidos.id_mesa = mesas.id');
    	$query = $this->db->get();
    	return $query->row();
    }

    public function total_pedido($id) {
        $this->db->select('sum(productosXpedido.precio) as total');
        $this->db->from('productosXpedido');
        $this->db->where('productosXpedido.id_pedido', $id);
        $this->db->where('productosXpedido.devuelto IS NULL');

        $query = $this->db->get();
        return $query->row()->total;
    }

    public function productos_pedido($id_pedido){
    	//Muestra los productos asociados a un pedido dado, agrupados por producto reflejando cantidad y precio por cantidad
    	$this->db->select('productosXpedido.id, productosXpedido.id_pedido, productosXpedido.id_producto');
    	$this->db->select('count(productosXpedido.id_producto) as cantidad, sum(productosXpedido.precio) as precio_total, productos.nombre');
    	$this->db->join('productos','productosXpedido.id_producto = productos.id','inner');
    	$this->db->where('productosXpedido.id_pedido',$id_pedido);
        $this->db->where('productosXpedido.devuelto IS NULL');
    	$this->db->group_by('id_producto');
    	$query=$this->db->get('productosXpedido');
    	
        return $query->result();
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

        public function devolver_producto_pedido($id_pedido, $id_producto){
        $this->db->where('id_pedido', $id_pedido);
        $this->db->where('id_producto', $id_producto);
        $this->db->where('devuelto IS NULL');
        $this->db->set('devuelto','Si');
        $this->db->limit(1); //Para eliminar un producto por vez
        $this->db->update('productosXpedido'); 
    }

    public function categorias(){
        $this->db->order_by('nombre');
        $query=$this->db->get('categorias');

        return $query->result();
    }

    public function productos_x_categoria($id_cat){
        $this->db->where('id_cat',$id_cat);
        $query=$this->db->get('productos');
        return $query->result();
    }




    public function crear_pedido($id_mesa, $productos){

        $this->db->set('id_mesa', $id_mesa);

        
        $this->db->trans_start();
        $this->db->insert('pedidos');
        
        $id_pedido = $this->db->insert_id();
        
        if ($productos) {
            
            foreach ($productos as $row) {

                for($i=0; $i<$row->cantidad; $i++){

                    $this->db->query("CALL insertar_producto_pedido($id_pedido,$row->id)");

                }
                
                
            }
            
            $this->db->trans_complete();

        } else {
            $this->db->trans_rollback();
        }


    }


    public function listar_productos(){


        $this->db->select('productos.id, productos.nombre, categorias.nombre as categoria, productos.id_cat, productos.descripcion, productos.precio');
        $this->db->join('categorias','productos.id_cat = categorias.id','inner');
        $this->db->order_by('categorias.nombre');
        $query=$this->db->get('productos');
        return $query->result();


    }


    public function cambiar_mesa($id_pedido, $id_mesa_nueva){

        $this->db->set('id_mesa',$id_mesa_nueva);
        $this->db->where('id', $id_pedido);
        $this->db->update('pedidos'); 

    }


}
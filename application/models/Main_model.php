<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model
{
    
    public function __construct() {
        
        parent::__construct();
    }
    
    public function getCuentas() {
        
        $this->db->select('cuentas.id,
            cuentas.total_pagar,
            cuentas.efectivo,
            cuentas.debito,
            cuentas.total_devuelto,
            cuentas.id_pedido,
            pedidos.fecha,
            pedidos.id_mesa,
            pedidos.descuento,
            pedidos.estado,
            mesas.numero as numero_mesa,
            mesas.nombre as nombre_mesa');
        
        $this->db->join('pedidos', 'cuentas.id_pedido = pedidos.id', 'inner');
        $this->db->join('mesas', 'pedidos.id_mesa = mesas.id', 'inner');
        
        return $this->db->get('cuentas')->result();
    }
    
    public function getDescuento() {
        $this->db->where('id', 1);
        return $this->db->get('varios')->row();
    }
    
    public function submit_descuento($descuento) {
        
        $this->db->set('valor', $descuento);
        $this->db->where('id', 1);
        $this->db->update('varios');
    }
    
    public function eliminar_categoria($id) {
        
        //Se deben deshablitar los mensajes de error para poder capturarlos con la funcion de abajo
        $this->db->db_debug = FALSE;
        
        $this->db->where('id', $id);
        $this->db->delete('categorias');
        
        echo json_encode($this->db->error());
    }
    
    public function submit_categoria($post) {
        
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
    
    public function getCategorias() {
        return $this->db->get('categorias')->result();
    }
    
    public function eliminar_mesa($id) {
        
        $this->db->db_debug = FALSE;
        
        $this->db->where('id', $id);
        $this->db->delete('mesas');
        
        echo json_encode($this->db->error());
    }
    
    public function submit_mesa($post) {
        
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
    
    public function getMesas() {
        return $this->db->get('mesas')->result();
    }
    
    public function mesas_activas() {
        
        //Mesas con pedidos activos
        
        $this->db->select('mesas.id as id_mesa, mesas.nombre, mesas.numero, pedidos.id as id_pedido');
        $this->db->join('pedidos', 'pedidos.id_mesa = mesas.id', 'inner');
        $this->db->where('pedidos.estado', 'Activo');
        $query = $this->db->get('mesas');
        return $query->result();
    }
    
    public function mesas_libres() {
        
        //Mostrar las mesas que no tienen un pedido activo
        
        $this->db->where('mesas.id not in (select id_mesa from pedidos where estado="Activo")');
        $query = $this->db->get('mesas');
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
    
    public function productos_pedido($id_pedido) {
        
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
    
    public function cerrar_pedido($id_pedido) {
        $this->db->query("CALL cerrar_pedido($id_pedido)");
    }
    
    public function insertar_producto_pedido($id_pedido, $id_producto) {
        $this->db->query("CALL insertar_producto_pedido($id_pedido, $id_producto)");
    }
    
    public function eliminar_producto_pedido($id_pedido, $id_producto) {
        $this->db->where('id_pedido', $id_pedido);
        $this->db->where('id_producto', $id_producto);
        $this->db->where('devuelto IS NULL');
        $this->db->limit(1);
        
        //Para eliminar un producto por vez
        $this->db->delete('productosXpedido');
    }
    
    public function eliminar_producto_devuelto($id_pedido, $id_producto) {
        $this->db->where('id_pedido', $id_pedido);
        $this->db->where('id_producto', $id_producto);
        $this->db->where('devuelto', 'Si');
        $this->db->limit(1);
        
        //Para eliminar un producto por vez
        $this->db->delete('productosXpedido');
    }
    
    public function devolver_producto_pedido($id_pedido, $id_producto) {
        $this->db->where('id_pedido', $id_pedido);
        $this->db->where('id_producto', $id_producto);
        $this->db->where('devuelto IS NULL');
        $this->db->set('devuelto', 'Si');
        $this->db->limit(1);
        
        //Para eliminar un producto por vez
        $this->db->update('productosXpedido');
    }
    
    public function categorias() {
        $this->db->order_by('nombre');
        $query = $this->db->get('categorias');
        
        return $query->result();
    }
    
    public function productos_x_categoria($id_cat) {
        $this->db->where('id_cat', $id_cat);
        $query = $this->db->get('productos');
        return $query->result();
    }
    
    public function crear_pedido($id_mesa, $productos) {
        
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
    
    public function listar_productos() {
        
        $this->db->select('productos.id, productos.nombre, categorias.nombre as categoria, productos.id_cat, productos.descripcion, productos.precio');
        $this->db->join('categorias', 'productos.id_cat = categorias.id', 'inner');
        $this->db->order_by('productos.id_cat');
        $query = $this->db->get('productos');
        return $query->result();
    }
    
    public function cambiar_mesa($id_pedido, $id_mesa_nueva) {
        
        $this->db->set('id_mesa', $id_mesa_nueva);
        $this->db->where('id', $id_pedido);
        $this->db->update('pedidos');
    }
    
    public function productos_devueltos($id_pedido) {
        
        $this->db->select('productosXpedido.id, productosXpedido.id_pedido, productosXpedido.id_producto');
        $this->db->select('count(productosXpedido.id_producto) as cantidad, sum(productosXpedido.precio) as precio_total, productos.nombre');
        $this->db->join('productos', 'productosXpedido.id_producto = productos.id', 'inner');
        $this->db->where('productosXpedido.id_pedido', $id_pedido);
        $this->db->where('productosXpedido.devuelto', 'Si');
        $this->db->group_by('id_producto');
        $query = $this->db->get('productosXpedido');
        
        return $query->result();
    }
    
    public function pagar_pedido($id_pedido, $efectivo, $debito) {
        
        $this->db->query("CALL cerrar_pedido($id_pedido,$efectivo,$debito)");
    }
    
    public function agregar_producto($data) {
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
    
    public function eliminar_producto($id) {
        $this->db->where('id', $id);
        $this->db->delete('productos');
    }
}

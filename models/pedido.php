<?php

//es equivalente a las clases de los modelos de java
class Pedido {

    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;
    private $db;

    //Conexión a la BBDD más óptima: en cada clase que acceda a la bbbdd
    public function __construct() {
        $this->db = Database::connect();
    }

    //Getters & Setters
    function getId() {
        return $this->id;
    }

    function getUsuario_id() {
        return $this->usuario_id;
    }

    function getProvincia() {
        return $this->provincia;
    }

    function getLocalidad() {
        return $this->localidad;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getCoste() {
        return $this->coste;
    }

    function getEstado() {
        return $this->estado;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getHora() {
        return $this->hora;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    function setProvincia($provincia) {
        $this->provincia = $this->db->real_escape_string($provincia);
    }

    function setLocalidad($localidad) {
        $this->localidad = $this->db->real_escape_string($localidad);
    }

    function setDireccion($direccion) {
        $this->direccion = $this->db->real_escape_string($direccion);
    }

    function setCoste($coste) {
        $this->coste = $coste;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    //Método de acceso a BBDD para obtener todos los pedidos
    public function getAll() {
        $productos = $this->db->query("SELECT * FROM pedidos ORDER BY id DESC;");
        return $productos;
    }

    //Método de acceso a BBDD para obtener un solo pedido
    public function getOne() {
        $producto = $this->db->query("SELECT * FROM pedidos WHERE id={$this->getId()}");
        return $producto->fetch_object();
    }

    //Buscar un pedido por usuario
    public function getOneByUser() {
        $sql = "SELECT p.id, p.coste FROM pedidos p "
                //. "INNER JOIN lineas_pedidos lp ON lp.pedido_id = p.id "
                . "WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC LIMIT 1";

        $pedido = $this->db->query($sql);
        return $pedido->fetch_object();
    }
    
    //Obtener todos los pedidos de un usuario
    public function getAllByUser() {
        $sql = "SELECT p.* FROM pedidos p "
                //. "INNER JOIN lineas_pedidos lp ON lp.pedido_id = p.id "
                . "WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC";

        $pedido = $this->db->query($sql);
        return $pedido;
    }
    
    //Buscar productos por pedido
    public function getProductosByPedido($id) {
            
        $sql = "SELECT pr.*, lp.unidades FROM productos pr "
                . "INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id "
                . "WHERE lp.pedido_id =($id)";
        $productos = $this->db->query($sql);
        return $productos;
    }
    
    //Guardar pedidos
    public function save() {

        $sql = "INSERT INTO pedidos VALUES(NULL, {$this->getUsuario_id()}, '{$this->getProvincia()}','{$this->getLocalidad()}','{$this->getDireccion()}',{$this->getCoste()},'confirm', CURDATE(), CURTIME())";

        $save = $this->db->query($sql);

        //Para comprobar si la query ha ido bien o no
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    //Método para guardar los datos en la tabla lineas_pedidos
    //Esta tabla intermedia es necesaria para mostrar los productos de un pedido de un usuario

    public function save_linea() {
        //Necesitamos obtener el id del último registro insertado. LO hace con una función sql
        $sql = "SELECT LAST_INSERT_ID() as pedido";

        $query = $this->db->query($sql);
        $pedido_id = $query->fetch_object()->pedido; //accedemos a la porpiedad del alias
        //Para guardar en lineas_pedido, hay que recorrer el carrito
        //Por cada línea del carrito, hay que insertar un registro en la tabla linea_pedidos
        foreach ($_SESSION['carrito'] as $elemento) {
            $producto = $elemento['producto'];

            $insert = "INSERT INTO lineas_pedidos VALUES(NULL, {$pedido_id}, {$producto->id},{$elemento['unidades']})";
            $save = $this->db->query($insert);

            /* var_dump($producto);
             * var_dump($save);
              echo $this->db->error;
              die() */
        }
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }
    //Método para actualizar el estado de un pedido
    public function edit() {
        $sql = "UPDATE pedidos SET estado = '{$this->getEstado()}' ";
        $sql .= " WHERE id={$this->getId()};";
        $save = $this->db->query($sql);
        
        /*echo $sql;
        echo "<br>";
        echo $this->db->error;
        die();*/
        //Para comprobar si la query ha ido bien o no
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

}

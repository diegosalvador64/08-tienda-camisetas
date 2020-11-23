<?php

class Categoria {

    private $id;
    private $nombre;
    private $db;

    //Conexión a la BBDD más óptima: en cada clase que acceda a la bbbdd
    public function __construct() {
        $this->db = Database::connect();
    }
    //Getters y Setters
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setId($id) {
        $this->id = $id;
    }
    //Haciendo esto, obviamos el problema de los caracteres extraños cuando insertamos en BBDD
    function setNombre($nombre) {
        $this->nombre = $this->db->real_escape_string($nombre);
    }
    //Método de acceso a BBDD para obtener todas las categorías
    public function getAll(){
        $categorias = $this->db->query("SELECT * FROM categorias ORDER BY id DESC;");
        return $categorias;      
    }
    
    public function getOne() {
        $categoria = $this->db->query("SELECT * FROM categorias WHERE id={$this->getId()};");
        return $categoria->fetch_object();//esto del fecth se hace para que me saque solo una fila 
    }
    
    public function save(){
        $sql = "INSERT INTO categorias VALUES(NULL, '{$this->getNombre()}');";
        $save = $this->db->query($sql);
        
        $result = false;
        if($save){
            $result = true;
        }
        return $result;
        }

}
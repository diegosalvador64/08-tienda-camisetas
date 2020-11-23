<?php

//Clase estática de conexión a la bbdd. Creo que es
//equivalente a la clase conexion en la carpeta de persistencia en Java (ver cualquier CRUD de Java)
class Database {
    public static function connect() {
        $db = new mysqli('localhost', 'root', '', 'tienda_master');
        //query que nos devuelve caracteres en castellano
        $db->query("SET NAMES 'utf8'");
        return $db;
    }
}


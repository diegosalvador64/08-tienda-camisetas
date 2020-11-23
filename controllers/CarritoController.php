<?php

require_once 'models/producto.php';

//Controlador para el carrito

class carritoController {

    public function index() {
        if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1) {
            $carrito = $_SESSION['carrito'];            
        }else{
            $carrito = array();//el carrito será un array vacío
        }
        require_once 'views/carrito/index.php';
    }

    //Añadir elementos al carrito. Comprobamos que exista una sesión de carrito, 
    //y si no, la creamos
    public function add() {
        //recogemos la id del producto
        if (isset($_GET['id'])) {
            $producto_id = $_GET['id'];
        } else {
            header('Location' . base_url);
        }
        if (isset($_SESSION['carrito'])) {
            $counter = 0;
            //Recorrer el carrito, saca el índice y el valor para ese índice:
            foreach ($_SESSION['carrito'] as $indice => $elemento) {
                //si el id:producto del carrito coincide con el que viene por url, se aumenta
                if ($elemento['id_producto'] == $producto_id) {
                    $_SESSION['carrito'][$indice]['unidades'] ++;
                    $counter++;
                }
            }
        }
        if (!isset($counter) || $counter == 0) {
            //Conseguir producto accediendo al modelo producto
            $producto = new Producto();
            $producto->setId($producto_id);
            $producto = $producto->getOne();
            //Añadir al carrito
            if (is_object($producto)) {
                //La sesión del carrito es un array que tiene varias cosas:
                $_SESSION['carrito'][] = array(
                    "id_producto" => $producto->id,
                    "precio" => $producto->precio,
                    "unidades" => 1,
                    "producto" => $producto
                );
            }
        }
        header('Location:' . base_url . "carrito/index");
    }

    //Quitar elementos al carrito
    public function delete() {
        if(isset($_GET['index'])){
            $index = $_GET['index'];
            unset($_SESSION['carrito'][$index]);
        }
        header("Location:" . base_url . "carrito/index");        
    }

    //Borrar carrito
    public function delete_all() {
        unset($_SESSION['carrito']);
        header("Location:" . base_url . "carrito/index");
    }
    //Añadir unidades al carrito
    public function up() {
        if(isset($_GET['index'])){
            $index = $_GET['index'];
            $_SESSION['carrito'][$index]['unidades']++;
        }
        header("Location:" . base_url . "carrito/index");        

    }
    
    //Quitar unidades al carrito
    public function down() {
        if(isset($_GET['index'])){
            $index = $_GET['index'];
            $_SESSION['carrito'][$index]['unidades']--;
            if($_SESSION['carrito'][$index]['unidades']== 0) {
                unset($_SESSION['carrito'][$index]);
            }
        }
        header("Location:" . base_url . "carrito/index");        

    }
}

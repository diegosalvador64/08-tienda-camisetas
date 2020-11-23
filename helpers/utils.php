<?php

//creamos clases estáticas para no tener que instanciar objetos
class Utils {

    //Borramos sesiones
    public static function deleteSession($name) {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
        return $name;
    }

    //Comprobar que el usuario es admin (administrador)
    public static function isAdmin() {
        if (!isset($_SESSION['admin'])) {
            header("Location:" . base_url);
        } else {
            return true;
        }
    }

    //Comprobar que el usuario está identificado
    public static function isIdentity() {
        if (!isset($_SESSION['identity'])) {
            header("Location:" . base_url);
        } else {
            return true;
        }
    }

    //Mostrar categorías en el index

    public static function showCategorias() {
        require_once 'models/categoria.php';
        $categoria = new Categoria();
        $categorias = $categoria->getAll(); //en esta variable tengo disponible la lista de categorías
        return $categorias;
    }

    public static function statsCarrito() {
        //para sacar las estadísticas del carrito
        //creamos un array de estadísticas
        $stats = array(
            'count' => 0,
            'total' => 0
        );
        if (isset($_SESSION['carrito'])) {
            $stats['count'] = count($_SESSION['carrito']);
            //Hacemos bucle de $_SESSION['carrito']) para ver lo que tiene dentro para calcular el total comprado
            foreach ($_SESSION['carrito'] as $producto) {
                $stats['total'] += $producto['precio'] * $producto['unidades'];
            }
        }
        return $stats;
    }

    //Método para convertir el estado que viene por defecto de la bd en uno legible
    //por ejemplo: si viene "confirm", que se muestre, "confirmado", y así
    public static function showStatus($status) {
        $value = 'Pendiente';
        if ($status == "confirm") {
            $value = 'Pendiente';
        } elseif ($status == "preparation") {
            $value = 'En preparación';
        } elseif ($status == "ready") {
            $value = 'Preparado para enviar';
        } elseif ($status == "sended") {
            $value = 'Enviado';
        }
        return $value;
    }

}

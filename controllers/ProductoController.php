<?php

//Por cada tabla de la base de datos creamos un controlador. 
//Este para la tabla productos
require_once 'models/producto.php';

class productoController {

    public function index() {
        //Mostrar productos de forma aleatoria (random), llamando al método getRandom del modelo
        $producto = new Producto();
        $productos = $producto->getRandom(6);//6 es el límite de productos que queremos salga en pantalla de inicio
        
        //renderizar vista
        require_once 'views/producto/destacados.php';
    }
    
    //Método para ver el detalle del producto
    public function ver() {
       if (isset($_GET['id'])) {
            $id = $_GET['id'];
           
            $producto = new Producto();
            $producto->setId($id); //meto seteado el id

            $product = $producto->getOne();       
        } 
        require_once 'views/producto/ver.php';
    }

    public function gestion() {
        Utils::isAdmin();

        $producto = new Producto();

        $productos = $producto->getAll();

        require_once 'views/producto/gestion.php';
    }

    public function crear() {
        Utils::isAdmin();

        require_once 'views/producto/crear.php';
    }

    public function save() {
        Utils::isAdmin();
        //guardar el producto en bbdd
        if (isset($_POST) && isset($_POST['nombre'])) {
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
            $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
            $stock = isset($_POST['stock']) ? $_POST['stock'] : false;
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;
            //$imagen = isset($_POST['imagen']) ? $_POST['imagen'] : false;
            if ($nombre && $descripcion && $precio && $stock && $categoria) {
                $producto = new Producto();
                $producto->setNombre($nombre);
                $producto->setDescripcion($descripcion);
                $producto->setPrecio($precio);
                $producto->setStock($stock);
                $producto->setCategoria_id($categoria);

                //Guardar la imagen: $_FILES es una variable superglobal donde se guardan archivos
                //el nombre de "imagen" es el que viene del formulario
                if (isset($_FILES['imagen'])) {
                    $file = $_FILES['imagen'];
                    //Cogemos la extensión name que contiene el nombre de la imagen
                    $filename = $file['name'];
                    //Cada extensión de archivo tiene un mimetype diferente
                    //El MIME es (MIME) es una forma estandarizada de indicar la naturaleza y el formato de un documento, archivo o conjunto de datos. 
                    $mimetype = $file['type']; //el tipo es jpg, png, etc
                    //Si el tipo de imagen es uno válido:
                    //var_dump($file);
                    //die();

                    if ($mimetype == "image/jpg" || $mimetype == "image/jpeg" || $mimetype == "image/png" || $mimetype == "image/gif") {

                        //Comprobamos que exista el directorio uploads/images, y si no, se crea con permisos 0777 (no me acuerdo cuales son: escritura, lectura, etc
                        if (!is_dir('uploads/images')) {
                            mkdir('uploads/images', 0777, true);
                        }
                        $producto->setImagen($filename);
                        //mover el archivo a su sitio con la función move_uploaded_file
                        move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename);
                    }
                }

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $producto->setId($id);

                    $save = $producto->edit();
                } else {
                    $save = $producto->save();
                }
                if ($save) {
                    $_SESSION['producto'] = 'complete';
                } else {
                    $_SESSION['producto'] = 'failed';
                }
            } else {
                $_SESSION['producto'] = 'failed';
            }
        } else {
            $_SESSION['producto'] = 'failed';
        }
        header("Location:" . base_url . "producto/gestion");
    }

    public function editar() {
        Utils::isAdmin();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $edit = true;

            $producto = new Producto();
            $producto->setId($id); //meto seteado el id

            $pro = $producto->getOne();

            //Utilizamos la vista de crear 
            require_once 'views/producto/crear.php';
        } else {
            header('Location:' . base_url . 'producto/gestion');
        }
    }

    public function eliminar() {
        Utils::isAdmin();
        //Si llega el id desde el formulario, se llama al método del modelo
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $producto = new Producto();
            //Le meto al modelo el id necesario antes de llamar al método delete
            $producto->setId($id);
            $delete = $producto->delete();
            if ($delete) {
                $_SESSION['delete'] = 'complete';
            } else {
                $_SESSION['delete'] = 'failed';
            }
        } else {
            $_SESSION['delete'] = 'failed';
        }
        header('Location:' . base_url . 'producto/gestion');
    }

}

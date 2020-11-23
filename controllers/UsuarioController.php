<?php

//Por cada tabla de la base de datos creamos un controlador. 
//Este para la tabla usuarios.
//Vamos creando métodos, que se van llamando desde la barra de navegación 
//de esta forma: http://localhost/Masterphp/08-tienda-camisetas/?controller=usuario&action=registro
//El ?action=registro es la llamada al método registro()

require_once 'models/usuario.php';

class usuarioController {

    public function index() {
        echo "Controlador tabla Usuarios, Acción index";
    }

    public function registro() {
        //muestra el formulario guardado en views/usuario/registro.php
        require_once 'views/usuario/registro.php';
    }

    public function save() {
        //Recogemos los datos que nos llegan del registro del usuario
        if (isset($_POST)) {
            $usuario = new Usuario();
            //$_POST son los que proceden del formulario
            //Comprobamos que los campos del formulario existen. Lo hacemos con el
            //caracter ternario "?". Si existe, se deja, y si no, false
            //Esta validación simplemente nos indica que los datos vengan rellenos
            //Pero en HTML5 esta validación ya se hace en los propios campos cuando se les pone required
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;
            
            //Comprobamos que los campos vengan rellenos (true)
            if ($nombre && $apellidos && $email && $password) {
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setEmail($email);
                $usuario->setPassword($password);

                $save = $usuario->save();

                if ($save) {
                    $_SESSION['register'] = "complete";
                } else {
                    $_SESSION['register'] = "failed";
                }
            } else {
                $_SESSION['register'] = "failed";
            }
        } else {
            $_SESSION['register'] = "failed";
        }
        header("Location:" . base_url . 'usuario/registro');
    }
    
    public function login(){
        if(isset($_POST)) {
            //identificar al usuario
            //Consulta a la BBDD
            $usuario = new Usuario();
            //Pasamos email y password del formulario al método del objeto Usuario a través de 
            //los setters. Comprobamos si el email existe y la password es la suya
            $usuario->setEmail($_POST['email']);
            $usuario->setPassword($_POST['password']);
            //Guardamos el resultado de la llamada al método login 
            //del modelo Usuario en la variable $identity
            $identity = $usuario->login();
            
            //Si ha ido bien el login y es un objeto, guardo estos datos en sesión
            //para tenerlos siempre disponibles: los atributos de la tabla usuarios
            if($identity && is_object($identity)) {
                $_SESSION['identity'] = $identity;
                           
            //Como hay un rol admin en la tabla usuarios, también lo contemplamos
            //pues hay cosas que el usuario con rol de admin puede hacer que no 
            //pueden hacer los demás usuarios, como gestionar categorías y productos
                if($identity->rol == 'admin'){
                    $_SESSION['admin'] = true;
                }
            }else{
                $_SESSION['error_login'] = 'Identificación fallida!!';
            }
            
        }
        header("Location:".base_url);
    }
    
    public function logout() {
        if(isset($_SESSION['identity'])){
            unset($_SESSION['identity']);
        }
        if(isset($_SESSION['admin'])){
            unset($_SESSION['admin']);
        }
        header("Location:".base_url);
    }
}//Fin clase

<?php

require_once 'models/pedido.php';

//Por cada tabla de la base de datos creamos un controlador. 
//Este para la tabla pedidos

class pedidoController {

    public function hacer() {


        require_once 'views/pedido/hacer.php';
    }

    public function add() {
        if (isset($_SESSION['identity'])) {
            //Recogemos el id del usuario que tenemos guardado en identity, que se creó al loguearnos
            $usuario_id = $_SESSION['identity']->id;

            //Validar con el ternario los datos que vienen del formulario
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
            //El coste lo recogemos del total que guardamos en carrito
            $stats = Utils::statsCarrito();
            $coste = $stats['total'];
            //Si los datos gauradados vienen a true, se guardan los datos en la bd
            if ($provincia && $localidad && $direccion) {
                //guardar datos en bd 
                $pedido = new Pedido();
                $pedido->setUsuario_id($usuario_id);
                $pedido->setProvincia($provincia);
                $pedido->setLocalidad($localidad);
                $pedido->setDireccion($direccion);
                $pedido->setCoste($coste);

                $save = $pedido->save();

                //Guardar linea pedido
                $save_linea = $pedido->save_linea();

                //Comprobamos que ambos accesos (inserciones) a la bd se han hecho
                if ($save && $save_linea) {
                    $_SESSION['pedido'] = "complete";
                } else {
                    $_SESSION['pedido'] = "failed";
                }
            } else {//no se validad bien los datos
                $_SESSION['pedido'] = "failed";
            }

            header("Location:" . base_url . 'pedido/confirmado');
        } else {
            //Redirigir al index 
            header("Location:" . base_url);
        }
    }

    public function confirmado() {
        if (isset($_SESSION['identity'])) {
            $identity = $_SESSION['identity'];
            //Buscar el último pedido del usuario identificado
            $pedido = new Pedido();
            $pedido->setUsuario_id($identity->id);
            $pedido = $pedido->getOneByUser();

            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductosByPedido($pedido->id);
        }
        require_once 'views/pedido/confirmado.php';
    }

    public function mis_pedidos() {
        //Aquí se listan todos los pedidos del usuario
        //Comprobar qu el usuario esté identificado
        Utils::isIdentity();
        $usuario_id = $_SESSION['identity']->id;
        $pedido = new Pedido();

        //Sacar los pedidos del usuario
        $pedido->setUsuario_id($usuario_id);
        $pedidos = $pedido->getAllByUser();

        require_once 'views/pedido/mis_pedidos.php';
    }

    public function detalle() {
        Utils::isIdentity();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            //Sacar los datos del pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido = $pedido->getOne();
            
            //Sacar los productos
            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductosByPedido($id);

            require_once 'views/pedido/detalle.php';
        } else {
            header('Location:' . base_url . 'pedido/mis_pedidos');
        }
    }
    
    public function gestion() {
        Utils::isAdmin();
        $gestion = true;
        
        $pedido = new Pedido();
        $pedidos = $pedido->getAll();
        
        require_once 'views/pedido/mis_pedidos.php';
    }
    
    public function estado(){
        Utils::isAdmin();
        if(isset($_POST['pedido_id']) && isset($_POST['estado'])){
            //Recoger los datos del formulario
            $id = $_POST['pedido_id'];
            $estado = $_POST['estado'];
            //Update del pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido->setEstado($estado);
            $pedido->edit();
            
            header("Location:".base_url.'pedido/detalle&id='.$id);
        }else{
            header("Location:".base_url);
        }
    }
}

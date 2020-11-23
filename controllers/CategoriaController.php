 <?php

//Por cada tabla de la base de datos creamos un controlador. 
//Este para la tabla categorias. Así tenemos a todos los métodos del objeto categoria
require_once 'models/categoria.php';
//Como quiero sacar los productos que corresponden a cada categoría, tengo que incluir el modelo del producto
require_once 'models/producto.php';

class categoriaController {
    public function index() {
        //Comprobamos que el usuario es administrador, accediendo a la clase Utils de helpers
        Utils::isAdmin();
        //Creamos un objeto de la clase Catagoria (como en Java, para acceder a sus métodos)
        $categoria = new Categoria();
        $categorias = $categoria->getAll();//en esta variable tengo disponible la lista de categorías
        
        require_once 'views/categoria/index.php';
    }
    
    //ver los productos de cada categoría
    public function ver() {
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            //Conseguir categoría
            $categoria = new Categoria();
            $categoria->setId($id);//metemos el id que viene de pantalla recogido por $_GET
            $categoria = $categoria->getOne();//llamamos al método para obtener una categoría
            
            //Conseguir productos a partir de la id recuperada een el paso inmediatamente anterior
            $producto = new Producto();
            $producto->setCategoria_id($id);
            $productos = $producto->getAllCategory();
        }
        require_once 'views/categoria/ver.php';
    }
    
    public function crear() {
        Utils::isAdmin();
        require_once 'views/categoria/crear.php';
    }
    
    public function save() {
        Utils::isAdmin();
        //guardar la categoría en bbdd
        if(isset($_POST) && isset($_POST['nombre'])) {
            $categoria = new Categoria();
            //Recojo nombre del formulario
            $categoria->setNombre($_POST['nombre']);
            $categoria->save();//llamo al método save del modelo categoria, que hace INSERT en la tabla categorias
        }
        
        
        header("Location:".base_url."categoria/index");
        
    }
    
}

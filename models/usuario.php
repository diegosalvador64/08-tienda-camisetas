<?php

//es equivalente a las clases de los modelos de java
class usuario {

    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $rol;
    private $imagen;
    private $db;

    //Conexión a la BBDD más óptima: en cada clase que acceda a la bbbdd
    public function __construct() {
        $this->db = Database::connect();
    }

    //Getters & Setters
    function getId() {
        return $this->id;
    }

    function getNombre() {

        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        //Incluye el protocolo de encriptación de la contraseña
        return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
    }

    //Rol e imagen son fijos: user y null. No se recogen del formulario
    function getRol() {
        return $this->rol;
    }

    function getImagen() {
        return $this->imagen;
    }

    function setId($id) {
        $this->id = $id;
    }

    //real_escape_string — Protege caracteres especiales en una cadena para
    //ser usada en una sentencia SQL, tomando en cuenta el conjunto de caracteres para la conexión
    //para escapar los caracteres especiales del campo que procede del formulario, que son 
    //los campos que recogen los getters
    //esto se hace por si el usuario escribe en el formulario alguna barbaridad
    //del tipo de algunos caracteres especiales
    function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
	}

    function setApellidos($apellidos) {
		$this->apellidos = $this->db->real_escape_string($apellidos);
	}

    function setEmail($email) {
		$this->email = $this->db->real_escape_string($email);
	}

    function setPassword($password) {
        $this->password = $password;
    }

    function setRol($rol) {
        $this->rol = $rol;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    //Método para guardar objetos de usuario en la bbdd
    //Al método le llamo save
    //Database proviene de config/db.php, que hemos metido con require en le index
    public function save() {
        //el campo del rol se rellena con 'user' y la imagen a null
        $sql = "INSERT INTO usuarios VALUES(NULL, '{$this->getNombre()}','{$this->getApellidos()}','{$this->getEmail()}','{$this->getPassword()}','user',null)";
        $save = $this->db->query($sql);

        //Para comprobar si la query ha ido bien o no
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }
    
    public function login(){
        $result = false;
        //Obtener email y password a través de los getters
        $email = $this->email;
        $password = $this->password;
        
        //Comprobar si existe el usuario
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $login = $this->db->query($sql);
        
        //si existe el email y sólo hay una fila
        if($login && $login->num_rows == 1) {
            //recoger resultado de la consulta
            $usuario = $login->fetch_object();
        
            //Verificar la contraseñaCreo una variable que llamo $verify. Ojo 
            //que la contraseña está encriptada. Hay que desencriptarla.
            //$usuario->password es la password guardada en la BBDD
            
            $verify = password_verify($password, $usuario->password);
            
            if($verify){
                $result = $usuario;//esta variable contiene el resulatdo de la consulta a BBDD
            }
        }
        return $result;
    }
        
}


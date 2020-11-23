<?php

function controllers_autoload($classname){
    //Esto entra en la carpeta de controladores del proyecto y hace include de sus elementos
	include 'controllers/' . $classname . '.php';
}

spl_autoload_register('controllers_autoload');


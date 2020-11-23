<?php

/* 
 Creamos en este fichero parámetros que utilizamos a lo largo
 de todo el proyecto. Los nombres de las constantes están en inglés por convenio,
 * pero podríamos poner el nombre que queramos. por ejemplo, en lugar de
 * "controller_default", podríamos poner "controlador_defecto", pero el profe lo pone así
 */

//Definimos constante que sustituya a la url base por la cte "base_url"
//ESto lo hacemos para hacer las urls más cortas, más "amigables", 
//con lo que mejora sustancialemente el SEO
define("base_url", "http://localhost/Masterphp/08-tienda-camisetas/");

//Controlador por defecto: va a ser el de producto
define("controller_default", "productoController");

//Una constante que sustituya a la acción por defecto 
define("action_default", "index");



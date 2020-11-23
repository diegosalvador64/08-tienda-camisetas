<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Tienda de Camisetas</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url ?>assets/css/styles.css" />

    </head>   
    <body>
        <!-- CABECERA -->
        <header id="header">
            <div id="logo">
                <img src="<?= base_url ?>assets/img/camiseta.png" alt="camiseta logo"/>
                <a href="<?= base_url ?>">Tienda de camisetas</a>
            </div>
        </header>
        <!-- MENÚ -->
        <?php $categorias = Utils::showCategorias(); //devuelve array con todas las categorias ?>
        <nav id="menu">
            <ul>
                <li>
                    <a href="<?= base_url ?>">Inicio</a>
                </li>
                <?php while ($cat = $categorias->fetch_object()): ?>
                    <li>
                        <a href="<?= base_url?>categoria/ver&id=<?=$cat->id?>"><?=$cat->nombre?></a>
                    </li>
                <?php endwhile; ?>
            </ul>

        </nav>

        <div id="content">

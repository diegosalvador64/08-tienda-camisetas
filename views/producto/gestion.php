<h1>Gestión de productos</h1>

<a href="<?=base_url?>producto/crear" class="button button-small">
    Crear producto
</a>

<?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == 'complete'): ?>
	<strong class="alert_green">Producto se ha creado correctamente</strong>
<?php elseif(isset($_SESSION['producto']) && $_SESSION['producto'] == 'failed'): ?>
	<strong class="alert_red">Producto NO se ha creado correctamente</strong>
<?php endif; ?>
<!--Borrar las sesiones de producto utilizando la función deleteSession que hemos creado en utils.php-->        
<?php Utils::deleteSession('producto');?>

<?php if(isset($_SESSION['delete']) && $_SESSION['delete'] == 'complete'): ?>
	<strong class="alert_green">Producto se ha borrado correctamente</strong>
<?php elseif(isset($_SESSION['delete']) && $_SESSION['delete'] == 'failed'): ?>
	<strong class="alert_red">Producto NO se ha borrado</strong>
<?php endif; ?>
<!--Borrar las sesiones de producto utilizando la función deleteSession que hemos creado en utils.php-->        
<?php Utils::deleteSession('delete');?>

<table>
    <th>ID</th>
    <th>NOMBRE</th>
    <th>PRECIO</th>
    <th>STOCK</th>
    <th>ACCIONES</th>
    <?php while ($pro = $productos->fetch_object()): //$productos es la variable donde recogimos el SELECT de la tabla productos?>
        <tr>
            <td>
                <?= $pro->id; ?>
            </td>
            <td>
                <?= $pro->nombre; ?>
            </td>
            
            <td>
                <?= $pro->precio; ?>
            </td>
            <td>
                <?= $pro->stock; ?>
            </td>
            <td>
                <a href="<?=base_url?>producto/editar&id=<?=$pro->id?>" class="button button-gestion">Editar</a>
                <a href="<?=base_url?>producto/eliminar&id=<?=$pro->id?>" class="button button-gestion button-red">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>   
</table>


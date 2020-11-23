<h1>Gestionar categorías</h1>

<a href="<?=base_url?>categoria/crear" class="button button-small">
    Crear categoría
</a>
<table>
    <th>ID</th>
    <th>NOMBRE</th>
    <?php while ($cat = $categorias->fetch_object()): //$categorias es la variable donde recogimos el SELECT de la tabla categorias?>
        <tr>
            <td>
                <?= $cat->id; ?>
            </td>
            <td>
                <?= $cat->nombre; ?>
            </td>
        </tr>
    <?php endwhile; ?>   
</table>
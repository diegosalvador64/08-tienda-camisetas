
<?php if (isset($gestion)): ?>
    <h1>Gestionar pedidos</h1>
<?php else: ?>
    <h1>Mis pedidos</h1>
<?php endif; ?>

<table>
    <tr>
        <th>Nº Pedido</th>
        <th>Coste</th>
        <th>Fecha</th>
        <th>Estado</th>
    </tr>
    <!--Recorremos el array del carrito para mostrarlo, y la guardamos en la
    variable $producto -->
    <?php
    //La variable $pedidos viene del controlador y recoge el result set de la consulta a la bd
    //Esta es la variable que recorremos para obtener los datos que queremos
    while ($ped = $pedidos->fetch_object()):
        ?>
        <tr>
            <td>
                <a href="<?= base_url ?>pedido/detalle&id=<?= $ped->id ?>"><?= $ped->id ?></a>
            </td>
            <td>
                <?= $ped->coste ?> €
            </td>
            <td>
                <?= $ped->fecha ?>
            </td>
            <td>
                <?= Utils::showStatus($ped->estado)?>
            </td>

        </tr>
    <?php endwhile; ?>

</table>


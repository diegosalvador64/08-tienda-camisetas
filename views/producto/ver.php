<?php if (isset($product)): ?>
    <h1><?= $product->nombre ?></h1>
    <div id="detail-product">
        <div class="image">
            <?php if ($product->imagen != null): ?>
                <img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>"/>
            <?php else: //si no existe la imagen en la BBDD, ponemos una por defecto ?>
                <img src="<?= base_url ?>assets/img/camiseta.png"/>
            <?php endif; ?>
        </div>
        <div class="data">
            <p class="description"><?= $product->descripcion ?></p>
            <p class="price"><?= $product->precio ?>€</p>
            <!-- Al pulsar botón comprar, nos lleva al controlador de carrito, y al método add, para que añada al carrito-->
            <a href="<?=base_url?>carrito/add&id=<?=$product->id?>" class="button">Comprar</a>
        </div>
    </div>
<?php else: ?>
    <h1>El producto no existe</h1>
<?php endif; ?>


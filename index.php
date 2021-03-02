<?php
    include_once('header.php');
?>


<main>
    <div class="headline">Neu im Sortiment</div>

    <!-- Slider -->
    <div id="mainslider">
        <div style="background-image:url('image/product-Corsair.jpg')"></div>
        <div style="background-image:url('image/product-GSkill.jpg')"></div>
        <div style="background-image:url('image/product-rtx3090.jpg')"></div>
        <div style="background-image:url('image/product-Thermaltake.jpg')"></div> 
        <div style="background-image:url('image/product-seagateHDD.jpg')"></div>       
    </div>

    <!-- container -> Seitenbreite
    row -> Abstand oben und unten - geflext
    col -> Abstand zwischeneinander
    -->
    <div class="headline">Angebote des Tages</div>
    <div class="container">
        <div class="row">
            <!-- BILD
            NAME
            PREIS
            BUTTON -> in den Warenkorb
            -->

            <!-- datenbankverbindung aufbauen
            select all produkte
            id product 1, product 2 etc
            href = product.php/?id=1 -->

            <?php
                include_once('database/database_con.php');
                $select = 'SELECT * FROM product ORDER BY product_id DESC LIMIT 4';
                $result = $database->query($select);

                if($result->num_rows > 1) {
                    while($row = $result->fetch_assoc()) { ?>
                            <div id="product-<?php echo $row['product_id'] ?>" class="col-4">
                                <a href="product.php?productid=<?php echo $row['product_id'] ?>"><img src="image/<?php echo $row['product_image'] ?>"></a>
                                <h3><?php echo $row['product_name'] ?></h3>
                                <p>€ <?php echo $row['product_price'] ?><p>
                                <div class="button tocart" data-id="<?php echo $row['product_id']?>">In den Warenkorb</div>
                            </div>
                        <?php
                    }
                }
                $database->close();
            ?>
        </div>
    </div>
</main>

<?php
    include_once('footer.php');
?>

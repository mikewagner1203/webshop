<?php
    include_once('header.php');
?>

<main>
    <div class="headline">Produktbeschreibung</div>
    <?php


        /*datenbankverbindung
        Produkt mit dieser ID holen
        und ausgeben */
        include_once('database/database_con.php');
        $select ='SELECT * FROM product WHERE product_id='.$_GET['productid'];
        $result = $database->query($select);

        if($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { ?>
                <div id="productView">
                    <div id="productImage">
                        <h3>ART.NR:<?php echo $row['product_id'] ?></h3>
                        <h3><?php echo $row['product_name'] ?></h3>
                        <img src="image/<?php echo $row['product_image'] ?>">
                    </div>
                    <div id="productDetail">
                        <h3>Produkt-Details</h3>
                        <p><?php echo $row['product_description'] ?></p>
                        <div id=addToCart>
                            <p>€ <?php echo $row['product_price'] ?><p>
                            <div class="button tocart" data-id="<?php echo $row['product_id']?>">In den Warenkorb</div>
                        </div>         
                    </div>
                </div>
                <?php
            }
        }
        $database->close();

    ?>
    <!--
        Titel
        Ansicht
        Preis
        Beschreibung
        Button-> Warenkorb
    -->
    <div id="advertisments">
        <img src="image/lieferung.jpg">
        <img src="image/topseller.jpg">
        <img src="image/gutschein.jpg">
    </div>
</main>

<?php
    include_once('footer.php');
?>

<?php
    include_once('header.php');
?>

<main>
    <!--
        Überschrift
        Produkte -> mind 4 produkte -col-4 
    -->
    <div class="container">
        <div class="headline">Unser Angebot</div>
        <div class="row">   
            <?php
                include_once('database/database_con.php');
                $select = 'SELECT * FROM product ORDER BY product_id';
                $result = $database->query($select);

                if($result->num_rows > 1) {
                    while($row = $result->fetch_assoc()) { ?>
                            <div id="product-<?php echo $row['product_id'] ?>" class="col-4">
                                <a href="product.php?productid=<?php echo $row['product_id'] ?>"><img src="image/<?php echo $row['product_image'] ?>"></a>
                                <h3><?php echo $row['product_name'] ?></h3>
                                <p>€ <?php echo $row['product_price'] ?><p>
                                <div class="button tocart"data-id="<?php echo $row['product_id']?>">In den Warenkorb</div>
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
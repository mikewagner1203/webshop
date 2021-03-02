<?php
    include_once('header.php');
?>
<main>
    <!--
        Titel
        Übersicht über artikel -> LocalStorage
        löschen der Artikel
        warenkorb löschen button
        checkoutbutton
    -->

    <div class="headline">Ihr Warenkorb</div>
    <div id="cartView">
        <div id="itemList">

        </div>
        <div id="emptyCart">Ihr Warenkorb ist leer</div>
        <div id=totalAmount>
            <div id="netto"></div>
            <div id="ust"></div>
            <div id="sum"></div>
        </div>
    </div>

    <img id="preloader" width="32" height="32" src="style/images/bx_loader.gif" alt="preloader"/>
    <div id="cartActions">
        <div id="update_cart" class="button">Warenkorb aktualisieren</div>
        <div id="delete_cart" class="button">Warenkorb leeren</div>
        <div id="to_checkout" class="button">Jetzt kaufen</div>
    </div>

    <div id="advertisments">
        <img src="image/lieferung.jpg">
        <img src="image/topseller.jpg">
        <img src="image/gutschein.jpg">
    </div>
</main>


<?php
    include_once('footer.php');
?>
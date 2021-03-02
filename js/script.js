$(document).ready(function() {
    let sum;

    if($('#mainslider').length) {
        $('#mainslider').bxSlider({
            pager : false,
            controls : false,
            speed: 400,
            auto: true
        });

    }

    if(localStorage.getItem('cart')) {
        let cart = JSON.parse(localStorage.getItem('cart'));
        if(cart[0] > 0){
            $('#cartnumber').text(cart[0]);
        }
    }

    $(window).scroll(function() {
        if($(window).scrollTop() > 47.34) {
            $('header').addClass('sticky');
            $('#logo').addClass('sticky');
        } else {
            $('header').removeClass('sticky');
            $('#logo').removeClass('sticky');

        }
    });

    if($('#cartView').length) {

        if(localStorage.getItem('cart')) {
            $('#preloader').css('display', 'block');
            $('#emptyCart').css('display', 'none');
            $('#cartView').css('display', 'none');
            $('#totalAmount').css('display', 'flex');

            let productIDs = {products: localStorage.getItem('cart')};
            

            $.ajax({
                type: 'POST',
                url: 'database/get_cart_products.php',
                data: productIDs,
                success: function(data) {
                    data = JSON.parse(data);
                    let productLS = JSON.parse(localStorage.getItem('cart'));
                    sum = 0;
                    
                    // alle Produkte zum Warenkorb hinzufügen
                    // $(container) = <div>;
                    // $container += 
                    // entweder einen langen string erstellen oder einen "jquery-container" erstellen und die elemente appenden

                    for(let value in data) {
                        let items="<div class='cart_products'>";
                        let quantity = productLS[value];

                        items+= "<div data-id='" + data[value]['product_id'] + "' data-price='"+ data[value]['product_price'] + "' class='deleteItem'>x</div>";
                        items+= "<img class='img' src='image/" + data[value]['product_image'] + "'>" + "</img>";
                        items+= "<div class='name'>" + data[value]['product_name'] + "</div>";
                        items+= "<input class='amount' type='number' min='0' value ='" + productLS[value] + "'>";
                        items+= "<div class='price'>" + "€ " + data[value]['product_price'] + "</div>";
                        items+= "<div class='sum'>" + "€ " + (data[value]['product_price'] * quantity).toFixed(2) + "</div>";
                        items+= "</div>";

                        $("#itemList").append(items);
                        sum += data[value]['product_price'] * quantity;
                    }

                    $("#sum").append("€ " + sum);

                    $('.deleteItem').unbind().click(function(){ //.unbind() oder.off() werden alle eventListener aufgehoben wenn funktionen öfter aufgerufen werden.
                        //Product aus dem HTML löschen.
                        $(this).parent().remove();
                        deleteProduct($(this).data('id'),$(this).data('price'));

                    });

                    $('#netto').text('Nettobetrag: € ' + (sum/1.2).toFixed(2));
                    $('#ust').text('Umsatzsteuer: € ' + (sum/6).toFixed(2));
                    $('#sum').text('Gesamtsumme: € ' + (sum).toFixed(2));

                    $('#preloader').css('display', 'none');
                    $('#cartView').fadeIn();

                },
                error: function() {

                }
            });
        }
    }

    function deleteProduct(productID, product_price) {
        
        let productArray = JSON.parse(localStorage.getItem('cart'));
        productArray[0] -= productArray[productID]; 

        let curSum = sum - product_price * productArray[productID];
        $('#sum').text('€ ' + curSum);

        $('#netto').text('€ ' + (curSum/1.2).toFixed(2));
        $('#ust').text('€ ' + (curSum/6).toFixed(2));
        $('#sum').text('€ ' + curSum.toFixed(2));

        if(productArray.length - 1 == productID) {
            productArray.pop();
            while(productArray.length - 1 == null) {
                productArray.pop();
            }

        } else {
            productArray[productID] = null;
        }

        localStorage.setItem('cart', JSON.stringify(productArray));

        if(productArray[0] == 0) {
            cartIsEmpty();
        }

        // wenn keine Producte vorhanden dann warenkorb ist leer 
        // Menge in Topbar anpassen

        $('#cartnumber').text(productArray[0]);
    }

    function cartIsEmpty() {
        $('#emptycart').css('display', 'tablerow');
        localStorage.removeItem('cart');
        $('#totalAmount').css('display', 'none');
        $('#cartnumber').text('');
        $('#netto').text('€ 00.00');
        $('#ust').text('€ 00.00');
        $('#sum').text('€ 00.00');
    }

    $('#delete_cart').click(function() {
        cartIsEmpty();
        $('.cart_products').remove();

    });

    $('.tocart').click(function() {
        console.log('tocart');

        //setItem
        //productarray key -> value
        //JSON
        let productarray = [];
        // Aufgabe- cart.php
        // produkte die im LocalStorage stehen anzeigen
        // aus der Datenbank

        //[1] = 1
        if(localStorage.getItem('cart')) {
            productarray = JSON.parse(localStorage.getItem('cart'));
            console.log(productarray);

            if(productarray[$(this).data('id')]){
                productarray[$(this).data('id')] = productarray[$(this).data('id')] + 1;
            } else {
                productarray[$(this).data('id')] = 1;
            }
            productarray[0] = productarray[0] + 1;
        } else {
            productarray[$(this).data('id')] = 1;
            productarray[0] = 1;
        }

        //wenn null werte nicht erwünscht sind dann müsste man es in ein objekt umwandeln.
        $('#cartnumber').text(productarray[0]);

        localStorage.setItem('cart', JSON.stringify(productarray));
    });

    $('#update_cart').click(function() {
        let productArray = JSON.parse(localStorage.getItem('cart'));
        let quantity = 0;
        // [] --> Gesamtmenge aktualisieren
        // [1-z] --> Menge aktualisieren
        // Mengen die 0 zeigen werden gelöscht ( auf Null setzen)
        // aktueller value vom Input

        $('.cart_products').each(function() {
            // product ID
            // value
            console.log($(this).find('.deleteItem').data('id'));

            let newQuantity = $(this).find('input').val();
            let productID = $(this).find('.deleteItem').data('id');

            if(newQuantity > 0) {
                productArray[productID] = parseFloat(newQuantity);
                quantity += parseFloat(newQuantity);
            } else {
                productArray[productID] = null;
            }

        });

        productArray[0] = quantity;

        // while(productArray[productArray.length - 1] == null) {
        //     productArray.pop();
        // }

        localStorage.setItem('cart', JSON.stringify(productArray));

        // refresh
        location.reload();
    });
});
<?php
    $productids = json_decode($_POST['products']);

    //Datenbank Aufbau
    include_once('database_con.php');


    //array iterierung -> alle Producte mit den IDs vom Array.
    $select = 'SELECT * FROM product WHERE product_id in (';

    for($i = 1; $i < count($productids); $i++) {
        if($i == count($productids) - 1) {
            $select .=$i;
        }else if($productids[$i]) {
            $select .= $i . ",";
        }
    }
    $select.= ')';
    $result = $database->query($select);

    $products = [];

    if($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) {
            $products[$row['product_id']] = $row;
        }
    }

    echo json_encode($products);

    $database->close();
    

?>
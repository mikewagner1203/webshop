<?php
    $database = new mysqli("localhost", "root", "", "webshop");
    if($database->connect_errno) {
        printf("Verbindung fehlgeschlagen".$database->connect_error); 
        exit();
    }
?>
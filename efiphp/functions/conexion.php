<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($servername, $username, $password, "php_efi");

    if(!$conn){
       echo "no hay conexion bd";
    }

?>

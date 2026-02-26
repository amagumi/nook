<?php
$host = "localhost";
$user = "root"; // usuario por defecto de XAMPP
$pass = "";     // contraseña por defecto de XAMPP
$db   = "nook";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}else{
    echo "conectado a la db";
}
?>
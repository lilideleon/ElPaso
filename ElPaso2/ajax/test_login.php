<?php 
session_start();
require_once "../modelos/Usuario.php";

// Test con datos de ejemplo
$logina = "admin"; // Cambia esto por un usuario real
$clavea = "admin"; // Cambia esto por la contraseña real

echo "=== TEST DE LOGIN ===<br><br>";

$usuario = new Usuario();
$clavehash = hash("SHA256", $clavea);

echo "Usuario: " . $logina . "<br>";
echo "Clave original: " . $clavea . "<br>";
echo "Clave hash: " . $clavehash . "<br><br>";

$rspta = $usuario->verificar($logina, $clavehash);
echo "Resultado de verificar(): ";
var_dump($rspta);
echo "<br><br>";

if ($rspta) {
    echo "Número de filas: " . $rspta->num_rows . "<br><br>";
    
    $fetch = $rspta->fetch_object();
    echo "Fetch object: ";
    var_dump($fetch);
    echo "<br><br>";
    
    if ($fetch) {
        echo "Usuario encontrado!<br>";
        echo "ID: " . $fetch->idusuario . "<br>";
        echo "Nombre: " . $fetch->nombre . "<br>";
        echo "Login: " . $fetch->login . "<br>";
        echo json_encode($fetch);
    } else {
        echo "No se encontró usuario<br>";
        echo json_encode(null);
    }
} else {
    echo "Error en la consulta<br>";
}
?>

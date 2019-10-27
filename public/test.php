<?php
$host = 'LRTdocker-mysql'; 
$user = 'root'; 
$pass = 'root'; 
$db = 'wallet'; 
try {
    $mbd = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    var_dump($mbd);
    foreach($mbd->query('SELECT * from users') as $fila) {
        var_dump($fila);
    }
    $mbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=gestionresto', 'root', '0000');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
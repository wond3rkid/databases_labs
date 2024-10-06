<?php
$host = 'localhost';
$dbname = 'university';
$user = 'root';
$password = '1326';
function getPDO()
{
    $host = 'localhost';
    $dbname = 'university';
    $user = 'root';
    $password = '1326';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
}

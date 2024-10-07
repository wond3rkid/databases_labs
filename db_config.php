<?php
$host = 'localhost';
$dbname = 'university';
$user = 'root';
$password = '1326';

function getPDO() {
    global $host, $dbname, $user, $password;
    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
}

function clearAndInitDB()
{
    $pdo = getPDO();
    try {
        $pdo->exec("DROP DATABASE IF EXISTS `university`");
        $pdo->exec("CREATE DATABASE `university`");
        $pdo->exec("USE university");

        $pdo->exec("CREATE TABLE students (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            patronymic VARCHAR(255),
            birth_day DATE,
            birth_place VARCHAR(255),
            email VARCHAR(255),
            phone_number VARCHAR(20),
            gpa FLOAT,
            group_id INT CHECK(group_id > 0)
        )");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

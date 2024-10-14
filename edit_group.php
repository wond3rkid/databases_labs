<?php
require 'db_config.php';
$pdo = getPDO();

$group_id = isset($_GET['id'])? $_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM classes WHERE id = :id");
$stmt->execute(['id' => $group_id]);
$group = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$group) {
    echo "Ошибка. Студент не найден в базе данных";
    exit(0);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_name = $_POST['group_name'];

}
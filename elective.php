<?php
require 'db_config.php';

$pdo = getPDO();

$curr_elective_id = isset($_GET['id']) ? $_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT * FROM electives WHERE id = :id');
$stmt->execute(['id' => $curr_elective_id]);
$elective = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$elective) {
    echo 'Ошибка: факультатив не найден';
    exit();
}

$elective_id = $elective['id'];
?>

<!DOCTYPE html>
<link href="styles/group.css" rel="stylesheet" type="text/css">
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title><?=htmlspecialchars($elective['elective_name'])?></title>
</head>
<body>
<h2>Информация о факультативе</h2>

<p> <?= htmlspecialchars($elective['description']); ?></p>
<p> Количество мест на курсе:  <?= htmlspecialchars($elective['capacity']); ?> </p>

<a href="electives.php">Назад к списку факультативов<br></a>
<a href="index.php">Назад на главную</a>
</body>
</html>
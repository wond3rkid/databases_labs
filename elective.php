<?php
require 'db_config.php';

$pdo = getPDO();

$curr_elective_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT * FROM electives WHERE id = :id');
$stmt->execute(['id' => $curr_elective_id]);
$elective = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$elective) {
    exit('Ошибка: факультатив не найден');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($elective['elective_name']) ?></title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h2>Информация о факультативе</h2>
</header>

<main>
    <p><?= htmlspecialchars($elective['description']); ?></p>
    <p>Количество мест на курсе: <?= htmlspecialchars($elective['capacity']); ?></p>

    <nav>
        <a href="electives.php">Назад к списку факультативов</a><br>
        <a href="index.php">Назад на главную</a>
    </nav>
</main>
</body>
</html>

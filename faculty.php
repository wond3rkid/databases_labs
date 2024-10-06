<?php
require 'db_config.php';

$pdo = getPDO();

$faculty_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT * FROM faculties WHERE id = :id');
$stmt->execute(['id' => $faculty_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$faculty) {
    echo 'Ошибка: факультет не найден';
    exit();
}

?>
<!DOCTYPE html>
<!DOCTYPE html>
<link href="styles/big_tables_page.css" rel="stylesheet" type="text/css">
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title>Факультет</title>
</head>
<body>
<h2>Информация о факультете</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Название</th>
    </tr>
    <tr>
        <th><?= htmlspecialchars($faculty['id']) ?></th>
        <th><?= htmlspecialchars($faculty['faculty_name']) ?></th>
    </tr>
</table>
<br>

<table>
    <tr>
        <th>Список групп</th>
    </tr>
    <tr>
        <th>Группа 1</th>
    </tr>
</table>
<br>
<a href="faculties.php">Назад к списку факультетов<br></a>
<a href="index.php">Назад на главную</a>
</body>
</html>

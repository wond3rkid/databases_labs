<?php
require 'db_config.php';

$pdo = getPDO();

$curr_faculty_id= isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pdo->exec('use university');
$stmt = $pdo->prepare('SELECT * FROM faculties WHERE id = :id');
$stmt->execute(['id' => $curr_faculty_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$faculty) {
    echo 'Ошибка: факультет не найден';
    exit();
}
$faculty_id = $faculty['id'];
$stmt = $pdo->prepare('SELECT group_name FROM classes WHERE faculty_id = :id');
$stmt->execute(['id' => $curr_faculty_id]);
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<!DOCTYPE html>
<link href="styles/faculty.css" rel="stylesheet" type="text/css">
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
        <td><?= htmlspecialchars($faculty['id']) ?></td>
        <td><?= htmlspecialchars($faculty['faculty_name']) ?></td>
    </tr>
</table>
<br>

<table>
    <tr>
        <th>Список групп</th>
    </tr>
    <?php foreach ($groups as $group): ?>
    <tr>
        <td><?=htmlspecialchars($group['group_name'])?> </td>
    </tr>
    <?php endforeach; ?>
</table>
<br>
<br>
<a href="faculties.php">Назад к списку факультетов<br></a>
<a href="index.php">Назад на главную</a>
</body>
</html>

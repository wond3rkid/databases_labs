<?php
require 'db_config.php';

try {
    $pdo = getPDO();
    $stmt = $pdo->query("
        SELECT classes.id, faculties.faculty_name AS faculty_name, classes.group_name 
        FROM classes JOIN faculties ON classes.faculty_id = faculties.id
    ");
    $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error getting data: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title>Список групп</title>
    <link href="styles/groups.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>Списки групп</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Факультет</th>
        <th>Группа</th>
    </tr>
    <?php foreach ($groups as $group) : ?>
        <tr>
            <td><?= htmlspecialchars($group['id']); ?></td>
            <td><?= htmlspecialchars($group['faculty_name']) ?></td>
            <td><?= htmlspecialchars($group['group_name']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="index.php">Назад на главную</a>
</body>
</html>
<?php
require 'db_config.php';

try {
    $pdo = getPDO();
    $stmt = $pdo->query("
        SELECT classes.id, faculties.faculty_name AS faculty_name, classes.group_name 
        FROM classes 
        JOIN faculties ON classes.faculty_id = faculties.id
    ");
    $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit("Ошибка при получении данных: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список групп</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h1>Список групп</h1>
</header>

<main>
    <p>Для просмотра полной информации о группе нажмите на её ID.</p>
    <table class="faculties-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Факультет</th>
            <th>Группа</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($groups as $group): ?>
            <tr>
                <td>
                    <a href="group.php?id=<?= htmlspecialchars($group['id']); ?>">
                        <?= htmlspecialchars($group['id']); ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($group['faculty_name']); ?></td>
                <td><?= htmlspecialchars($group['group_name']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <a href="index.php">Назад на главную</a>
    </nav>
</main>
</body>
</html>

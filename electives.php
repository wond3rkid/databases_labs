<?php
require 'db_config.php';

try {
    $pdo = getPDO();
    $stmt = $pdo->query('SELECT * FROM electives');
    $electives = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Ошибка при получении данных: " . htmlspecialchars($e->getMessage());
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список факультативов</title>
    <!-- TODO styles -->
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h1>Список факультативов университета</h1>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Вместимость</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($electives as $elective): ?>
            <tr>
                <td>
                    <a href="elective.php?id=<?= htmlspecialchars($elective['id']) ?>">
                        <?= htmlspecialchars($elective['id']) ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($elective['elective_name']) ?></td>
                <td><?= htmlspecialchars($elective['capacity']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="index.php">Назад на главную</a>
</main>
<footer>
</footer>
</body>
</html>

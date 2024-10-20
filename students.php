<?php
require 'db_config.php';

try {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM students");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error retrieving students: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список студентов</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<header>
    <h1>Список студентов</h1>
</header>
<main>
    <article>
        <p>Для просмотра полной информации о студенте нажмите на его ID.</p>
        <table class="students-table">
            <tr>
                <th>Номер</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Отчество</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td>
                        <a href="student.php?id=<?= htmlspecialchars($student['id']); ?>">
                            <?= htmlspecialchars($student['id']); ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($student['first_name']); ?></td>
                    <td><?= htmlspecialchars($student['last_name']); ?></td>
                    <td><?= htmlspecialchars($student['patronymic']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </article>
</main>
<footer>
    <a href="index.php">Назад на главную</a>
</footer>
</body>
</html>

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title>Список студентов</title>
    <link href="styles/students.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>Список студентов</h1>
<p>Для просмотра полной информации о студенте нажмите на его ID.</p>
<br>
<table>
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
<br>
<a href="index.php">Назад на главную</a>
</body>
</html>

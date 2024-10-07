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
<link href="styles/students.css" rel="stylesheet" type="text/css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title>Список студентов</title>
</head>
<body>
<div>
    <h1>Список студентов</h1>
    <a>Для просмотра полной информации о студенте нажмите на его id. <br></a>
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
                    <a href="student.php?id=<?= htmlspecialchars($student['id']); ?>"><?= htmlspecialchars($student['id']); ?>
                </td>
                <td><?= htmlspecialchars($student['first_name']); ?></a></td>
                <td><?= htmlspecialchars($student['last_name']); ?></td>
                <td><?= htmlspecialchars($student['patronymic']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="index.php"><br> Назад на главную</a>
</div>
</body>
</html>

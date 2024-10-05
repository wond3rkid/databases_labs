<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=university', 'root', '1326');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query('SELECT * FROM students');
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Ошибка: ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<link href="styles/table_page.css" rel="stylesheet" type="text/css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title>Список студентов</title>
</head>
<body>
<h1>Список студентов</h1>
<a>Для просмотра полной информации о студенте нажмите на его id.</a>
<br>
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
            <td><a href="student.php?id=<?= htmlspecialchars($student['id']); ?>"><?= htmlspecialchars($student['id']); ?></td>
            <td><?= htmlspecialchars($student['first_name']); ?></a></td>
            <td><?= htmlspecialchars($student['last_name']); ?></td>
            <td><?= htmlspecialchars($student['patronymic']); ?></td>
        </tr>
    <?php endforeach; ?>


</table>
<a href="index.php"><br> Назад на главную</a>
</body>
</html>

<?php
require 'db_config.php';

$pdo = getPDO();

$student_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT * FROM students WHERE id = :id');
$stmt->execute(['id' => $student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$student) {
    echo "Ошибка: студент не был найден в базе данных";
    exit();
}
$group_id = $student['group_id'];
$stmt = $pdo->prepare('SELECT faculty_name FROM faculties JOIN classes ON faculties.id = classes.faculty_id WHERE classes.id = :group_id');
$stmt->execute(['group_id' => $group_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<link href="styles/student.css" rel="stylesheet" type="text/css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title>Информация о студенте</title>
</head>
<body>
<h1>Информация о студенте</h1>

<table>
    <tr>
        <th>ID студента</th>
        <td><?= htmlspecialchars($student['id']); ?></td>
    </tr>
    <tr>
        <th>Имя</th>
        <td><?= htmlspecialchars($student['first_name']); ?></td>
    </tr>
    <tr>
        <th>Фамилия</th>
        <td><?= htmlspecialchars($student['last_name']); ?></td>
    </tr>
    <tr>
        <th>Отчество</th>
        <td><?= htmlspecialchars($student['patronymic']); ?></td>
    </tr>
    <tr>
        <th>Дата рождения</th>
        <td><?= htmlspecialchars($student['birth_day']); ?></td>
    </tr>
    <tr>
        <th>Место рождения</th>
        <td><?= htmlspecialchars($student['birth_place']); ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?= htmlspecialchars($student['email']); ?></td>
    </tr>
    <tr>
        <th>Телефон</th>
        <td><?= htmlspecialchars($student['phone_number']); ?></td>
    </tr>
    <tr>
        <th>Средний балл</th>
        <td><?= htmlspecialchars($student['gpa']); ?></td>
    </tr>
    <tr>
        <th>ID группы</th>
        <td>
            <a href="group.php?id=<?= htmlspecialchars($student['group_id']); ?>">
                <?= htmlspecialchars($student['group_id']); ?>
            </a>
        </td>
    </tr>
    <tr>
        <th>Факультет</th>
        <td><?= htmlspecialchars($faculty['faculty_name']); ?></td>
    </tr>
</table>

<br>
<a href="edit_student.php?id=<?= htmlspecialchars($student['id']); ?>">Редактировать информацию о студенте</a>
<br>
<br>
<a href="students.php">Назад к списку студентов</a>
<br>
<a href="group.php?id=<?= htmlspecialchars($student['group_id']); ?>">Назад к группе</a>
</body>
</html>

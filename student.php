<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=university', 'root', '1326');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $student_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = :id');
    $stmt->execute(['id' => $student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        throw new Exception('Студент не найден');
    }
} catch (PDOException $e) {
    echo 'Ошибка: ' . $e->getMessage();
    exit();
} catch (Exception $e) {
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
    <title>Информация о студенте</title>
</head>
<body>
<h1>Информация о студенте</h1>

<table border="1">
    <tr>
        <th>ID</th>
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
        <th>GPA</th>
        <td><?= htmlspecialchars($student['gpa']); ?></td>
    </tr>
    <tr>
        <th>Группа</th>
        <td><?= htmlspecialchars($student['group_id']); ?></td>
    </tr>
</table>

<br>
<a href="edit_student.php?id=<?= htmlspecialchars($student['id']); ?>">Редактировать</a>
<br>
<a href="index.php">Назад к списку студентов</a>
</body>
</html>

<?php
require 'db_config.php';

$pdo = getPDO();

$stmt = $pdo->prepare('
    SELECT student_elective.*, students.first_name, students.last_name, electives.elective_name
    FROM student_elective
    JOIN students ON student_elective.student_id = students.id
    JOIN electives ON student_elective.elective_id = electives.id
');
$stmt->execute();
$enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['delete_enrollment_id'])) {
    $delete_enrollment_id = (int)$_GET['delete_enrollment_id'];
    $deleteStmt = $pdo->prepare('DELETE FROM student_elective WHERE id = :id');
    $deleteStmt->execute(['id' => $delete_enrollment_id]);

    header("Location: faculty_enrollments.php");
    exit;
}

$stmt = $pdo->prepare('SELECT id, first_name, last_name FROM students');
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT id, elective_name FROM electives');
$stmt->execute();
$electives = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['student_id']) && isset($_POST['elective_id'])) {
    $student_id = (int)$_POST['student_id'];
    $elective_id = (int)$_POST['elective_id'];

    $insertStmt = $pdo->prepare('INSERT INTO student_elective (student_id, elective_id, enrollment_date) VALUES (:student_id, :elective_id, NOW())');
    $insertStmt->execute(['student_id' => $student_id, 'elective_id' => $elective_id]);

    header("Location: faculty_enrollments.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Записи на факультативы</title>
    <link href="styles/add.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h1>Записи на факультативы</h1>
</header>
<h2>Записать студента на факультатив</h2>
<nav>
    <a href="add_student_to_elective.php" class="add-student-btn">Добавить студента на факультатив</a>
</nav>
<br>

<main>
    <h2>Список записей</h2>
    <table class="enrollments">
        <thead>
        <tr>
            <th>Имя студента</th>
            <th>Фамилия студента</th>
            <th>Электив</th>
            <th>Дата записи</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($enrollments as $enrollment): ?>
            <tr>
                <td><?= htmlspecialchars($enrollment['first_name']); ?></td>
                <td><?= htmlspecialchars($enrollment['last_name']); ?></td>
                <td><a href="elective.php?id=<?= $enrollment['elective_id']; ?>"><?= htmlspecialchars($enrollment['elective_name']); ?></a></td>
                <td><?= htmlspecialchars($enrollment['enrollment_date']); ?></td>
                <td>
                    <a class="delete-link" href="faculty_enrollments.php?delete_enrollment_id=<?= $enrollment['id']; ?>">Удалить</a>
                    <a href="student.php?id=<?= $enrollment['student_id']; ?>">Перейти к студенту</a>
                </td>
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

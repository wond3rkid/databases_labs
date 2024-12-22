<?php
require 'db_config.php';

$pdo = getPDO();

$curr_elective_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare('SELECT * FROM electives WHERE id = :id');
$stmt->execute(['id' => $curr_elective_id]);
$elective = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$elective) {
    exit('Ошибка: факультатив не найден');
}

if (isset($_POST['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM student_elective WHERE elective_id = :elective_id');
    $stmt->execute(['elective_id' => $curr_elective_id]);

    $stmt = $pdo->prepare('DELETE FROM electives WHERE id = :id');
    $stmt->execute(['id' => $curr_elective_id]);

    header('Location: electives.php');
    exit();
}

$stmt = $pdo->prepare('
    SELECT students.id, students.first_name, students.last_name 
    FROM students 
    JOIN student_elective ON students.id = student_elective.student_id 
    WHERE student_elective.elective_id = :elective_id');
$stmt->execute(['elective_id' => $curr_elective_id]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($elective['elective_name']) ?></title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h2>Информация о факультативе</h2>
</header>

<main>
    <p><?= htmlspecialchars($elective['description']); ?></p>
    <p>Количество мест на курсе: <?= htmlspecialchars($elective['capacity']); ?></p>

    <h3>Студенты, записанные на факультатив:</h3>
    <table class="student-table">
        <thead>
        <tr>
            <th>ID студента</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['id']) ?></td>
                <td><?= htmlspecialchars($student['first_name']) ?></td>
                <td><?= htmlspecialchars($student['last_name']) ?></td>
                <td><a href="student.php?id=<?= htmlspecialchars($student['id']) ?>">Просмотр</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Форма для удаления факультатива -->
    <form method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить факультатив? Все записи студентов будут удалены.')">
        <button type="submit" name="delete" class="db_button">Удалить факультатив</button>
    </form>

    <nav>
        <a href="electives.php">Назад к списку факультативов</a><br>
        <a href="index.php">Назад на главную</a>
    </nav>
</main>
</body>
</html>

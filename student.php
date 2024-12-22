<?php
require 'db_config.php';

$pdo = getPDO();

$student_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare('SELECT * FROM students WHERE id = :id');
$stmt->execute(['id' => $student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    exit("Ошибка: студент не был найден в базе данных");
}

$group_id = $student['group_id'];

$stmt = $pdo->prepare('SELECT faculty_name FROM faculties JOIN classes ON faculties.id = classes.faculty_id WHERE classes.id = :group_id');
$stmt->execute(['group_id' => $group_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('
    SELECT electives.elective_name, electives.id AS elective_id, student_elective.enrollment_date
    FROM electives
    JOIN student_elective ON electives.id = student_elective.elective_id
    WHERE student_elective.student_id = :student_id
');
$stmt->execute(['student_id' => $student_id]);
$electives = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT head_id FROM classes WHERE id = :group_id');
$stmt->execute(['group_id' => $group_id]);
$group = $stmt->fetch(PDO::FETCH_ASSOC);

$is_head = $group['head_id'] == $student_id;

$error_message = '';

if (isset($_POST['delete_student'])) {
    if ($is_head) {
        $error_message = 'Нельзя удалить старосту группы.';
    } else {
        $stmt = $pdo->prepare('DELETE FROM students WHERE id = :id');
        $stmt->execute(['id' => $student_id]);

        $stmt = $pdo->prepare('DELETE FROM student_elective WHERE student_id = :student_id');
        $stmt->execute(['student_id' => $student_id]);

        header('Location: students.php');
        exit();
    }
}

if (isset($_GET['delete_elective_id'])) {
    $delete_elective_id = (int)$_GET['delete_elective_id'];

    $deleteStmt = $pdo->prepare('DELETE FROM student_elective WHERE student_id = :student_id AND elective_id = :elective_id');
    $deleteStmt->execute(['student_id' => $student_id, 'elective_id' => $delete_elective_id]);

    header("Location: student.php?id=" . $student_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информация о студенте</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h1>Информация о студенте</h1>
</header>

<main>
    <?php if ($error_message): ?>
        <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <table class="student-table">
        <tbody>
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
        </tbody>
    </table>

    <h2>Элективы</h2>
    <?php if ($electives): ?>
        <ul>
            <?php foreach ($electives as $elective): ?>
                <li>
                    <?= htmlspecialchars($elective['elective_name']); ?>
                    (Дата записи: <?= htmlspecialchars($elective['enrollment_date']); ?>)
                    <a href="student.php?id=<?= $student_id; ?>&delete_elective_id=<?= $elective['elective_id']; ?>">Удалить</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Студент не записан на элективы.</p>
    <?php endif; ?>

    <nav>
        <form action="edit_student.php" method="GET">
            <input type="hidden" name="id" value="<?= htmlspecialchars($student['id']); ?>">
            <button type="submit" class="nav_button">Редактировать информацию о студенте</button>
        </form>
        <form action="add_elective.php" method="GET">
            <input type="hidden" name="student_id" value="<?= $student_id; ?>">
            <button type="submit" class="nav_button">Записаться на новый электив</button>
        </form>
        <form method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить студента?')">
            <button type="submit" name="delete_student" class="db_button">Удалить студента</button>
        </form>

        <br>
        <a href="students.php">Назад к списку студентов</a>
        <br>
        <a href="group.php?id=<?= htmlspecialchars($student['group_id']); ?>">Назад к группе</a>
    </nav>




</main>
</body>
</html>

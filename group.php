<?php
require 'db_config.php';

$pdo = getPDO();

$curr_group_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM classes WHERE id = :id");
$stmt->execute(['id' => $curr_group_id]);
$group = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$group) {
    exit('Ошибка: группа не найдена');
}

$smtm = $pdo->prepare("SELECT * FROM students WHERE group_id = :group_id");
$smtm->execute(['group_id' => $curr_group_id]);
$students = $smtm->fetchAll(PDO::FETCH_ASSOC);

$faculty_id = $group['faculty_id'];
$stmt = $pdo->prepare("SELECT * FROM faculties WHERE id = :faculty_id");
$stmt->execute(['faculty_id' => $faculty_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);

$error_message = '';
if (isset($_POST['delete_group'])) {
    if (count($students) > 0) {
        $error_message = 'Нельзя удалить группу, в которой есть студенты.';
    } else {
        $stmt = $pdo->prepare("DELETE FROM classes WHERE id = :id");
        $stmt->execute(['id' => $curr_group_id]);
        header('Location: groups.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информация о группе</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h1>Информация о группе</h1>
</header>

<main>
    <?php if ($error_message): ?>
        <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <p>Название группы: <?= htmlspecialchars($group['group_name']); ?></p>
    <p>Факультет: <a href="faculty.php?id=<?= htmlspecialchars($faculty_id); ?>"><?= htmlspecialchars($faculty['faculty_name']); ?></a></p>

    <h3>Список студентов:</h3>
    <br>
    <table class="student-group-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя и фамилия</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td>
                    <a href="student.php?id=<?= htmlspecialchars($student['id']); ?>">
                        <?= htmlspecialchars($student['id']); ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                <td><?php if ($student['id'] === $group['head_id']): ?>
                        <span>Староста</span>
                    <?php else: ?>
                        <span>Студент</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <form method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить группу?')">
        <button type="submit" name="delete_group" class="db_button">Удалить группу</button>
    </form>

    <br>
    <nav>
        <a href="groups.php">Назад к списку групп</a><br>
        <a href="index.php">Назад на главную</a>
    </nav>
</main>
</body>
</html>
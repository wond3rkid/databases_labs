<?php
require 'db_config.php';
$pdo = getPDO();

$curr_group_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM classes WHERE id = :id");
$stmt->execute(['id' => $curr_group_id]);
$group = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$group) {
    echo 'Ошибка: группа не найдена';
    exit();
}
$head_id = $group['head_id'];
$smtm = $pdo->prepare("SELECT * FROM students WHERE group_id = :group_id");
$smtm->execute(['group_id' => $curr_group_id]);
$students = $smtm->fetchAll(PDO::FETCH_ASSOC);
$faculty_id = $group['faculty_id'];
$stmt = $pdo->prepare("SELECT * FROM faculties WHERE id= :faculty_id");
$stmt->execute(['faculty_id' => $faculty_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<link href="styles/groups.css" rel="stylesheet" type="text/css">
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title>Группа</title>
</head>
<body>
<h1>Информация о группе</h1>

<p>Название группы: <?= htmlspecialchars($group['group_name']); ?></p>
<a>Факультет: </a>
<a href="faculty.php?id=<?= htmlspecialchars($faculty_id) ?>"><?=htmlspecialchars($faculty['faculty_name'])?>
</a>
<h2>Список студентов:</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Имя фамилия</th>
        <th>Статус</th>
    </tr>
    <?php foreach ($students as $student) : ?>
        <tr>
            <td>
                <a href="student.php?id=<?= htmlspecialchars($student['id']);?>">
                    <?=htmlspecialchars($student['id']); ?>
                </a>
            </td>
            <td><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
            <td><?php if ($student['id'] === $head_id):  ?>
                    <span>Староста</span>
                <?php else: ?>
                    <span>Студент</span>
                <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="groups.php">Назад к списку групп</a>
<br>
<a href="index.php">Назад на главную</a>

</body>
</html>

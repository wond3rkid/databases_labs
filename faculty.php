<?php
require 'db_config.php';

$pdo = getPDO();

// Получение идентификатора факультета с безопасным приведением типа
$curr_faculty_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare('SELECT * FROM faculties WHERE id = :id');
$stmt->execute(['id' => $curr_faculty_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);

// Проверка наличия факультета
if (!$faculty) {
    exit('Ошибка: факультет не найден');
}

// Получение списка групп, связанных с факультетом
$stmt = $pdo->prepare('SELECT id, group_name FROM classes WHERE faculty_id = :faculty_id');
$stmt->execute(['faculty_id' => $curr_faculty_id]);
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Факультет</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h2>Информация о факультете</h2>
</header>

<main>
    <p></p>
    <table class="faculties-table">
        <tr>
            <th>ID</th>
            <th>Название</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($faculty['id']); ?></td>
            <td><?= htmlspecialchars($faculty['faculty_name']); ?></td>
        </tr>
    </table>

    <br>

    <section>
        <h3>Список групп</h3>
        <table class="faculties-table">
            <?php foreach ($groups as $group): ?>
                <tr>
                    <td>
                        <a href="group.php?id=<?= htmlspecialchars($group['id']); ?>">
                            <?= htmlspecialchars($group['group_name']); ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <br>
    <nav>
        <a href="faculties.php">Назад к списку факультетов</a>
        <br>
        <a href="index.php">Назад на главную</a>
    </nav>
</main>
</body>
</html>

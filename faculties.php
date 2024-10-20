<?php
require 'db_config.php';

$pdo = getPDO();

$stmt = $pdo->query("SELECT * FROM faculties");
$faculties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список факультетов</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h1>Список факультетов</h1>
</header>

<main>
    <table>
        <thead>
        <tr>
            <th>Название</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($faculties as $faculty): ?>
            <tr>
                <td>
                    <a href="faculty.php?id=<?= htmlspecialchars($faculty['id']); ?>">
                        <?= htmlspecialchars($faculty['faculty_name']); ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <nav>
        <a href="index.php">Назад на главную</a>
    </nav>
</main>
</body>
</html>

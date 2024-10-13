<?php
require 'db_config.php';

$pdo = getPDO();
$smtm = $pdo->query("SELECT * FROM faculties");
$faculties = $smtm->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title>Список студентов</title>
    <link href="styles/faculties.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>Список факультетов</h1>
<table>
    <tr>
        <th> Название</th>
    </tr>
    <?php foreach ($faculties as $faculty) : ?>
        <tr>
            <td>
                <a href="faculty.php?id=<?= htmlspecialchars($faculty['id']); ?>"><?= htmlspecialchars($faculty['faculty_name']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="index.php">Назад на главную</a>
</body>
</html>

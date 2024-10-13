<?php
require 'db_config.php';
try {
    $pdo = getPDO();
    $stmt=$pdo->query('SELECT * from electives');
    $electives=$stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error getting data: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title>Список студентов</title>
    <link href="styles/groups.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>Список факультативов университета</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Вместимость</th>
    </tr>
    <?php foreach($electives as $elective): ?>
    <tr>
        <td> <a href="elective.php?id=<?=htmlspecialchars($elective['id'])?>">
                <?=htmlspecialchars($elective['id'])?>
            </a>
        <td><?=htmlspecialchars($elective['elective_name'])?></td>
        <td><?=htmlspecialchars($elective['capacity'])?></td>
    </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="index.php">Назад на главную</a>
</body>
</html>
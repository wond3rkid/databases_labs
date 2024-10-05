<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=university', 'root', '1326');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $smtm = $pdo->query("SELECT * FROM `faculties`");
    $faculties = $smtm->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title>Список студентов</title>
</head>
<body>
<h1>Список факультетов</h1>
<table>
    <tr>
        <th>Название</th>
    </tr>
    <?php foreach ($faculties as $faculty) : ?>
        <tr>
            <td><?= htmlspecialchars($faculty['faculty_name'], ENT_QUOTES) ?></td>
        </tr>
    <?php endforeach; ?>

</table>


<a href="index.php">Назад на главную</a>
</body>
</html>

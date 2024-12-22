<?php
require 'db_config.php';

$pdo = getPDO();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $faculty_name = $_POST['faculty_name'];

    if (empty($faculty_name)) {
        $errors[] = 'Название факультета обязательно для заполнения.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('INSERT INTO faculties (faculty_name) VALUES (:faculty_name)');
        $stmt->execute(['faculty_name' => $faculty_name]);
        header('Location: faculties.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить новый факультет</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<header>
    <h1>Добавить новую группу</h1>
</header>
<main>
    <article>
        <?php if (!empty($errors)): ?>
            <div style="color: #fd0303;">
                <?= implode('<br>', $errors); ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <table class="input-student-table">
                <tr>
                    <td><label for="faculty_name">ID старосты:</label></td>
                    <td><input type="text" name="faculty_name" id="faculty_name" required></td>
                </tr>
            </table>
            <button type="submit" class="input-student-button">Добавить группу</button>
        </form>
    </article>
</main>
<footer>
    <a href="input_db.php">Назад к редактированию базы данных</a> <br>
</footer>
</body>
</html>

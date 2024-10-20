<?php
require 'db_config.php';

$pdo = getPDO();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $elective_name = $_POST['elective_name'];
    $description = $_POST['description'];
    $capacity = $_POST['capacity'];

    if (empty($elective_name)) {
        $errors[] = 'Название факультатива обязательно для заполнения.';
    }
    if (!is_numeric($capacity) || $capacity <= 0) {
        $errors[] = 'Вместимость факультатива должна быть положительным целым числом.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('INSERT INTO electives (elective_name, description, capacity) VALUES (:elective_name, :description, :capacity)');
        $stmt->execute([
            'elective_name' => $elective_name,
            'description' => $description,
            'capacity' => $capacity,
        ]);

        header('Location: electives.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить факультатив</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<header>
    <h1>Добавить факультатив</h1>
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
                    <td><label for="elective_name">Название факультатива:</label></td>
                    <td><input type="text" name="elective_name" id="elective_name" required></td>
                </tr>
                <tr>
                    <td><label for="description">Описание:</label></td>
                    <td><textarea name="description" id="description"></textarea></td>
                </tr>
                <tr>
                    <td><label for="capacity">Вместимость:</label></td>
                    <td><input type="number" name="capacity" id="capacity" min="1" required></td>
                </tr>
            </table>
            <button type="submit" class="input-student-button">Добавить факультатив</button>
        </form>
    </article>
</main>
<footer>
    <a href="input_db.php">Назад к редактированию базы</a> <br>
    <a href="electives.php">Назад к списку факультативов</a>
</footer>
</body>
</html>

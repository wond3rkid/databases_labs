<?php
require 'db_config.php';

$pdo = getPDO();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $patronymic = $_POST['patronymic'];
    $birth_day = $_POST['birth_day'];
    $birth_place = $_POST['birth_place'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $gpa = $_POST['gpa'];
    $group_id = $_POST['group_id'];

    if (empty($first_name) || empty($last_name)) {
        $errors[] = 'Имя и фамилия обязательны для заполнения.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный адрес электронной почты.';
    }
    if (!is_numeric($gpa) || $gpa < 0 || $gpa > 5) {
        $errors[] = 'GPA должно быть числом от 0 до 5.';
    }
    if (!is_numeric($group_id) || $group_id <= 0) {
        $errors[] = 'ID группы должно быть положительным целым числом.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('INSERT INTO students (first_name, last_name, patronymic, birth_day, birth_place, email, phone_number, gpa, group_id) VALUES (:first_name, :last_name, :patronymic, :birth_day, :birth_place, :email, :phone_number, :gpa, :group_id)');
        $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'patronymic' => $patronymic,
            'birth_day' => $birth_day,
            'birth_place' => $birth_place,
            'email' => $email,
            'phone_number' => $phone_number,
            'gpa' => $gpa,
            'group_id' => $group_id,
        ]);
        header('Location: students.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить нового студента</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>
<body>
<header>
    <h1>Добавить нового студента</h1>
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
                    <td><label for="first_name">Имя:</label></td>
                    <td><input type="text" name="first_name" id="first_name" required></td>
                </tr>
                <tr>
                    <td><label for="last_name">Фамилия:</label></td>
                    <td><input type="text" name="last_name" id="last_name" required></td>
                </tr>
                <tr>
                    <td><label for="patronymic">Отчество:</label></td>
                    <td><input type="text" name="patronymic" id="patronymic"></td>
                </tr>
                <tr>
                    <td><label for="birth_day">Дата рождения:</label></td>
                    <td><input type="date" name="birth_day" id="birth_day" required></td>
                </tr>
                <tr>
                    <td><label for="birth_place">Место рождения:</label></td>
                    <td><input type="text" name="birth_place" id="birth_place"></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" name="email" id="email" required></td>
                </tr>
                <tr>
                    <td><label for="phone_number">Телефон:</label></td>
                    <td><input type="text" name="phone_number" id="phone_number"></td>
                </tr>
                <tr>
                    <td><label for="gpa">GPA:</label></td>
                    <td><input type="number" step="0.1" name="gpa" id="gpa" min="0" max="5" required></td>
                </tr>
                <tr>
                    <td><label for="group_id">ID группы:</label></td>
                    <td><input type="number" name="group_id" id="group_id" min="1" required></td>
                </tr>
            </table>
            <button type="submit" class="input-student-button">Добавить студента</button>
        </form>
    </article>
</main>
<footer>
    <a href="input_db.php">Назад к редактированию базы</a> <br>
    <a href="students.php">Назад к списку студентов</a>
</footer>
</body>
</html>

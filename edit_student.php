<?php
require 'db_config.php';

$pdo = getPDO();
$student_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare('SELECT * FROM students WHERE id = :id');
$stmt->execute(['id' => $student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    echo "Ошибка: студент не найден в базе данных.";
    exit(0);
}

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

    // Валидация ввода
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
        $stmt = $pdo->prepare('UPDATE students SET first_name = :first_name, last_name = :last_name, patronymic = :patronymic, birth_day = :birth_day, birth_place = :birth_place, email = :email, phone_number = :phone_number, gpa = :gpa, group_id = :group_id WHERE id = :id');
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
            'id' => $student_id
        ]);
        header('Location: student.php?id=' . $student_id);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать студента</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h1>Редактировать информацию о студенте</h1>
</header>

<main>
    <?php if (!empty($errors)): ?>
        <div style="color: #fd0303;">
            <?= implode('<br>', $errors); ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <table class="edit-student-table ">
            <tr>
                <td><label for="first_name">Имя:</label></td>
                <td><input type="text" name="first_name" id="first_name" value="<?= htmlspecialchars($student['first_name']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="last_name">Фамилия:</label></td>
                <td><input type="text" name="last_name" id="last_name" value="<?= htmlspecialchars($student['last_name']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="patronymic">Отчество:</label></td>
                <td><input type="text" name="patronymic" id="patronymic" value="<?= htmlspecialchars($student['patronymic']); ?>"></td>
            </tr>
            <tr>
                <td><label for="birth_day">Дата рождения:</label></td>
                <td><input type="date" name="birth_day" id="birth_day" value="<?= htmlspecialchars($student['birth_day']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="birth_place">Место рождения:</label></td>
                <td><input type="text" name="birth_place" id="birth_place" value="<?= htmlspecialchars($student['birth_place']); ?>"></td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" name="email" id="email" value="<?= htmlspecialchars($student['email']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="phone_number">Телефон:</label></td>
                <td><input type="text" name="phone_number" id="phone_number" value="<?= htmlspecialchars($student['phone_number']); ?>"></td>
            </tr>
            <tr>
                <td><label for="gpa">GPA:</label></td>
                <td><input type="number" step="0.1" name="gpa" id="gpa" value="<?= htmlspecialchars($student['gpa']); ?>" min="0" max="5" required></td>
            </tr>
            <tr>
                <td><label for="group_id">ID группы:</label></td>
                <td><input type="number" name="group_id" id="group_id" value="<?= htmlspecialchars($student['group_id']); ?>" min="1" required></td>
            </tr>
        </table>
        <button type="submit" class="input-student-button">Сохранить изменения</button>
    </form>
    <a href="student.php?id=<?= htmlspecialchars($student['id']); ?>">Назад к информации о студенте</a>
</main>
</body>
</html>

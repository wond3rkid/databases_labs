<?php
/**
 * @return array
 * @throws Exception
 */
function extracted()
{
    $pdo = new PDO('mysql:host=localhost;dbname=university', 'root', '1326');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $student_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = :id');
    $stmt->execute(['id' => $student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        throw new Exception('Студент не найден');
    }
    return array($pdo, $student_id, $stmt, $student);
}

try {
    list($pdo, $student_id, $stmt, $student) = extracted();

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

        $errors = [];
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
} catch (PDOException $e) {
    echo 'Ошибка: ' . $e->getMessage();
    exit();
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<link href="styles/table_page.css" rel="stylesheet" type="text/css">
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title>Редактировать студента</title>
</head>
<body>
<h1>Редактировать информацию о студенте</h1>

<?php if (!empty($errors)): ?>
    <div style="color: #fd0303;">
        <?= implode('<br>', $errors); ?>
    </div>
<?php endif; ?>

<form method="post">
    <div class="form-group">
        <label for="first_name">Имя:</label>
        <input type="text" name="first_name" id="first_name" value="<?= htmlspecialchars($student['first_name']); ?>" required>
    </div>
    <div class="form-group">
        <label for="last_name">Фамилия:</label>
        <input type="text" name="last_name" id="last_name" value="<?= htmlspecialchars($student['last_name']); ?>" required>
    </div>
    <div class="form-group">
        <label for="patronymic">Отчество:</label>
        <input type="text" name="patronymic" id="patronymic" value="<?= htmlspecialchars($student['patronymic']); ?>">
    </div>
    <div class="form-group">
        <label for="birth_day">Дата рождения:</label>
        <input type="date" name="birth_day" id="birth_day" value="<?= htmlspecialchars($student['birth_day']); ?>" required>
    </div>
    <div class="form-group">
        <label for="birth_place">Место рождения:</label>
        <input type="text" name="birth_place" id="birth_place" value="<?= htmlspecialchars($student['birth_place']); ?>">
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($student['email']); ?>" required>
    </div>
    <div class="form-group">
        <label for="phone_number">Телефон:</label>
        <input type="text" name="phone_number" id="phone_number" value="<?= htmlspecialchars($student['phone_number']); ?>">
    </div>
    <div class="form-group">
        <label for="gpa">GPA:</label>
        <input type="number" step="0.1" name="gpa" id="gpa" value="<?= htmlspecialchars($student['gpa']); ?>" min="0" max="5" required>
    </div>
    <div class="form-group">
        <label for="group_id">ID группы:</label>
        <input type="number" name="group_id" id="group_id" value="<?= htmlspecialchars($student['group_id']); ?>" min="1" required>
    </div>
    <br>
    <button type="submit">Сохранить изменения</button>
    <br>
</form>
<a href="student.php?id=<?= htmlspecialchars($student['id']); ?>">Назад к информации о студенте</a>
</body>
</html>

<?php
require 'db_config.php';

$pdo = getPDO();

$stmt = $pdo->prepare('SELECT id, first_name, last_name FROM students');
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT id, elective_name FROM electives');
$stmt->execute();
$electives = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['student_id']) && isset($_POST['elective_id'])) {
    $student_id = (int)$_POST['student_id'];
    $elective_id = (int)$_POST['elective_id'];

    $insertStmt = $pdo->prepare('INSERT INTO student_elective (student_id, elective_id, enrollment_date) VALUES (:student_id, :elective_id, NOW())');
    $insertStmt->execute(['student_id' => $student_id, 'elective_id' => $elective_id]);

    header("Location: faculty_enrollments.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить студента на факультатив</title>
    <link href="styles/add.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h1>Добавить студента на факультатив</h1>
</header>

<main>
    <form action="add_student_to_elective.php" method="post">
        <label for="student_id">Выберите студента:</label>
        <select name="student_id" id="student_id" required>
            <?php foreach ($students as $student): ?>
                <option value="<?= htmlspecialchars($student['id']); ?>">
                    <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="elective_id">Выберите электив:</label>
        <select name="elective_id" id="elective_id" required>
            <?php foreach ($electives as $elective): ?>
                <option value="<?= htmlspecialchars($elective['id']); ?>">
                    <?= htmlspecialchars($elective['elective_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Записать студента</button>
    </form>

    <nav>
        <a href="faculty_enrollments.php">Назад к списку записей</a>
    </nav>
</main>
</body>
</html>

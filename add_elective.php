<?php
require 'db_config.php';

$pdo = getPDO();

$student_id = isset($_GET['student_id']) ? (int)$_GET['student_id'] : 0;

$stmt = $pdo->prepare('SELECT * FROM electives');
$stmt->execute();
$electives = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $elective_id = isset($_POST['elective_id']) ? (int)$_POST['elective_id'] : 0;
    $stmt = $pdo->prepare('INSERT INTO student_elective (student_id, elective_id, enrollment_date) VALUES (:student_id, :elective_id, NOW())');
    $stmt->execute(['student_id' => $student_id, 'elective_id' => $elective_id]);
    header("Location: student.php?id=" . $student_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Записаться на электив</title>
    <link href="styles/add.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h1>Записаться на электив</h1>
</header>

<h2 for="elective_id">Выберите электив:</h2>

<main>
    <form method="POST">
        <select name="elective_id" id="elective_id" required>
            <option value="">Выберите электив</option>
            <?php foreach ($electives as $elective): ?>
                <option value="<?= $elective['id']; ?>"><?= htmlspecialchars($elective['elective_name']); ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit">Записаться</button>
    </form>

    <nav>
        <a href="student.php?id=<?= $student_id; ?>">Назад к студенту</a>
    </nav>
</main>
</body>
</html>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <title>Редактировать базу данных</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <h1>Редактирование сущностей базы данных</h1>
</header>
<main>
    <form action="input_student.php" method="get">
        <button type="submit" class="db_button">Добавить студента</button>
    </form>
    <form action="input_faculty.php" method="get">
        <button type="submit" class="db_button">Добавить факультет</button>
    </form>
    <form action="input_elective.php" method="get">
        <button type="submit" class="db_button">Добавить факультатив</button>
    </form>

</main>
<footer>
    <a href="index.php">Назад на главную</a>
</footer>
</body>
</html>

<?php
session_start();
require 'db_config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_db'])) {
    clearAndInitDB();
    $_SESSION['message'] = "База данных 'university' успешно создана и инициализирована.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>База данных</title>
    <link href="styles/main_page.css" rel="stylesheet" type="text/css">
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
<h1>Подготовьте базу данных к работе</h1>
<form method="post" action="">
    <button type="submit" name="clear_db">Очистить и инициализировать базу данных</button>
</form>

<?php
if (isset($_SESSION['message'])) {
    echo "<script>showAlert('" . addslashes($_SESSION['message']) . "');</script>";
    unset($_SESSION['message']);
}
?>
<br>
<a href="index.php">Назад на главную</a>
</body>
</html>

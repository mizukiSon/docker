<?php
session_start();

// Простая проверка
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['test_user'] = $_POST['username'] ?? '';
    echo "Сессия установлена! <a href='index.php'>На главную</a>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Тестовый вход</title>
    <meta charset="utf-8">
</head>
<body>
    <h2>🔐 Тестовый вход</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
    <p>user / password</p>
    <p>admin / password</p>
</body>
</html>

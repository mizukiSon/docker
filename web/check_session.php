<?php
session_start();
echo "<h2>Проверка сессии</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h3>Действия:</h3>";
echo "<a href='login.php'>Войти</a> | ";
echo "<a href='logout.php'>Выйти</a> | ";
echo "<a href='index.php'>На главную</a>";
?>

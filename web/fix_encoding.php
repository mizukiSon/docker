<?php
require_once 'db.php';

// Конвертируем таблицы
try {
    $pdo->exec("ALTER DATABASE teh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("ALTER TABLE students CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("ALTER TABLE teachers CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("ALTER TABLE users CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    echo "✅ Кодировка таблиц исправлена!\n";
    
    // Проверяем данные
    $students = $pdo->query("SELECT full_name, group_name FROM students LIMIT 3")->fetchAll();
    echo "\n📋 Проверка данных:\n";
    foreach ($students as $s) {
        echo "- {$s['full_name']} ({$s['group_name']})\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}
?>

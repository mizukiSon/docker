<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'auth.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';
$active_tab = 'login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (login($username, $password)) {
            header('Location: index.php');
            exit;
        } else {
            $error = 'Неверный логин или пароль!';
        }
    } elseif (isset($_POST['register'])) {
        $username = $_POST['reg_username'] ?? '';
        $password = $_POST['reg_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        
        if (strlen($username) < 3) {
            $error = 'Имя пользователя минимум 3 символа!';
        } elseif (strlen($password) < 4) {
            $error = 'Пароль минимум 4 символа!';
        } elseif ($password !== $confirm) {
            $error = 'Пароли не совпадают!';
        } elseif (empty($full_name)) {
            $error = 'Введите полное имя!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Неверный email!';
        } else {
            if (register($username, $password, $full_name, $email)) {
                $success = 'Регистрация успешна! Теперь войдите.';
                $active_tab = 'login';
            } else {
                $error = 'Пользователь уже существует!';
            }
        }
    }
}

$page_title = 'Вход';
include 'template/header_auth.php';
?>

<div class="container" style="max-width: 500px; margin: 50px auto;">
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 20px;">🔐 Вход в систему</h2>
        
        <?php if ($error): ?>
            <div style="background: #fee; color: #c33; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div style="background: #efe; color: #3c3; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        
        <div style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #eee;">
            <button onclick="showTab('login')" id="tabLogin" style="flex:1; padding: 10px; background: none; border: none; cursor: pointer; font-size: 16px; border-bottom: 2px solid #2c3e50;">Вход</button>
            <button onclick="showTab('register')" id="tabRegister" style="flex:1; padding: 10px; background: none; border: none; cursor: pointer; font-size: 16px;">Регистрация</button>
        </div>
        
        <div id="loginForm">
            <form method="POST">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Имя пользователя</label>
                    <input type="text" name="username" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px;">Пароль</label>
                    <input type="password" name="password" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <button type="submit" name="login" style="width: 100%; padding: 10px; background: #2c3e50; color: white; border: none; border-radius: 5px; cursor: pointer;">Войти</button>
            </form>
        </div>
        
        <div id="registerForm" style="display: none;">
            <form method="POST">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Имя пользователя *</label>
                    <input type="text" name="reg_username" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Полное имя *</label>
                    <input type="text" name="full_name" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Email *</label>
                    <input type="email" name="email" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Пароль *</label>
                    <input type="password" name="reg_password" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px;">Подтверждение пароля *</label>
                    <input type="password" name="confirm_password" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <button type="submit" name="register" style="width: 100%; padding: 10px; background: #2c3e50; color: white; border: none; border-radius: 5px; cursor: pointer;">Зарегистрироваться</button>
            </form>
        </div>
        
        <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
            <h4 style="margin-bottom: 10px;">📋 Тестовые учетные записи</h4>
            <p><strong>👤 Пользователь:</strong> user / password</p>
            <p><strong>👨‍💼 Администратор:</strong> admin / password</p>
            <p><strong>👁️ Гость:</strong> без входа (только просмотр главных страниц)</p>
        </div>
    </div>
</div>

<script>
function showTab(tab) {
    if (tab === 'login') {
        document.getElementById('loginForm').style.display = 'block';
        document.getElementById('registerForm').style.display = 'none';
        document.getElementById('tabLogin').style.borderBottom = '2px solid #2c3e50';
        document.getElementById('tabRegister').style.borderBottom = 'none';
    } else {
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('registerForm').style.display = 'block';
        document.getElementById('tabLogin').style.borderBottom = 'none';
        document.getElementById('tabRegister').style.borderBottom = '2px solid #2c3e50';
    }
}
</script>

<?php include 'template/footer_auth.php'; ?>

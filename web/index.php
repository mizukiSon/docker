<?php
require_once 'db.php';
$page_title = 'Главная';
include 'template/header.php';

// Получаем данные из БД
$students = $pdo->query("SELECT * FROM students LIMIT 5")->fetchAll();
$teachers = $pdo->query("SELECT * FROM teachers LIMIT 5")->fetchAll();
?>

<section class="hero-section">
    <div class="container">
        <h2>Добро пожаловать в АПТ!</h2>
        <p>Ангарский политехнический техникум - ваш путь к успешной карьере</p>
    </div>
</section>

<div class="container">
    <h2 style="text-align: center; margin-bottom: 30px;">Наши достижения</h2>
    
    <!-- 3 колонки с фотографиями -->
    <div class="cards-grid">
        <div class="card">
            <img src="images/hero1.jpg" alt="Студенты АПТ" class="card-image" onerror="this.src='https://via.placeholder.com/400x250?text=Студенты+АПТ'">
            <div class="card-content">
                <h3>🏆 Успешные студенты</h3>
                <p>Наши студенты ежегодно становятся победителями региональных и всероссийских конкурсов профессионального мастерства.</p>
                <p><strong>Достижения:</strong> 15 победителей WorldSkills, 20 стипендиатов Губернатора</p>
            </div>
        </div>
        
        <div class="card">
            <img src="images/hero2.jpg" alt="Преподаватели АПТ" class="card-image" onerror="this.src='https://via.placeholder.com/400x250?text=Преподаватели+АПТ'">
            <div class="card-content">
                <h3>👨‍🏫 Квалифицированные преподаватели</h3>
                <p>Высококвалифицированный педагогический состав с большим опытом работы в промышленности и образовании.</p>
                <p><strong>Статистика:</strong> 85% преподавателей имеют высшую категорию</p>
            </div>
        </div>
        
        <div class="card">
            <img src="images/hero3.jpg" alt="Современное оборудование" class="card-image" onerror="this.src='https://via.placeholder.com/400x250?text=Оборудование'">
            <div class="card-content">
                <h3>💻 Современная материальная база</h3>
                <p>Современные лаборатории, компьютерные классы, мастерские с новейшим оборудованием.</p>
                <p><strong>Оснащение:</strong> 10 специализированных лабораторий, 200+ компьютеров</p>
            </div>
        </div>
    </div>
    
    <div class="db-info">
        <h3>📊 Статистика техникума</h3>
        <p><strong>Студентов:</strong> <?= count($students) ?>+ (всего более 800)</p>
        <p><strong>Преподавателей:</strong> <?= count($teachers) ?>+ (всего 65)</p>
        <p><strong>Специальностей:</strong> 12 направлений подготовки</p>
        <p><strong>Выпускников за 60 лет:</strong> более 15 000</p>
    </div>
</div>

<?php include 'template/footer.php'; ?>
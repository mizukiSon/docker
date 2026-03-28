<?php
$page_title = 'Контакты';
include 'template/header.php';
$server_name = getenv('SERVER_NAME') ?: 'АПТ на Docker';
?>

<div class="container">
    <h2>📞 Контактная информация</h2>
    
    <div class="contacts-info">
        <div class="contact-card">
            <h3>📍 Адрес</h3>
            <p>665830, Иркутская область</p>
            <p>г. Ангарск, ул. Мира, 45</p>
            <p>📍 Как добраться: автобусы №1, 5, 12 до остановки "Политехникум"</p>
        </div>
        
        <div class="contact-card">
            <h3>📞 Телефоны</h3>
            <p>📱 Приемная директора: <strong>+7 (3955) 55-55-55</strong></p>
            <p>📱 Приемная комиссия: <strong>+7 (3955) 55-55-56</strong></p>
            <p>📱 Бухгалтерия: <strong>+7 (3955) 55-55-57</strong></p>
            <p>📱 Факс: <strong>+7 (3955) 55-55-58</strong></p>
        </div>
        
        <div class="contact-card">
            <h3>📧 Email</h3>
            <p>📧 Общий: <strong>info@apt.ru</strong></p>
            <p>📧 Приемная комиссия: <strong>priem@apt.ru</strong></p>
            <p>📧 Бухгалтерия: <strong>buh@apt.ru</strong></p>
        </div>
        
        <div class="contact-card">
            <h3>🕐 Режим работы</h3>
            <p>Понедельник - Пятница: <strong>8:00 - 17:00</strong></p>
            <p>Суббота: <strong>9:00 - 14:00</strong></p>
            <p>Воскресенье: <strong>выходной</strong></p>
            <p>Обед: <strong>12:00 - 13:00</strong></p>
        </div>
    </div>
    
    <h2 style="text-align: center; margin: 40px 0 20px;">👥 Администрация техникума</h2>
    <p style="text-align: center; margin-bottom: 30px;">Руководство и ключевые сотрудники</p>
    
    <!-- 6 фотографий сотрудников в 2 ряда по 3 -->
    <div class="teachers-grid">
        <div class="teacher-card">
            <img src="images/teacher1.jpg" alt="Директор" class="teacher-photo" onerror="this.src='https://via.placeholder.com/300x250?text=Директор'">
            <div class="teacher-info">
                <h3>Петров Виктор Александрович</h3>
                <p class="position">Директор техникума</p>
                <p>Стаж: 25 лет</p>
                <p class="quote">"Качество образования - главный приоритет нашей работы"</p>
            </div>
        </div>
        
        <div class="teacher-card">
            <img src="images/teacher2.jpg" alt="Зам. директора" class="teacher-photo" onerror="this.src='https://via.placeholder.com/300x250?text=Заместитель'">
            <div class="teacher-info">
                <h3>Смирнова Елена Васильевна</h3>
                <p class="position">Зам. директора по учебной работе</p>
                <p>Стаж: 18 лет</p>
                <p class="quote">"Создаем условия для развития каждого студента"</p>
            </div>
        </div>
        
        <div class="teacher-card">
            <img src="images/teacher3.jpg" alt="Зам. директора" class="teacher-photo" onerror="this.src='https://via.placeholder.com/300x250?text=Заместитель'">
            <div class="teacher-info">
                <h3>Кузнецов Андрей Михайлович</h3>
                <p class="position">Зам. директора по воспитательной работе</p>
                <p>Стаж: 15 лет</p>
                <p class="quote">"Воспитываем не просто специалистов, а личностей"</p>
            </div>
        </div>
        
        <div class="teacher-card">
            <img src="images/teacher4.jpg" alt="Зав. отделением" class="teacher-photo" onerror="this.src='https://via.placeholder.com/300x250?text=Заведующий'">
            <div class="teacher-info">
                <h3>Морозова Ирина Петровна</h3>
                <p class="position">Зав. IT-отделением</p>
                <p>Стаж: 12 лет</p>
                <p class="quote">"IT-специалисты - профессия будущего!"</p>
            </div>
        </div>
        
        <div class="teacher-card">
            <img src="images/teacher5.jpg" alt="Зав. отделением" class="teacher-photo" onerror="this.src='https://via.placeholder.com/300x250?text=Заведующий'">
            <div class="teacher-info">
                <h3>Васильев Сергей Николаевич</h3>
                <p class="position">Зав. техническим отделением</p>
                <p>Стаж: 20 лет</p>
                <p class="quote">"Практические навыки - основа профессионализма"</p>
            </div>
        </div>
        
        <div class="teacher-card">
            <img src="images/teacher6.jpg" alt="Председатель ПЦК" class="teacher-photo" onerror="this.src='https://via.placeholder.com/300x250?text=Председатель'">
            <div class="teacher-info">
                <h3>Новикова Татьяна Дмитриевна</h3>
                <p class="position">Председатель ПЦК экономики</p>
                <p>Стаж: 14 лет</p>
                <p class="quote">"Экономист - это призвание!"</p>
            </div>
        </div>
    </div>
    
    <div class="server-info" style="background: #e8f4f8; padding: 20px; border-radius: 10px; margin-top: 30px;">
        <h3>🖥️ Информация о сервере</h3>
        <p><strong>Сервер:</strong> <?= htmlspecialchars($server_name) ?></p>
        <p><strong>IP адрес:</strong> <?= $_SERVER['SERVER_ADDR'] ?? '127.0.0.1' ?></p>
        <p><strong>Веб-сервер:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Apache' ?></p>
        <p><strong>PHP версия:</strong> <?= phpversion() ?></p>
        <p><strong>База данных:</strong> <?= getenv('DB_NAME') ?: 'teh' ?></p>
    </div>
</div>

<?php include 'template/footer.php'; ?>
<?php
$page_title = 'О техникуме';
include 'template/header.php';
?>

<div class="container">
    <h2>📖 О Ангарском политехническом техникуме</h2>
    
    <div style="background: #f0f8ff; padding: 30px; border-radius: 15px; margin: 20px 0;">
        <p style="font-size: 18px; line-height: 1.8;">Ангарский политехнический техникум (АПТ) — одно из ведущих образовательных учреждений Иркутской области, основанное в <strong>1965 году</strong>. За годы работы подготовлено более 15 000 специалистов для промышленности и экономики региона.</p>
    </div>
    
    <h2 style="text-align: center; margin: 40px 0 20px;">🎓 Наши специальности</h2>
    <p style="text-align: center; margin-bottom: 30px;">6 востребованных направлений подготовки</p>
    
    <!-- 6 фотографий в 2 ряда по 3 -->
    <div class="gallery-grid">
        <div class="gallery-item">
            <img src="images/spec1.jpg" alt="Информационные системы" class="gallery-image" onerror="this.src='https://via.placeholder.com/400x200?text=Информационные+системы'">
            <div class="gallery-info">
                <h3>💻 Информационные системы</h3>
                <p>Разработка ПО, базы данных, web-технологии</p>
                <p><strong>Срок обучения:</strong> 2 года 10 мес - 3 года 10 мес</p>
            </div>
        </div>
        
        <div class="gallery-item">
            <img src="images/spec2.jpg" alt="Техническая эксплуатация" class="gallery-image" onerror="this.src='https://via.placeholder.com/400x200?text=Техническая+эксплуатация'">
            <div class="gallery-info">
                <h3>🔧 Техническая эксплуатация</h3>
                <p>Обслуживание промышленного оборудования</p>
                <p><strong>Срок обучения:</strong> 3 года 10 мес</p>
            </div>
        </div>
        
        <div class="gallery-item">
            <img src="images/spec3.jpg" alt="Электроснабжение" class="gallery-image" onerror="this.src='https://via.placeholder.com/400x200?text=Электроснабжение'">
            <div class="gallery-info">
                <h3>⚡ Электроснабжение</h3>
                <p>Электрические сети, энергоснабжение предприятий</p>
                <p><strong>Срок обучения:</strong> 3 года 10 мес</p>
            </div>
        </div>
        
        <div class="gallery-item">
            <img src="images/spec4.jpg" alt="Экономика" class="gallery-image" onerror="this.src='https://via.placeholder.com/400x200?text=Экономика+и+бухучет'">
            <div class="gallery-info">
                <h3>💰 Экономика и бухучет</h3>
                <p>Бухгалтерский учет, налогообложение, финансы</p>
                <p><strong>Срок обучения:</strong> 2 года 10 мес</p>
            </div>
        </div>
        
        <div class="gallery-item">
            <img src="images/spec5.jpg" alt="Технология машиностроения" class="gallery-image" onerror="this.src='https://via.placeholder.com/400x200?text=Машиностроение'">
            <div class="gallery-info">
                <h3>🏭 Технология машиностроения</h3>
                <p>Производство деталей, CAD/CAM технологии</p>
                <p><strong>Срок обучения:</strong> 3 года 10 мес</p>
            </div>
        </div>
        
        <div class="gallery-item">
            <img src="images/spec6.jpg" alt="Сварочное производство" class="gallery-image" onerror="this.src='https://via.placeholder.com/400x200?text=Сварочное+производство'">
            <div class="gallery-info">
                <h3>🔥 Сварочное производство</h3>
                <p>Сварка, контроль качества, технологии</p>
                <p><strong>Срок обучения:</strong> 2 года 10 мес</p>
            </div>
        </div>
    </div>
    
    <div class="db-info">
        <h3>📈 Наши преимущества</h3>
        <ul style="margin-left: 20px;">
            <li>✅ Государственная аккредитация до 2028 года</li>
            <li>✅ Трудоустройство выпускников - 92%</li>
            <li>✅ Партнерство с 50+ предприятиями региона</li>
            <li>✅ Бесплатное обучение на бюджетной основе</li>
            <li>✅ Стипендии для успешных студентов</li>
        </ul>
    </div>
</div>

<?php include 'template/footer.php'; ?>
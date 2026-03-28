<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'auth.php';

// Если не авторизован - редирект на вход
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';

// Получаем всех преподавателей
$teachers = $pdo->query("SELECT * FROM teachers ORDER BY id DESC")->fetchAll();

// Обработка действий админа
if (isAdmin()) {
    // Добавление
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
        $birth_date = !empty($_POST['birth_date']) ? $_POST['birth_date'] : null;
        $stmt = $pdo->prepare("INSERT INTO teachers (full_name, birth_date, discipline, education, experience_years, phone, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['full_name'],
            $birth_date,
            $_POST['discipline'] ?? null,
            $_POST['education'] ?? null,
            $_POST['experience_years'] ?? null,
            $_POST['phone'] ?? null,
            $_POST['email'] ?? null
        ]);
        header('Location: teachers.php?msg=added');
        exit;
    }
    
    // Удаление
    if (isset($_GET['delete'])) {
        $stmt = $pdo->prepare("DELETE FROM teachers WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        header('Location: teachers.php?msg=deleted');
        exit;
    }
    
    // Редактирование
    if (isset($_POST['edit_id'])) {
        $birth_date = !empty($_POST['birth_date']) ? $_POST['birth_date'] : null;
        $stmt = $pdo->prepare("UPDATE teachers SET full_name=?, birth_date=?, discipline=?, education=?, experience_years=?, phone=?, email=? WHERE id=?");
        $stmt->execute([
            $_POST['full_name'],
            $birth_date,
            $_POST['discipline'] ?? null,
            $_POST['education'] ?? null,
            $_POST['experience_years'] ?? null,
            $_POST['phone'] ?? null,
            $_POST['email'] ?? null,
            $_POST['edit_id']
        ]);
        header('Location: teachers.php?msg=updated');
        exit;
    }
}

$page_title = 'Преподаватели';
include 'template/header.php';
?>

<div class="teachers-page">
    <div class="page-header">
        <h2>👨‍🏫 Список преподавателей</h2>
        <p class="page-description">Всего преподавателей: <?= count($teachers) ?></p>
    </div>
    
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            <?php if ($_GET['msg'] == 'added'): ?>
                <span class="alert-icon">✅</span> Преподаватель успешно добавлен!
            <?php elseif ($_GET['msg'] == 'updated'): ?>
                <span class="alert-icon">✏️</span> Преподаватель успешно обновлен!
            <?php elseif ($_GET['msg'] == 'deleted'): ?>
                <span class="alert-icon">🗑️</span> Преподаватель успешно удален!
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <?php if (isAdmin()): ?>
        <div class="admin-section">
            <button onclick="toggleForm()" class="btn btn-primary">
                <span class="btn-icon">➕</span> Добавить преподавателя
            </button>
            
            <div id="addForm" class="add-form" style="display: none;">
                <div class="form-card">
                    <h3 class="form-title">📝 Добавление нового преподавателя</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="add">
                        <div class="form-grid">
                            <div class="form-field full-width">
                                <label>ФИО <span class="required">*</span></label>
                                <input type="text" name="full_name" required placeholder="Введите полное имя">
                            </div>
                            <div class="form-field">
                                <label>Дата рождения</label>
                                <input type="date" name="birth_date">
                            </div>
                            <div class="form-field">
                                <label>Дисциплина</label>
                                <input type="text" name="discipline" placeholder="Например: Web-разработка">
                            </div>
                            <div class="form-field">
                                <label>Образование</label>
                                <input type="text" name="education" placeholder="ВУЗ, факультет, год">
                            </div>
                            <div class="form-field">
                                <label>Стаж (лет)</label>
                                <input type="number" name="experience_years" placeholder="0" min="0">
                            </div>
                            <div class="form-field">
                                <label>Телефон</label>
                                <input type="tel" name="phone" placeholder="+7 (XXX) XXX-XX-XX">
                            </div>
                            <div class="form-field">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="teacher@apt.ru">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success">💾 Сохранить</button>
                            <button type="button" onclick="toggleForm()" class="btn btn-secondary">❌ Отмена</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="table-wrapper">
        <table class="teacher-table">
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-name">ФИО</th>
                    <th class="col-birth">Дата рождения</th>
                    <th class="col-discipline">Дисциплина</th>
                    <th class="col-education">Образование</th>
                    <th class="col-experience">Стаж</th>
                    <th class="col-actions">Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($teachers) > 0): ?>
                    <?php foreach($teachers as $t): ?>
                    <tr>
                        <td class="col-id"><?= $t['id'] ?></td>
                        <td class="col-name">
                            <strong><?= htmlspecialchars($t['full_name']) ?></strong>
                        </td>
                        <td class="col-birth"><?= $t['birth_date'] && $t['birth_date'] != '0000-00-00' ? date('d.m.Y', strtotime($t['birth_date'])) : '—' ?></td>
                        <td class="col-discipline"><?= htmlspecialchars($t['discipline'] ?? '—') ?></td>
                        <td class="col-education"><?= htmlspecialchars($t['education'] ?? '—') ?></td>
                        <td class="col-experience"><?= $t['experience_years'] ?? '—' ?> <?= ($t['experience_years'] ?? 0) > 0 ? 'лет' : '' ?></td>
                        <td class="col-actions">
                            <!-- Кнопка просмотра для всех авторизованных -->
                            <button onclick="viewTeacher(
                                '<?= addslashes($t['full_name']) ?>',
                                '<?= $t['birth_date'] ?>',
                                '<?= addslashes($t['discipline'] ?? '') ?>',
                                '<?= addslashes($t['education'] ?? '') ?>',
                                '<?= addslashes($t['experience_years'] ?? '') ?>',
                                '<?= addslashes($t['phone'] ?? '') ?>',
                                '<?= addslashes($t['email'] ?? '') ?>'
                            )" class="action-btn action-view" title="Просмотр">
                                👁️
                            </button>
                            
                            <?php if (isAdmin()): ?>
                                <!-- Кнопки редактирования и удаления только для админа -->
                                <button onclick="editTeacher(
                                    <?= $t['id'] ?>,
                                    '<?= addslashes($t['full_name']) ?>',
                                    '<?= $t['birth_date'] ?>',
                                    '<?= addslashes($t['discipline'] ?? '') ?>',
                                    '<?= addslashes($t['education'] ?? '') ?>',
                                    '<?= addslashes($t['experience_years'] ?? '') ?>',
                                    '<?= addslashes($t['phone'] ?? '') ?>',
                                    '<?= addslashes($t['email'] ?? '') ?>'
                                )" class="action-btn action-edit" title="Редактировать">
                                    ✏️
                                </button>
                                <a href="?delete=<?= $t['id'] ?>" class="action-btn action-delete" onclick="return confirm('Удалить преподавателя «<?= addslashes($t['full_name']) ?>»?')" title="Удалить">
                                    🗑️
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="empty-state">
                            <span class="empty-icon">📭</span>
                            <p>Нет данных о преподавателях</p>
                            <?php if (isAdmin()): ?>
                                <button onclick="toggleForm()" class="btn btn-primary btn-sm">➕ Добавить первого преподавателя</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Модальное окно просмотра для всех -->
<div id="viewModal" class="modal">
    <div class="modal-content view-modal">
        <div class="modal-header">
            <h3>👁️ Просмотр информации о преподавателе</h3>
            <button class="modal-close" onclick="closeViewModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="info-card">
                <div class="info-row">
                    <span class="info-label">ФИО:</span>
                    <span class="info-value" id="view_full_name"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Дата рождения:</span>
                    <span class="info-value" id="view_birth_date"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Дисциплина:</span>
                    <span class="info-value" id="view_discipline"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Образование:</span>
                    <span class="info-value" id="view_education"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Стаж:</span>
                    <span class="info-value" id="view_experience"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Телефон:</span>
                    <span class="info-value" id="view_phone"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value" id="view_email"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closeViewModal()" class="btn btn-secondary">Закрыть</button>
        </div>
    </div>
</div>

<?php if (isAdmin()): ?>
<!-- Модальное окно редактирования для админа -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>✏️ Редактирование преподавателя</h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form method="POST">
            <input type="hidden" name="edit_id" id="edit_id">
            <div class="modal-body">
                <div class="form-field full-width">
                    <label>ФИО <span class="required">*</span></label>
                    <input type="text" name="full_name" id="edit_full_name" required>
                </div>
                <div class="form-field">
                    <label>Дата рождения</label>
                    <input type="date" name="birth_date" id="edit_birth_date">
                </div>
                <div class="form-field">
                    <label>Дисциплина</label>
                    <input type="text" name="discipline" id="edit_discipline">
                </div>
                <div class="form-field">
                    <label>Образование</label>
                    <input type="text" name="education" id="edit_education">
                </div>
                <div class="form-field">
                    <label>Стаж (лет)</label>
                    <input type="number" name="experience_years" id="edit_experience_years" min="0">
                </div>
                <div class="form-field">
                    <label>Телефон</label>
                    <input type="tel" name="phone" id="edit_phone">
                </div>
                <div class="form-field">
                    <label>Email</label>
                    <input type="email" name="email" id="edit_email">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">💾 Сохранить изменения</button>
                <button type="button" onclick="closeModal()" class="btn btn-secondary">Отмена</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<style>
/* Основные стили страницы */
.teachers-page {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

.page-header {
    margin-bottom: 25px;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 15px;
}

.page-header h2 {
    color: #2c3e50;
    font-size: 28px;
    margin-bottom: 5px;
}

.page-description {
    color: #6c757d;
    font-size: 14px;
}

/* Алerts */
.alert {
    padding: 12px 18px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-icon {
    font-size: 18px;
}

/* Кнопки */
.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-primary {
    background: #2c3e50;
    color: white;
}

.btn-primary:hover {
    background: #1e2b38;
    transform: translateY(-1px);
}

.btn-success {
    background: #27ae60;
    color: white;
}

.btn-success:hover {
    background: #229954;
}

.btn-warning {
    background: #f39c12;
    color: white;
}

.btn-warning:hover {
    background: #e67e22;
}

.btn-secondary {
    background: #95a5a6;
    color: white;
}

.btn-secondary:hover {
    background: #7f8c8d;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

/* Форма добавления */
.admin-section {
    margin-bottom: 30px;
}

.add-form {
    margin-top: 20px;
    animation: slideDown 0.3s ease;
}

.form-card {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 25px;
    border: 1px solid #e9ecef;
}

.form-title {
    color: #2c3e50;
    margin-bottom: 20px;
    font-size: 18px;
    font-weight: 600;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.form-field {
    display: flex;
    flex-direction: column;
}

.form-field.full-width {
    grid-column: span 2;
}

.form-field label {
    font-size: 13px;
    font-weight: 500;
    color: #495057;
    margin-bottom: 5px;
}

.form-field .required {
    color: #e74c3c;
}

.form-field input,
.form-field textarea {
    padding: 8px 12px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.2s;
}

.form-field input:focus,
.form-field textarea:focus {
    outline: none;
    border-color: #2c3e50;
    box-shadow: 0 0 0 3px rgba(44,62,80,0.1);
}

.form-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

/* Таблица */
.table-wrapper {
    background: white;
    border-radius: 12px;
    overflow-x: auto;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.teacher-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.teacher-table thead {
    background: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
}

.teacher-table th {
    padding: 14px 12px;
    text-align: left;
    font-weight: 600;
    color: #495057;
}

.teacher-table td {
    padding: 12px;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.teacher-table tbody tr:hover {
    background: #f8f9fa;
}

.col-id {
    width: 60px;
    text-align: center;
}

.col-name {
    font-weight: 500;
    min-width: 180px;
}

.col-discipline {
    min-width: 150px;
}

.col-education {
    min-width: 200px;
}

.col-experience {
    width: 70px;
    text-align: center;
}

.col-actions {
    width: 130px;
    text-align: center;
    white-space: nowrap;
}

/* Кнопки действий */
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.2s;
    text-decoration: none;
    margin: 0 2px;
}

.action-view {
    background: #3498db;
    color: white;
}

.action-view:hover {
    background: #2980b9;
    transform: scale(1.05);
}

.action-edit {
    background: #f39c12;
    color: white;
}

.action-edit:hover {
    background: #e67e22;
    transform: scale(1.05);
}

.action-delete {
    background: #e74c3c;
    color: white;
}

.action-delete:hover {
    background: #c0392b;
    transform: scale(1.05);
}

/* Модальное окно */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    animation: fadeIn 0.2s ease;
}

.modal-content {
    position: relative;
    background: white;
    max-width: 550px;
    margin: 50px auto;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    animation: slideDown 0.3s ease;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    border-bottom: 1px solid #e9ecef;
}

.modal-header h3 {
    color: #2c3e50;
    font-size: 18px;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #95a5a6;
    transition: color 0.2s;
}

.modal-close:hover {
    color: #e74c3c;
}

.modal-body {
    padding: 25px;
    max-height: 60vh;
    overflow-y: auto;
}

.modal-footer {
    padding: 15px 25px;
    border-top: 1px solid #e9ecef;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

/* Карточка информации для просмотра */
.info-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 5px;
}

.info-row {
    display: flex;
    padding: 12px 15px;
    border-bottom: 1px solid #e9ecef;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    width: 120px;
    font-weight: 600;
    color: #495057;
}

.info-value {
    flex: 1;
    color: #2c3e50;
}

.view-modal .modal-content {
    max-width: 500px;
}

/* Пустое состояние */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-icon {
    font-size: 48px;
    display: block;
    margin-bottom: 15px;
    opacity: 0.5;
}

.empty-state p {
    margin-bottom: 15px;
    font-size: 16px;
}

/* Анимации */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Адаптивность */
@media (max-width: 1024px) {
    .teacher-table {
        font-size: 13px;
    }
    
    .col-education {
        min-width: 180px;
    }
}

@media (max-width: 768px) {
    .teachers-page {
        padding: 15px;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .form-field.full-width {
        grid-column: span 1;
    }
    
    .teacher-table th,
    .teacher-table td {
        padding: 8px;
    }
    
    .col-id {
        width: 50px;
    }
    
    .col-actions {
        width: 110px;
    }
    
    .action-btn {
        width: 28px;
        height: 28px;
        font-size: 14px;
    }
    
    .modal-content {
        margin: 20px;
        max-width: calc(100% - 40px);
    }
    
    .info-row {
        flex-direction: column;
        padding: 10px;
    }
    
    .info-label {
        width: auto;
        margin-bottom: 5px;
    }
}
</style>

<script>
function toggleForm() {
    var form = document.getElementById('addForm');
    if (form.style.display === 'none') {
        form.style.display = 'block';
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        form.style.display = 'none';
    }
}

// Функция просмотра для всех
function viewTeacher(full_name, birth_date, discipline, education, experience_years, phone, email) {
    document.getElementById('view_full_name').innerText = full_name;
    document.getElementById('view_birth_date').innerText = birth_date && birth_date != '0000-00-00' ? birth_date : '—';
    document.getElementById('view_discipline').innerText = discipline || '—';
    document.getElementById('view_education').innerText = education || '—';
    document.getElementById('view_experience').innerText = experience_years ? experience_years + ' лет' : '—';
    document.getElementById('view_phone').innerText = phone || '—';
    document.getElementById('view_email').innerText = email || '—';
    document.getElementById('viewModal').style.display = 'block';
}

function closeViewModal() {
    document.getElementById('viewModal').style.display = 'none';
}

<?php if (isAdmin()): ?>
// Функции редактирования только для админа
function editTeacher(id, full_name, birth_date, discipline, education, experience_years, phone, email) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_full_name').value = full_name;
    document.getElementById('edit_birth_date').value = birth_date && birth_date != '0000-00-00' ? birth_date : '';
    document.getElementById('edit_discipline').value = discipline;
    document.getElementById('edit_education').value = education;
    document.getElementById('edit_experience_years').value = experience_years;
    document.getElementById('edit_phone').value = phone;
    document.getElementById('edit_email').value = email;
    document.getElementById('editModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}
<?php endif; ?>

// Закрытие модального окна при клике вне его
window.onclick = function(event) {
    var viewModal = document.getElementById('viewModal');
    if (event.target == viewModal) {
        closeViewModal();
    }
    <?php if (isAdmin()): ?>
    var editModal = document.getElementById('editModal');
    if (event.target == editModal) {
        closeModal();
    }
    <?php endif; ?>
}
</script>

<?php include 'template/footer.php'; ?>

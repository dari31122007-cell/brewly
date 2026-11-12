<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ВАЖНО: Мета-тег для защиты CSRF -->
    <meta name="csrf-token" content="<?= Yii::$app->request->csrfToken ?>">
    
    <title><?= Html::encode($this->title ? $this->title . ' — Brewly' : 'Brewly — Коллекция рецептов кофе') ?></title>
    
    <!-- Шрифты Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- ================= HEADER ================= -->
<header class="header">
  <div class="container nav">
    <a class="logo" href="<?= Url::to(['site/index']) ?>">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
      Brew<span>ly</span>
    </a>
    
    <nav>
      <ul class="nav-links">
        <li><a href="<?= Url::to(['site/index']) ?>" class="<?= Yii::$app->controller->action->id === 'index' ? 'active' : '' ?>">Главная</a></li>
        <li><a href="<?= Url::to(['site/recipes']) ?>" class="<?= Yii::$app->controller->action->id === 'recipes' ? 'active' : '' ?>">Рецепты</a></li>
        
        <?php if (Yii::$app->user->isGuest): ?>
            <li><a href="<?= Url::to(['site/login']) ?>" class="<?= Yii::$app->controller->action->id === 'login' ? 'active' : '' ?>">Вход</a></li>
            <li><a href="<?= Url::to(['site/signup']) ?>" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem; text-decoration: none;">Регистрация</a></li>
        <?php else: ?>
            <li><a href="<?= Url::to(['site/profile']) ?>" class="<?= Yii::$app->controller->action->id === 'profile' ? 'active' : '' ?>">Мой профиль</a></li>
            <li><a href="<?= Url::to(['site/favorites']) ?>" class="<?= Yii::$app->controller->action->id === 'favorites' ? 'active' : '' ?>">Избранное</a></li>
            <li><a href="<?= Url::to(['site/add-recipe']) ?>" class="<?= Yii::$app->controller->action->id === 'add-recipe' ? 'active' : '' ?>">Добавить рецепт</a></li>
            <li>
                <?= Html::beginForm(['site/logout'], 'post', ['style' => 'display:inline;']) ?>
                <?= Html::submitButton('Выход (' . Html::encode(Yii::$app->user->identity->username) . ')', [
                    'class' => 'btn btn-ghost',
                    'style' => 'padding: 8px 16px; font-size: 0.9rem; border: none; cursor: pointer; color: var(--muted, #666); background: transparent;'
                ]) ?>
                <?= Html::endForm() ?>
            </li>
        <?php endif; ?>
      </ul>
    </nav>
    
    <!-- УДАЛЕНО: Блок с сердечком (nav-actions) больше не нужен -->
    <!-- Оставлена только кнопка бургера для мобильных -->
    <div class="nav-actions">
      <button class="burger" aria-label="Меню">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
      </button>
    </div>
  </div>
</header>
<!-- ================= MAIN CONTENT ================= -->
<main class="container home-main">
    <?= $content ?>
</main>

<!-- ================= FOOTER ================= -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="logo" style="color:#fff;margin-bottom:12px">
           <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
           Brew<span style="color:var(--accent)">ly</span>
        </div>
        <p style="font-size:.9rem;max-width:320px">Сообщество ценителей кофе. Делимся рецептами, находками и любовью к хорошему зерну.</p>
      </div>
      
      <div>
        <h4>Разделы</h4>
        <a href="<?= Url::to(['site/index']) ?>">Главная</a>
        <a href="<?= Url::to(['site/recipes']) ?>">Рецепты</a>
        <a href="<?= Url::to(['site/add-recipe']) ?>">Добавить</a>
        <?php if (!Yii::$app->user->isGuest): ?>
            <a href="<?= Url::to(['site/favorites']) ?>">Избранное</a>
        <?php endif; ?>
      </div>
      
      <div>
        <h4>Контакты</h4>
        <a href="mailto:hello@brewly.coffee">hello@brewly.coffee</a>
        <a href="#" onclick="alert('Наш Telegram скоро появится!'); return false;">Telegram</a>
        <a href="#" onclick="alert('Наш Instagram скоро появится!'); return false;">Instagram</a>
      </div>
    </div>
    <div class="footer-bottom">© <?= date('Y') ?> Brewly. Сделано с любовью к кофе.</div>
  </div>
</footer>

<!-- СКРИПТ ДЛЯ ИЗБРАННОГО (ИСПРАВЛЕННЫЙ URL) -->
<!-- СКРИПТ ДЛЯ ИЗБРАННОГО (ПОЛНОСТЬЮ ИСПРАВЛЕННЫЙ) -->
<script>
function toggleFavorite(id) {
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    if (!metaTag) {
        alert('Ошибка: Не найден CSRF токен.');
        return;
    }
    const token = metaTag.getAttribute('content');
    
    // ЖЕСТКИЙ АДРЕС: всегда используем index.php?r=...
    // Это работает даже если ЧПУ выключены или настроены криво
    const url = window.location.origin + '/index.php?r=site/toggle-favorite&id=' + id;
    
    console.log('Отправка на:', url);

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-Token': token,
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            // Если ошибка, читаем текст (иногда сервер возвращает HTML вместо JSON при ошибке)
            return response.text().then(text => {
                throw new Error('Ошибка сервера (' + response.status + '): ' + text.substring(0, 100));
            });
        }
        return response.json();
    })
    .then(data => {
        if (data && data.success) {
            const msg = data.action === 'added' ? 'Добавлено в избранное! ❤️' : 'Удалено из избранного.';
            alert(msg);
            location.reload(); 
        } else {
            alert('Ошибка: ' + (data?.message || 'Неизвестная ошибка'));
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
        alert('Произошла ошибка соединения:\n' + error.message);
    });
}
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
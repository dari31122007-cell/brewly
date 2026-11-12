<?php
/* @var $recipe app\models\Recipe */
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Favorite;

// Проверка: добавлен ли рецепт в избранное?
$isFavorite = false;
if (!Yii::$app->user->isGuest) {
    $userId = Yii::$app->user->id;
    $favoriteRecord = Favorite::findOne(['user_id' => $userId, 'recipe_id' => $recipe->id]);
    if ($favoriteRecord) {
        $isFavorite = true;
    }
}
?>

<article class="recipe-card">
    <!-- Контейнер картинки с ЖЕСТКИМ позиционированием -->
    <div class="card-img" style="position: relative; width: 100%; overflow: hidden; aspect-ratio: 4/3;">
        
        <!-- Ссылка на рецепт -->
        <a href="<?= Url::to(['site/recipe', 'id' => $recipe->id]) ?>" tabindex="-1" style="display:block; line-height:0; text-decoration:none;">
            <img src="<?= Yii::getAlias('@web' . ($recipe->image_path ?: '/images/default-coffee.jpg')) ?>" 
                 alt="<?= Html::encode($recipe->title) ?>" 
                 style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </a>
        
        <!-- Бейдж категории (слева вверху) -->
        <?php if ($recipe->category): ?>
            <span class="card-badge" style="position: absolute; top: 12px; left: 12px; z-index: 5; background: rgba(255, 255, 255, 0.95); padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; color: var(--accent, #C65D3C); box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <?= Html::encode($recipe->category->name) ?>
            </span>
        <?php endif; ?>

                <!-- БЛОК КНОПОК (справа внизу) - Жесткое позиционирование -->
                <div style="position: absolute; bottom: 12px; right: 12px; z-index: 10; display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
            
            <!-- 1. КНОПКА РЕДАКТИРОВАНИЯ (Карандаш) - только автору -->
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->id == $recipe->author_id): ?>
                <?= Html::a('✏️', ['site/edit-recipe', 'id' => $recipe->id], [
                    'style' => 'background: rgba(50, 150, 255, 0.9); color: white; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 18px; box-shadow: 0 2px 6px rgba(0,0,0,0.3); transition: transform 0.2s;',
                    'onmouseover' => "this.style.transform='scale(1.1)'; this.style.background='#368bd9'",
                    'onmouseout' => "this.style.transform='scale(1)'; this.style.background='rgba(50, 150, 255, 0.9)'"
                ]) ?>
            <?php endif; ?>

            <!-- 2. КНОПКА УДАЛЕНИЯ (Корзина) - только автору -->
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->id == $recipe->author_id): ?>
                <?= Html::beginForm(['site/delete-recipe', 'id' => $recipe->id], 'post', ['style' => 'display:inline;']) ?>
                    <button type="submit" 
                            data-confirm="Удалить рецепт?"
                            style="background: rgba(255, 77, 77, 0.9); color: white; border: none; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 18px; box-shadow: 0 2px 6px rgba(0,0,0,0.3); transition: transform 0.2s;"
                            onmouseover="this.style.transform='scale(1.1)'; this.style.background='#d93636'"
                            onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(255, 77, 77, 0.9)'">
                        🗑️
                    </button>
                <?= Html::endForm() ?>
            <?php endif; ?>

            <!-- 3. КНОПКА ИЗБРАННОГО (Сердечко) -->
            <?php if (!Yii::$app->user->isGuest): ?>
                <?= Html::beginForm(['site/toggle-favorite', 'id' => $recipe->id], 'post', ['style' => 'display:inline; margin:0; padding:0;']) ?>
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                    
                    <?php if ($isFavorite): ?>
                        <!-- Активное (красное) -->
                        <button type="submit" style="background: #ff4d4d; border: none; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.3); transition: transform 0.2s; padding: 0;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="white" stroke="none"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </button>
                    <?php else: ?>
                        <!-- Неактивное (белое) -->
                        <button type="submit" style="background: rgba(255, 255, 255, 0.95); border: 2px solid #ff4d4d; color: #ff4d4d; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.2); transition: all 0.2s; padding: 0;" onmouseover="this.style.background='#ff4d4d'; this.style.color='white'" onmouseout="this.style.background='rgba(255,255,255,0.95)'; this.style.color='#ff4d4d'">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </button>
                    <?php endif; ?>
                <?= Html::endForm() ?>
            <?php else: ?>
                <!-- Для гостей (неактивная иконка) -->
                <div style="background: rgba(255,255,255,0.6); width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; opacity: 0.7; cursor: not-allowed;">
                     <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                </div>
            <?php endif; ?>
            
        </div>
    </div>

    <!-- Текст карточки -->
    <div class="card-body" style="padding: 20px;">
        <h3 style="margin-bottom: 8px; font-size: 1.2rem; line-height: 1.3;">
            <a href="<?= Url::to(['site/recipe', 'id' => $recipe->id]) ?>" style="text-decoration:none; color:inherit;"><?= Html::encode($recipe->title) ?></a>
        </h3>
        <div class="card-meta" style="display: flex; gap: 16px; color: var(--muted, #6B5D52); font-size: 0.85rem; margin-bottom: 12px; align-items: center;">
            <span style="display:flex; align-items:center; gap:4px;">⏱️ <?= Html::encode($recipe->prep_time ?: 'Н/Д') ?></span>
            <span><?= Html::encode($recipe->difficulty ?: 'Средне') ?></span>
        </div>
        <?php if (!empty($recipe->tags)): ?>
             <div class="card-tags" style="display: flex; gap: 6px; flex-wrap: wrap;">
                <?php foreach (array_slice(explode(',', is_string($recipe->tags) ? $recipe->tags : ''), 0, 3) as $tag): ?>
                    <span class="tag-pill" style="background: var(--bg, #F5F1EA); color: var(--muted, #6B5D52); padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 500;"><?= Html::encode(trim($tag)) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</article>
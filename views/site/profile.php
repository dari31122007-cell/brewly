<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $recipes app\models\Recipe[] */
/* @var $pagination yii\data\Pagination */

$this->title = 'Профиль: ' . Html::encode($user->username);
?>

<section class="section">
    <div class="container">
        
        <!-- Шапка профиля -->
        <div style="background: var(--card, #fff); border-radius: 16px; padding: 32px; border: 1px solid var(--border, #E5DDD0); margin-bottom: 40px; display: flex; align-items: center; gap: 24px; flex-wrap: wrap; box-shadow: var(--shadow, 0 4px 20px rgba(43, 29, 20, .06));">
            
            <!-- Аватар или Инициал -->
            <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; background: var(--accent, #C65D3C); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: bold; flex-shrink: 0; border: 3px solid var(--bg, #F5F1EA);">
                <?php if ($user->avatar_path): ?>
                    <img src="<?= Yii::getAlias('@web' . $user->avatar_path) ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                <?php else: ?>
                    <?= strtoupper(substr($user->username, 0, 1)) ?>
                <?php endif; ?>
            </div>
            
            <div style="flex: 1; min-width: 250px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h1 style="margin: 0 0 8px 0; font-size: 2rem; line-height: 1.2;"><?= Html::encode($user->username) ?></h1>
                        <p style="color: var(--muted, #6B5D52); margin: 0 0 12px 0; font-size: 1.05rem;">
                            <?= Html::encode($user->email) ?>
                        </p>
                    </div>
                    
                    <!-- КНОПКА РЕДАКТИРОВАНИЯ ПРОФИЛЯ -->
                    <a href="<?= Url::to(['site/edit-profile']) ?>" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.9rem; white-space: nowrap;">
                        ✏️ Редактировать
                    </a>
                </div>
                
                <?php if (!empty($user->bio)): ?>
                    <p style="margin: 0; font-size: 1.05rem; line-height: 1.6; color: var(--text, #2B1D14);"><?= Html::encode($user->bio) ?></p>
                <?php else: ?>
                    <p style="margin: 0; color: var(--muted, #6B5D52); font-style: italic; font-size: 0.95rem;">Информация о себе не заполнена.</p>
                <?php endif; ?>
                
                <div style="margin-top: 16px; display: flex; gap: 12px; flex-wrap: wrap;">
                    <span class="tag-pill" style="background: var(--bg, #F5F1EA); color: var(--muted, #6B5D52);">Рецептов: <?= count($recipes) ?></span>
                    <span class="tag-pill" style="background: var(--bg, #F5F1EA); color: var(--muted, #6B5D52);">В избранном: <?= \app\models\Favorite::find()->where(['user_id' => $user->id])->count() ?></span>
                </div>
            </div>
        </div>

        <!-- Секция рецептов -->
        <div class="section-head" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="margin: 0;">Мои рецепты</h2>
            <a href="<?= Url::to(['site/add-recipe']) ?>" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;">+ Добавить новый</a>
        </div>

        <?php if (!empty($recipes)): ?>
            <div class="recipes-grid">
                <?php foreach ($recipes as $recipe): ?>
                    <!-- Используем тот же партиал, что и на главной -->
                    <?= $this->render('_recipeCard', ['recipe' => $recipe]) ?>
                <?php endforeach; ?>
            </div>

            <?php if ($pagination->totalCount > $pagination->pageSize): ?>
                <div style="margin-top: 40px; display: flex; justify-content: center;">
                    <?= LinkPager::widget([
                        'pagination' => $pagination,
                        'options' => ['class' => 'pagination'],
                    ]) ?>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <!-- Заглушка, если рецептов нет -->
            <div style="text-align: center; padding: 60px 0; color: var(--muted, #6B5D52); background: var(--card, #fff); border-radius: 16px; border: 1px dashed var(--border, #E5DDD0);">
                <h3 style="margin-bottom: 10px;">Пока нет опубликованных рецептов</h3>
                <p style="margin-bottom: 20px;">Самое время добавить первый!</p>
                <a href="<?= Url::to(['site/add-recipe']) ?>" class="btn btn-primary">Добавить рецепт</a>
            </div>
        <?php endif; ?>
        
    </div>
</section>
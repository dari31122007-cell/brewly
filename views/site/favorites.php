<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $recipes app\models\Recipe[] */
/* @var $pagination yii\data\Pagination */

$this->title = 'Мои избранные рецепты';
?>

<section class="section">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <p style="color: var(--muted); margin-bottom: 32px;">Рецепты, которые вам понравились</p>

        <div class="recipes-grid">
            <?php if (!empty($recipes)): ?>
                <?php foreach ($recipes as $recipe): ?>
                    <!-- Используем тот же шаблон карточки, что и везде -->
                    <?= $this->render('_recipeCard', ['recipe' => $recipe]) ?>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Заглушка, если список пуст -->
                <div style="grid-column: 1/-1; text-align: center; padding: 60px; background: var(--bg, #fff); border-radius: 16px; border: 1px dashed var(--border, #eee);">
                    <h3>Список избранного пуст 😔</h3>
                    <p style="margin-bottom: 20px; color: var(--muted);">Нажмите на сердечко ❤️ на любом рецепте, чтобы добавить его сюда.</p>
                    <a href="<?= \yii\helpers\Url::to(['site/recipes']) ?>" class="btn btn-primary">Перейти к рецептам</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Пагинация, если рецептов много -->
        <?php if (!empty($recipes) && $pagination->totalCount > $pagination->pageSize): ?>
            <div style="margin-top: 40px; display: flex; justify-content: center;">
                <?= LinkPager::widget([
                    'pagination' => $pagination,
                    'options' => ['class' => 'pagination'],
                ]) ?>
            </div>
        <?php endif; ?>
    </div>
</section>